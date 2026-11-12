<?php

namespace Municipal\Attestation\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Municipal\Attestation\Models\AttestationSignatory;
use Municipal\Attestation\Models\AttestationType;

class TypeController extends Controller
{
    public static function availableFieldTypes(): array
    {
        return [
            'text'              => 'সাধারণ টেক্সট (Text)',
            'textarea'          => 'বড় টেক্সট (Textarea)',
            'date'              => 'তারিখ (Date)',
            'number'            => 'সংখ্যা (Number)',
            'bn_number'         => 'বাংলা সংখ্যা (Bangla Number)',
            'select'            => 'ড্রপডাউন তালিকা (Select)',
            'amount_with_words' => 'টাকার পরিমাণ ও কথায় (Amount + Words)',
            'repeater'          => 'টেবিল / একাধিক সারি (Repeater Table)',
        ];
    }

    public function index(Request $r)
    {
        $page_title = 'প্রত্যয়নের ধরনসমূহ';

        $query = AttestationType::withCount(['applications', 'attestations'])
            ->orderBy('order')
            ->orderBy('id');

        if ($r->filled('q')) {
            $q = $r->input('q');
            $query->where(function ($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('memo_name', 'like', "%{$q}%")
                    ->orWhere('slug', 'like', "%{$q}%");
            });
        }

        if ($r->filled('status')) {
            if ($r->status === 'active') {
                $query->where('is_active', true);
            } elseif ($r->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $types = $query->paginate(30)->withQueryString();

        return view('attestation::admin.types.index', compact('page_title', 'types'));
    }

    public function create()
    {
        $page_title   = 'নতুন প্রত্যয়নের ধরন তৈরি করুন';
        $type         = new AttestationType([
            'subject_status' => 'living',
            'is_public'      => true,
            'is_active'      => true,
            'fee'            => 0,
            'order'          => (int) AttestationType::max('order') + 1,
            'closing_line'   => 'আমি তাঁর সার্বিক মঙ্গল কামনা করি।',
            'person_fields'  => ['applicant_name', 'id_no', 'father_name', 'mother_name', 'ward_no', 'holding_no', 'mohalla', 'upazila', 'district'],
            'print_options'  => ['with_header' => true, 'watermark' => true],
        ]);
        $signatories  = AttestationSignatory::orderBy('order')->orderBy('id')->get();
        $fieldTypes   = self::availableFieldTypes();
        $personFields = AttestationType::standardPersonFields();

        return view('attestation::admin.types.form', compact('page_title', 'type', 'signatories', 'fieldTypes', 'personFields'));
    }

    public function store(Request $r)
    {
        $data = $this->validateAndPrepare($r);
        $type = AttestationType::create($data);

        return redirect()->route('attestation.types.index')
            ->with('success', "'{$type->name}' সফলভাবে তৈরি করা হয়েছে।");
    }

    public function edit(AttestationType $type)
    {
        $page_title   = "সম্পাদনা: {$type->name}";
        $signatories  = AttestationSignatory::orderBy('order')->orderBy('id')->get();
        $fieldTypes   = self::availableFieldTypes();
        $personFields = AttestationType::standardPersonFields();

        return view('attestation::admin.types.form', compact('page_title', 'type', 'signatories', 'fieldTypes', 'personFields'));
    }

    public function update(Request $r, AttestationType $type)
    {
        $data = $this->validateAndPrepare($r, $type->id);
        $type->update($data);

        return redirect()->route('attestation.types.index')
            ->with('success', "'{$type->name}' সফলভাবে আপডেট করা হয়েছে।");
    }

    public function destroy(AttestationType $type)
    {
        $name = $type->name;
        $type->delete();

        return redirect()->route('attestation.types.index')
            ->with('success', "'{$name}' মুছে ফেলা হয়েছে।");
    }

    protected function validateAndPrepare(Request $r, ?int $ignoreId = null): array
    {
        $slugRule = 'nullable|string|max:120|unique:attestation_types,slug' . ($ignoreId ? ',' . $ignoreId : '');

        $r->validate([
            'name'           => 'required|string|max:255',
            'memo_name'      => 'required|string|max:120',
            'slug'           => $slugRule,
            'description'    => 'nullable|string',
            'subject_status' => 'required|in:living,deceased,either',
            'closing_line'   => 'nullable|string|max:500',
            'body_template'  => 'nullable|string',
            'fee'            => 'nullable|numeric|min:0',
            'order'          => 'nullable|integer|min:0',
            'person_fields'  => 'nullable|array',
        ]);

        $slug = trim((string) $r->input('slug'));
        if ($slug === '') {
            $slug = Str::slug($r->input('name')) ?: ('type-' . time());
            $base = $slug;
            $i = 1;
            while (AttestationType::withTrashed()->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
                $slug = "{$base}-{$i}";
                $i++;
            }
        }

        // Parse dynamic fields from JSON string if provided, otherwise from array
        $fields = [];
        if ($r->filled('fields_json')) {
            $decoded = json_decode($r->input('fields_json'), true);
            if (is_array($decoded)) {
                $fields = array_values($decoded);
            }
        } elseif (is_array($r->input('fields'))) {
            foreach ($r->input('fields') as $f) {
                if (!empty($f['key']) && !empty($f['label'])) {
                    $item = [
                        'key'      => trim($f['key']),
                        'label'    => trim($f['label']),
                        'type'     => $f['type'] ?? 'text',
                        'required' => !empty($f['required']),
                    ];
                    if (!empty($f['options'])) {
                        $item['options'] = is_array($f['options'])
                            ? $f['options']
                            : array_values(array_filter(array_map('trim', explode(',', $f['options']))));
                    }
                    if (!empty($f['columns']) && is_array($f['columns'])) {
                        $item['columns'] = array_values($f['columns']);
                    }
                    $fields[] = $item;
                }
            }
        }

        // Parse signatories slots
        $signatories = [];
        if (is_array($r->input('signatories'))) {
            foreach ($r->input('signatories') as $slot) {
                if (!empty($slot['signatory_id']) || !empty($slot['designation'])) {
                    $signatories[] = [
                        'signatory_id' => !empty($slot['signatory_id']) ? (int) $slot['signatory_id'] : null,
                        'preset_key'   => $slot['preset_key'] ?? null,
                        'label'        => $slot['label'] ?? null,
                        'designation'  => $slot['designation'] ?? null,
                    ];
                }
            }
        }

        $existingOpts = $ignoreId ? (AttestationType::find($ignoreId)?->print_options ?? []) : [];
        $printOptions = array_merge($existingOpts, [
            'with_header' => $r->boolean('with_header', true),
            'watermark'   => $r->boolean('watermark', true),
            'pad_top'     => (float) $r->input('pad_top', $existingOpts['pad_top'] ?? 1.5),
            'icon'        => $r->input('icon', $existingOpts['icon'] ?? '📜'),
            'language'    => $r->input('language', $existingOpts['language'] ?? 'bn'),
        ]);

        return [
            'name'           => $r->input('name'),
            'slug'           => $slug,
            'memo_name'      => $r->input('memo_name'),
            'description'    => $r->input('description'),
            'subject_status' => $r->input('subject_status', 'living'),
            'person_fields'  => array_values($r->input('person_fields', [])),
            'fields'         => $fields,
            'body_template'  => $r->input('body_template'),
            'closing_line'   => $r->input('closing_line'),
            'signatories'    => $signatories,
            'print_options'  => $printOptions,
            'fee'            => (float) $r->input('fee', 0),
            'is_public'      => $r->boolean('is_public'),
            'is_active'      => $r->boolean('is_active'),
            'order'          => (int) $r->input('order', 0),
        ];
    }
}

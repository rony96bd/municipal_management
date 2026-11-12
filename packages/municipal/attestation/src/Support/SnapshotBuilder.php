<?php

namespace Municipal\Attestation\Support;

use Municipal\Attestation\Models\AttestationApplication;
use Municipal\Attestation\Models\AttestationSignatory;
use Municipal\Attestation\Models\AttestationType;

class SnapshotBuilder
{
    public static function build(AttestationType $type, AttestationApplication $app): array
    {
        $org         = config('attestation.organization', []);
        $holderLabel = $org['holder_label'] ?? 'পৌর';
        $isEnglish   = ($type->language === 'en');

        $formatNum = fn (?string $val) => $val
            ? ($isEnglish ? BengaliHelper::toEnglishDigits($val) : BengaliHelper::toBengaliDigits($val))
            : '-';

        $person = [
            'applicant_name' => $app->applicant_name,
            'name'           => $app->applicant_name,
            'mobile'         => $app->mobile,
            'id_type'        => $app->id_type ?? 'nid',
            'id_no'          => $formatNum($app->id_no),
            'nid'            => $formatNum($app->id_no),
            'father_name'    => $app->father_name ?: '-',
            'mother_name'    => $app->mother_name ?: '-',
            'spouse_name'    => $app->spouse_name ?: '-',
            'ward_no'        => $formatNum($app->ward_no),
            'holding_no'     => $formatNum($app->holding_no),
            'mohalla'        => $app->mohalla ?: '-',
            'upazila'        => $app->upazila ?: ($isEnglish ? 'Alamdanga' : ($org['default_upazila'] ?? 'আলমডাঙ্গা')),
            'district'       => $app->district ?: ($isEnglish ? 'Chuadanga' : ($org['default_district'] ?? 'চুয়াডাঙ্গা')),
        ];

        $data = is_array($app->data) ? $app->data : [];

        // Auto-populate amount_with_words and bn_number fields
        foreach ($type->fields ?? [] as $field) {
            if (($field['type'] ?? '') === 'amount_with_words') {
                $key = $field['key'] ?? '';
                if ($key && isset($data[$key])) {
                    $num = (int) preg_replace('/[^\d]/', '', BengaliHelper::toEnglishDigits((string) $data[$key]));
                    $data[$key . '_words'] = !empty($data[$key . '_words'])
                        ? $data[$key . '_words']
                        : BengaliHelper::numberToWords($num);
                    $data[$key] = $isEnglish
                        ? number_format($num)
                        : BengaliHelper::toBengaliDigits(number_format($num));
                }
            } elseif (($field['type'] ?? '') === 'bn_number') {
                $key = $field['key'] ?? '';
                if ($key && isset($data[$key])) {
                    $data[$key] = $isEnglish
                        ? BengaliHelper::toEnglishDigits((string) $data[$key])
                        : BengaliHelper::toBengaliDigits((string) $data[$key]);
                }
            }
        }

        // Build person rows for the certificate table
        $isDeceased = ($type->subject_status === 'deceased') || (($data['subject_status'] ?? '') === 'deceased');

        if ($isEnglish) {
            $nameLabel = $isDeceased ? 'Name of Deceased' : 'Name';
            $idLabel   = match ($app->id_type) {
                'birth_reg' => 'Birth Registration No',
                'death_reg' => 'Death Registration No',
                default     => 'National ID (NID) No',
            };
            $allLabels = [
                'applicant_name' => $nameLabel,
                'id_no'          => $idLabel,
                'father_name'    => "Father's Name",
                'mother_name'    => "Mother's Name",
                'spouse_name'    => 'Husband / Wife Name',
                'ward_no'        => 'Ward No',
                'holding_no'     => 'Holding No',
                'mohalla'        => 'Village / Road / Mohalla',
                'upazila'        => 'Upazila & District',
            ];
        } else {
            $nameLabel = $isDeceased ? 'মৃত ব্যক্তির নাম' : 'নাম';
            $idLabel   = $app->idTypeLabel();
            $allLabels = [
                'applicant_name' => $nameLabel,
                'id_no'          => $idLabel,
                'father_name'    => 'পিতার নাম',
                'mother_name'    => 'মাতার নাম',
                'spouse_name'    => 'স্বামী / স্ত্রীর নাম',
                'ward_no'        => "{$holderLabel} ওয়ার্ড নম্বর",
                'holding_no'     => 'হোল্ডিং নম্বর',
                'mohalla'        => 'মহল্লা / গ্রাম',
                'upazila'        => 'উপজেলা / জেলা',
            ];
        }

        $activePersonFields = $type->person_fields ?: ['applicant_name', 'id_no', 'father_name', 'mother_name', 'ward_no', 'holding_no', 'mohalla', 'upazila'];
        $personRows = [];

        foreach ($activePersonFields as $pf) {
            if ($pf === 'district') {
                continue;
            }
            if ($pf === 'upazila') {
                $personRows[] = [
                    'label' => $allLabels['upazila'],
                    'value' => $isEnglish
                        ? "Upazila: {$person['upazila']}, District: {$person['district']}"
                        : ("উপজেলা: {$person['upazila']}, জেলা: {$person['district']} — এর " . ($isDeceased ? 'স্থায়ী বাসিন্দা ছিলেন' : 'স্থায়ী বাসিন্দা')),
                ];
                continue;
            }
            if (isset($allLabels[$pf])) {
                $val = $person[$pf] ?? '-';
                if ($pf === 'spouse_name' && ($val === '-' || $val === '')) {
                    continue;
                }
                $personRows[] = [
                    'label' => $allLabels[$pf],
                    'value' => $val,
                ];
            }
        }

        // Merge person + dynamic data for template rendering
        $mergedData   = array_merge($person, $data);
        $renderedBody = !empty($data['_override_body'])
            ? TemplateRenderer::render((string) $data['_override_body'], $mergedData)
            : TemplateRenderer::render((string) $type->body_template, $mergedData);

        // Extract repeater tables
        $tables = [];
        foreach ($type->fields ?? [] as $field) {
            if (($field['type'] ?? '') === 'repeater') {
                $key  = $field['key'] ?? '';
                $rows = $data[$key] ?? [];
                if ($key && is_array($rows) && count($rows) > 0) {
                    // Filter out completely empty rows
                    $nonEmptyRows = array_values(array_filter($rows, function ($r) {
                        if (!is_array($r)) {
                            return false;
                        }
                        foreach ($r as $v) {
                            if (trim((string) $v) !== '') {
                                return true;
                            }
                        }
                        return false;
                    }));
                    if (count($nonEmptyRows) > 0) {
                        $tables[] = [
                            'key'     => $key,
                            'label'   => $field['label'] ?? '',
                            'columns' => $field['columns'] ?? [],
                            'rows'    => $nonEmptyRows,
                        ];
                    }
                }
            }
        }

        // Resolve signatories
        $resolvedSignatories = [];
        $signatoriesMap      = AttestationSignatory::all()->keyBy('id');
        $presetMap           = AttestationSignatory::whereNotNull('preset_key')->get()->keyBy('preset_key');

        foreach ($type->signatories ?? [] as $idx => $slot) {
            $sig = null;
            if (!empty($slot['signatory_id']) && isset($signatoriesMap[$slot['signatory_id']])) {
                $sig = $signatoriesMap[$slot['signatory_id']];
            } elseif (!empty($slot['preset_key']) && isset($presetMap[$slot['preset_key']])) {
                $sig = $presetMap[$slot['preset_key']];
            }

            $overrideSig = $data['_override_signatories'][$idx] ?? [];

            $resolvedSignatories[] = [
                'label'       => !empty($overrideSig['label']) ? $overrideSig['label'] : ($slot['label'] ?? null),
                'name'        => !empty($overrideSig['name']) ? $overrideSig['name'] : ($sig?->name ?? ($slot['name'] ?? null)),
                'designation' => !empty($overrideSig['designation']) ? $overrideSig['designation'] : ($sig?->designation ?? ($slot['designation'] ?? ($isEnglish ? 'Pouro Nirbahi Officer' : 'পৌর নির্বাহী কর্মকর্তা'))),
                'office_line' => $sig?->office_line ?? ($isEnglish ? 'Alamdanga Pourashava' : ($org['name'] ?? 'আলমডাঙ্গা পৌরসভা')),
                'extra_line'  => $sig?->extra_line ?? ($isEnglish ? 'Alamdanga, Chuadanga' : ($org['sub_title'] ?? 'আলমডাঙ্গা, চুয়াডাঙ্গা')),
            ];
        }

        if (empty($resolvedSignatories)) {
            $defaultSig = $presetMap->get($isEnglish ? 'EN_A' : 'A');
            $resolvedSignatories[] = [
                'label'       => null,
                'name'        => $defaultSig?->name,
                'designation' => $defaultSig?->designation ?? ($isEnglish ? 'Pouro Nirbahi Officer' : 'পৌর নির্বাহী কর্মকর্তা'),
                'office_line' => $defaultSig?->office_line ?? ($isEnglish ? 'Alamdanga Pourashava' : ($org['name'] ?? 'আলমডাঙ্গা পৌরসভা')),
                'extra_line'  => $defaultSig?->extra_line ?? ($isEnglish ? 'Alamdanga, Chuadanga' : ($org['sub_title'] ?? 'আলমডাঙ্গা, চুয়াডাঙ্গা')),
            ];
        }

        $defaultLead = $isEnglish
            ? 'This is to certify that,'
            : ($isDeceased ? 'এই মর্মে প্রত্যয়ন পত্র প্রদান করা যাচ্ছে যে,' : 'এতদ্বারা প্রত্যয়ন করা যাচ্ছে যে,');

        $defaultClosing = $isEnglish
            ? ($isDeceased ? 'May the Almighty grant eternal peace to the departed soul.' : 'I wish him/her every success and prosperity in life.')
            : ($isDeceased ? 'আমি তাঁর আত্মার মাগফিরাত কামনা করি।' : 'আমি তাঁর সার্বিক মঙ্গল কামনা করি।');

        return [
            'type_id'             => $type->id,
            'type_name'           => !empty($data['_override_title']) ? $data['_override_title'] : $type->name,
            'type_slug'           => $type->slug,
            'memo_name'           => $type->memo_name,
            'language'            => $isEnglish ? 'en' : 'bn',
            'subject_status'      => $isDeceased ? 'deceased' : 'living',
            'lead_line'           => !empty($data['_override_lead']) ? $data['_override_lead'] : $defaultLead,
            'person'              => $person,
            'person_rows'         => $personRows,
            'data'                => $data,
            'tables'              => $tables,
            'rendered_body'       => $renderedBody,
            'override_html'       => !empty($data['_override_html']) ? $data['_override_html'] : null,
            'closing_line'        => !empty($data['_override_closing']) ? $data['_override_closing'] : ($type->closing_line ?: $defaultClosing),
            'signatories'         => $resolvedSignatories,
            'guardian_signatures' => !empty($type->print_options['guardian_signatures']) || $type->slug === 'obhibhabak-sommoti',
            'print_options'       => $type->print_options ?? ['with_header' => true, 'watermark' => true],
            'organization'        => $org,
        ];
    }
}

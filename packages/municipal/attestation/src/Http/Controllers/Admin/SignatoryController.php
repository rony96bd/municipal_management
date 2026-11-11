<?php

namespace Municipal\Attestation\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Municipal\Attestation\Models\AttestationSignatory;

class SignatoryController extends Controller
{
    public function index()
    {
        $page_title  = 'স্বাক্ষরকারী কর্মকর্তাগণ';
        $signatories = AttestationSignatory::orderBy('order')->orderBy('id')->get();

        return view('attestation::admin.signatories.index', compact('page_title', 'signatories'));
    }

    public function create()
    {
        $page_title = 'নতুন স্বাক্ষরকারী যোগ করুন';
        $signatory  = new AttestationSignatory([
            'office_line' => config('attestation.organization.name', 'আলমডাঙ্গা পৌরসভা'),
            'extra_line'  => config('attestation.organization.sub_title', 'আলমডাঙ্গা, চুয়াডাঙ্গা'),
            'is_active'   => true,
            'order'       => (int) AttestationSignatory::max('order') + 1,
        ]);

        return view('attestation::admin.signatories.form', compact('page_title', 'signatory'));
    }

    public function store(Request $r)
    {
        $data = $this->validateData($r);
        AttestationSignatory::create($data);

        return redirect()->route('attestation.signatories.index')
            ->with('success', 'স্বাক্ষরকারী সফলভাবে যুক্ত করা হয়েছে।');
    }

    public function edit(AttestationSignatory $signatory)
    {
        $page_title = "স্বাক্ষরকারী সম্পাদনা: {$signatory->designation}";

        return view('attestation::admin.signatories.form', compact('page_title', 'signatory'));
    }

    public function update(Request $r, AttestationSignatory $signatory)
    {
        $data = $this->validateData($r);
        $signatory->update($data);

        return redirect()->route('attestation.signatories.index')
            ->with('success', 'স্বাক্ষরকারীর তথ্য আপডেট করা হয়েছে।');
    }

    public function destroy(AttestationSignatory $signatory)
    {
        $signatory->delete();

        return redirect()->route('attestation.signatories.index')
            ->with('success', 'স্বাক্ষরকারী মুছে ফেলা হয়েছে।');
    }

    protected function validateData(Request $r): array
    {
        $r->validate([
            'preset_key'  => 'nullable|string|max:10',
            'name'        => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'office_line' => 'nullable|string|max:255',
            'extra_line'  => 'nullable|string|max:255',
            'order'       => 'nullable|integer|min:0',
        ]);

        return [
            'preset_key'  => $r->input('preset_key'),
            'name'        => $r->input('name'),
            'designation' => $r->input('designation'),
            'office_line' => $r->input('office_line'),
            'extra_line'  => $r->input('extra_line'),
            'is_active'   => $r->boolean('is_active', true),
            'order'       => (int) $r->input('order', 0),
        ];
    }
}

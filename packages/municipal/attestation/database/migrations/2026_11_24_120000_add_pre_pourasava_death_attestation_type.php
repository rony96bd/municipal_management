<?php

use Illuminate\Database\Migrations\Migration;
use Municipal\Attestation\Models\AttestationType;

return new class extends Migration
{
    public function up(): void
    {
        AttestationType::updateOrCreate(
            ['slug' => 'mrityu-pratyayan-pourasava-purbe'],
            [
                'order'          => 17,
                'name'           => 'মৃত্যু প্রত্যয়ন পত্র (পৌরসভা প্রতিষ্ঠিত হওয়ার পূর্বে)',
                'memo_name'      => 'মৃত্যু প্রত্যয়ন',
                'description'    => 'পৌরসভা প্রতিষ্ঠার পূর্বে মৃত্যুবরণকারী ব্যক্তির জন্য (মৃত্যু রেজিস্টারে তথ্য নেই)',
                'subject_status' => 'deceased',
                'person_fields'  => ['applicant_name', 'id_no', 'father_name', 'spouse_name', 'mother_name', 'ward_no', 'mohalla', 'upazila', 'district'],
                'fields'         => [
                    ['key' => 'death_cause', 'label' => 'মৃত্যুর কারণ', 'type' => 'text', 'required' => true, 'default' => 'বার্ধক্য জনিত'],
                    ['key' => 'investigator_designation', 'label' => 'তদন্তকারীর পদবী', 'type' => 'text', 'required' => true, 'default' => 'টিকাদানকারী'],
                    ['key' => 'investigator_name', 'label' => 'তদন্তকারীর নাম', 'type' => 'text', 'required' => true, 'default' => 'মোঃ মানোয়ার হোসেন'],
                ],
                'body_template'  => 'উল্লেখিত মৃত ব্যক্তি পৌরসভা প্রতিষ্ঠিত হওয়ার পূর্বে **{{death_cause}}** কারণে মৃত্যু বরণ করেছেন। যার কারণে পৌরসভার মৃত্যু রেজিস্টারে মৃত্যু তথ্য লিপিবদ্ধ হয় নাই। অত্রাফিসের {{investigator_designation}} **{{investigator_name}}** এর সরেজমিনে তদন্ত পূর্বক অত্র মৃত্যু প্রত্যয়ন পত্র প্রদান করা হলো।',
                'closing_line'   => 'আমি তাঁর আত্মার মাগফিরাত কামনা করি।',
                'signatories'    => [['preset_key' => 'E1'], ['preset_key' => 'A']],
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '🕯️', 'language' => 'bn', 'certificate_title' => 'মৃত্যু প্রত্যয়ন পত্র'],
                'fee'            => 0,
                'is_public'      => true,
                'is_active'      => true,
            ]
        );
    }

    public function down(): void
    {
        AttestationType::where('slug', 'mrityu-pratyayan-pourasava-purbe')->delete();
    }
};

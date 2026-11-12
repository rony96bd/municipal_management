<?php

namespace Municipal\Attestation\Database\Seeders;

use Illuminate\Database\Seeder;
use Municipal\Attestation\Models\AttestationSignatory;

class AttestationSignatorySeeder extends Seeder
{
    public function run(): void
    {
        $orgName  = config('attestation.organization.name', 'আলমডাঙ্গা পৌরসভা');
        $subTitle = config('attestation.organization.sub_title', 'আলমডাঙ্গা, চুয়াডাঙ্গা');

        $items = [
            [
                'preset_key'  => 'A',
                'name'        => 'মোঃ রাকীবুল ইসলাম',
                'designation' => 'পৌর নির্বাহী কর্মকর্তা',
                'office_line' => $orgName,
                'extra_line'  => $subTitle,
                'order'       => 1,
            ],
            [
                'preset_key'  => 'B1',
                'name'        => 'মোঃ মাহফুজুর রহমান',
                'designation' => 'স্যানিটারী ইন্সপেক্টর',
                'office_line' => $orgName,
                'extra_line'  => $subTitle,
                'order'       => 2,
            ],
            [
                'preset_key'  => 'C1',
                'name'        => 'মোঃ মাহফুজুর রহমান',
                'designation' => 'প্রধান সহকারী(অতিঃদাঃ)',
                'office_line' => $orgName,
                'extra_line'  => $subTitle,
                'order'       => 3,
            ],
            [
                'preset_key'  => 'D1',
                'name'        => 'মোঃ হাফিজুর রহমান',
                'designation' => 'সিএ(অতিঃদাঃ)',
                'office_line' => $orgName,
                'extra_line'  => $subTitle,
                'order'       => 4,
            ],
            [
                'preset_key'  => 'D3',
                'name'        => 'বলরাম ঘোষ',
                'designation' => 'সমাজ উন্নয়ন কর্মকর্তা',
                'office_line' => $orgName,
                'extra_line'  => $subTitle,
                'order'       => 5,
            ],
            [
                'preset_key'  => 'E1',
                'name'        => null,
                'designation' => 'স্বাস্থ্য সহকারী ও দায়িত্বপ্রাপ্ত কর্মচারী (জন্ম ও মৃত্যু নিবন্ধন শাখা)',
                'office_line' => $orgName,
                'extra_line'  => $subTitle,
                'order'       => 6,
            ],
            [
                'preset_key'  => 'F',
                'name'        => null,
                'designation' => 'উপজেলা সমাজ সেবা কর্মকর্তা ও দায়িত্বপ্রাপ্ত কর্মকর্তা (৩, ৪ ও ৯নং ওয়ার্ড)',
                'office_line' => $orgName,
                'extra_line'  => $subTitle,
                'order'       => 7,
            ],
            [
                'preset_key'  => 'EN_A',
                'name'        => 'Md. Rakibul Islam',
                'designation' => 'Pouro Nirbahi Officer',
                'office_line' => 'Alamdanga Pourashava',
                'extra_line'  => 'Alamdanga, Chuadanga',
                'order'       => 8,
            ],
            [
                'preset_key'  => 'EN_D1',
                'name'        => 'Md. Hafizur Rahman',
                'designation' => 'CA (Addl. Charge)',
                'office_line' => 'Alamdanga Pourashava',
                'extra_line'  => 'Alamdanga, Chuadanga',
                'order'       => 9,
            ],
            [
                'preset_key'  => 'EN_C1',
                'name'        => 'Md. Mahfuzur Rahman',
                'designation' => 'Head Assistant (Addl. Charge)',
                'office_line' => 'Alamdanga Pourashava',
                'extra_line'  => 'Alamdanga, Chuadanga',
                'order'       => 10,
            ],
            [
                'preset_key'  => 'EN_D3',
                'name'        => 'Balaram Ghosh',
                'designation' => 'Community Development Officer',
                'office_line' => 'Alamdanga Pourashava',
                'extra_line'  => 'Alamdanga, Chuadanga',
                'order'       => 11,
            ],
        ];

        foreach ($items as $item) {
            AttestationSignatory::updateOrCreate(
                ['preset_key' => $item['preset_key']],
                array_merge($item, ['is_active' => true])
            );
        }
    }
}

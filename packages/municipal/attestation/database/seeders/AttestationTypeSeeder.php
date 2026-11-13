<?php

namespace Municipal\Attestation\Database\Seeders;

use Illuminate\Database\Seeder;
use Municipal\Attestation\Models\AttestationType;

class AttestationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $stdPerson      = ['applicant_name', 'id_no', 'father_name', 'mother_name', 'ward_no', 'holding_no', 'mohalla', 'upazila', 'district'];
        $marriedPerson  = ['applicant_name', 'id_no', 'father_name', 'mother_name', 'spouse_name', 'ward_no', 'holding_no', 'mohalla', 'upazila', 'district'];
        $deceasedPerson = ['applicant_name', 'id_no', 'father_name', 'mother_name', 'ward_no', 'mohalla', 'upazila', 'district'];

        $presetA = [['preset_key' => 'A']];
        $presetB = [['preset_key' => 'B1'], ['preset_key' => 'A']];
        $presetC = [['preset_key' => 'C1'], ['preset_key' => 'A']];
        $presetD = [
            ['preset_key' => 'D1', 'label' => 'প্রস্তুতকারী'],
            ['preset_key' => 'C1', 'label' => 'যাচাইকারী'],
            ['preset_key' => 'D3', 'label' => 'অনুমোদনকারী কর্মকর্তা'],
        ];
        $presetE = [['preset_key' => 'E1'], ['preset_key' => 'A']];
        $presetF = [['preset_key' => 'F']];

        $presetEnA = [['preset_key' => 'EN_A']];
        $presetEnD = [
            ['preset_key' => 'EN_D1', 'label' => 'Prepared By'],
            ['preset_key' => 'EN_C1', 'label' => 'Verified By'],
            ['preset_key' => 'EN_D3', 'label' => 'Approving Officer'],
        ];

        $wishGeneral  = 'আমি তাঁর সার্বিক মঙ্গল কামনা করি।';
        $wishBusiness = 'আমি তাঁর ব্যবসায়িক মঙ্গল কামনা করি।';
        $wishDeceased = 'আমি তাঁর আত্মার মাগফিরাত কামনা করি।';
        $wishPlural   = 'আমি তাদের সার্বিক মঙ্গল কামনা করি।';
        $wishEn       = 'I wish him/her every success and prosperity in life.';
        $wishEnPlural = 'I wish them every success and prosperity in life.';
        $wishEnDec    = 'May the Almighty grant eternal peace to the departed soul.';

        $types = [
            // 01. Character Certificate
            [
                'order'          => 1,
                'name'           => 'Character Certificate',
                'slug'           => 'en-character-certificate',
                'memo_name'      => 'Character Certificate',
                'description'    => 'চারিত্রিক সনদ (ইংরেজি)',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'The above-mentioned person is permanently residing at the stated address within Alamdanga Pourashava. To the best of my knowledge, **he/she bears a good moral character** and is not involved in any anti-state or anti-social activities.',
                'closing_line'   => $wishEn,
                'signatories'    => $presetEnD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏅', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 02. Nationality Certificate
            [
                'order'          => 2,
                'name'           => 'Nationality Certificate',
                'slug'           => 'en-nationality-certificate',
                'memo_name'      => 'Nationality Certificate',
                'description'    => 'জাতীয়তা সনদ (ইংরেজি)',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'citizen_by', 'label' => 'Citizen By (e.g. by birth)', 'type' => 'select', 'options' => ['by birth', 'by descent', 'by registration'], 'required' => false],
                ],
                'body_template'  => 'The above-named person is personally known to me. He/She is a permanent resident of Alamdanga Pourashava and a **citizen of Bangladesh {{citizen_by}}**. To the best of my knowledge, he/she bears a good moral character.',
                'closing_line'   => $wishEn,
                'signatories'    => $presetEnD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🆔', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 03. Unmarried Certification
            [
                'order'          => 3,
                'name'           => 'Unmarried Certification',
                'slug'           => 'en-unmarried-certificate',
                'memo_name'      => 'Unmarried Certification',
                'description'    => 'অবিবাহিত সনদ (ইংরেজি)',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'To the best of my knowledge, the above-mentioned person is still **unmarried (single)** and bears a good moral character.',
                'closing_line'   => $wishEn,
                'signatories'    => $presetEnD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🧍', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 04. Married Certification
            [
                'order'          => 4,
                'name'           => 'Married Certification',
                'slug'           => 'en-married-certificate',
                'memo_name'      => 'Married Certification',
                'description'    => 'বিবাহিত সনদ (ইংরেজি)',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [
                    ['key' => 'spouse_nid', 'label' => 'Spouse NID / Passport No', 'type' => 'text', 'required' => false],
                    [
                        'key'     => 'nikah_details',
                        'label'   => 'Marriage Registration (Nikah-nama) Details',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'volume_no', 'label' => 'Volume No'],
                            ['key' => 'reg_date', 'label' => 'Registration Date'],
                            ['key' => 'case_no', 'label' => 'Case / Serial No'],
                            ['key' => 'page_no', 'label' => 'Page No & Year'],
                        ],
                    ],
                ],
                'body_template'  => 'The above-mentioned person is **legally married** to **{{spouse_name}}** (NID/Passport: {{spouse_nid}}). Their marriage is duly registered as per the Nikah-nama details below.',
                'closing_line'   => $wishEnPlural,
                'signatories'    => $presetEnD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💍', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 05. Family Relation Certificate
            [
                'order'          => 5,
                'name'           => 'Family Relation Certificate',
                'slug'           => 'en-family-certificate',
                'memo_name'      => 'Family Relation Certificate',
                'description'    => 'পারিবারিক সনদ (ইংরেজি)',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key'     => 'family_members',
                        'label'   => 'Family Members List (English)',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'sl', 'label' => 'SL'],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'relation', 'label' => 'Relation'],
                            ['key' => 'dob', 'label' => 'Date of Birth / Age'],
                            ['key' => 'nid', 'label' => 'NID / Birth Reg. No'],
                            ['key' => 'remarks', 'label' => 'Present Address / Remarks'],
                        ],
                    ],
                ],
                'body_template'  => 'The following individuals are the bona fide **family members** of **{{applicant_name}}**:',
                'closing_line'   => $wishEnPlural,
                'signatories'    => $presetEnD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '👨‍👩‍👧', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 06. Death Certificate (2026)
            [
                'order'          => 6,
                'name'           => 'Death Certificate (Register Format)',
                'slug'           => 'en-death-register-certificate',
                'memo_name'      => 'Death Certificate',
                'description'    => 'মৃত্যু সনদ — রেজিস্টার ফরম্যাট (ইংরেজি)',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    ['key' => 'death_date', 'label' => 'Date of Death', 'type' => 'date', 'required' => true],
                    ['key' => 'death_cause', 'label' => 'Cause of Death', 'type' => 'text', 'required' => true],
                    ['key' => 'register_no', 'label' => 'Death Register No', 'type' => 'text', 'required' => false],
                    ['key' => 'page_no', 'label' => 'Page No', 'type' => 'text', 'required' => false],
                    ['key' => 'serial_no', 'label' => 'Entry Serial No', 'type' => 'text', 'required' => false],
                ],
                'body_template'  => 'The above-mentioned deceased person passed away on **{{death_date}}** due to **{{death_cause}}**. The death record is duly registered in the Municipal Death Register under Volume/Register No: **{{register_no}}**, Page No: **{{page_no}}**, Serial No: **{{serial_no}}**.',
                'closing_line'   => $wishEnDec,
                'signatories'    => $presetEnD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🕯️', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 07. Death Certificate
            [
                'order'          => 7,
                'name'           => 'Death Certificate (Descriptive)',
                'slug'           => 'en-death-descriptive-certificate',
                'memo_name'      => 'Death Certificate',
                'description'    => 'মৃত্যু সনদ — বর্ণনামূলক (ইংরেজি)',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    ['key' => 'death_date', 'label' => 'Date of Death', 'type' => 'date', 'required' => true],
                    ['key' => 'death_place', 'label' => 'Place of Death', 'type' => 'text', 'required' => false],
                    ['key' => 'death_cause', 'label' => 'Cause of Death', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'The above-named person was a permanent resident of Alamdanga Pourashava. He/She passed away on **{{death_date}}** at **{{death_place}}** due to **{{death_cause}}**.',
                'closing_line'   => $wishEnDec,
                'signatories'    => $presetEnD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🕊️', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 08. Authorization Letter
            [
                'order'          => 8,
                'name'           => 'Authorization Letter',
                'slug'           => 'en-authorization-letter',
                'memo_name'      => 'Authorization Letter',
                'description'    => 'ক্ষমতা অর্পণ পত্র (ইংরেজি)',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    ['key' => 'authorized_person', 'label' => 'Authorized Heir Name', 'type' => 'text', 'required' => true],
                    ['key' => 'authorized_relation', 'label' => 'Relation with Deceased', 'type' => 'text', 'required' => true],
                    [
                        'key'     => 'grantors',
                        'label'   => 'Heirs Granting Authorization',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'sl', 'label' => 'SL'],
                            ['key' => 'name', 'label' => 'Name'],
                            ['key' => 'relation', 'label' => 'Relation with Deceased'],
                            ['key' => 'age', 'label' => 'Age'],
                            ['key' => 'marital_status', 'label' => 'Marital Status'],
                        ],
                    ],
                ],
                'body_template'  => 'All legal heirs of late **{{applicant_name}}** have unanimously authorized **{{authorized_person}}** ({{authorized_relation}}) to receive, withdraw, and settle all financial claims, dues, and benefits on behalf of the deceased\'s family.',
                'closing_line'   => $wishEnPlural,
                'signatories'    => $presetEnA,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🤝', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 09. Trade License
            [
                'order'          => 9,
                'name'           => 'Trade License (English)',
                'slug'           => 'en-trade-license',
                'memo_name'      => 'Trade License',
                'description'    => 'ট্রেড লাইসেন্স সনদ (ইংরেজি)',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'license_no', 'label' => 'Trade License No', 'type' => 'text', 'required' => true],
                    ['key' => 'business_name', 'label' => 'Name of Business / Firm', 'type' => 'text', 'required' => true],
                    ['key' => 'business_type', 'label' => 'Nature / Type of Business', 'type' => 'text', 'required' => true],
                    ['key' => 'business_address', 'label' => 'Business Address / Market', 'type' => 'text', 'required' => true],
                    ['key' => 'fiscal_year', 'label' => 'Fiscal Year (e.g. 2025-2026)', 'type' => 'text', 'required' => true],
                    [
                        'key'     => 'financial_statement',
                        'label'   => 'Fee & Tax Statement',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'sl', 'label' => 'SL'],
                            ['key' => 'particulars', 'label' => 'Particulars'],
                            ['key' => 'amount', 'label' => 'Amount (BDT)'],
                        ],
                    ],
                ],
                'body_template'  => 'This is to certify that **{{applicant_name}}**, Proprietor of **"{{business_name}}"** (Nature of Business: **{{business_type}}**, Business Address: {{business_address}}), holds a valid Trade License bearing No: **{{license_no}}** for the Fiscal Year **{{fiscal_year}}** issued by Alamdanga Pourashava.',
                'closing_line'   => $wishEn,
                'signatories'    => $presetEnA,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏪', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 10. Child Dose of Vaccine
            [
                'order'          => 10,
                'name'           => 'Child Dose of Vaccine (Children Card)',
                'slug'           => 'en-vaccine-card',
                'memo_name'      => 'Vaccine Certificate',
                'description'    => 'শিশুর টিকা কার্ড সনদ (ইংরেজি)',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'child_dob', 'label' => 'Child Date of Birth', 'type' => 'date', 'required' => true],
                    ['key' => 'sex', 'label' => 'Sex (Male/Female)', 'type' => 'select', 'options' => ['Male', 'Female'], 'required' => false],
                    ['key' => 'reg_no', 'label' => 'EPI Registration No', 'type' => 'text', 'required' => false],
                    [
                        'key'     => 'vaccine_doses',
                        'label'   => 'Immunization / Vaccine Doses Record',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'vaccine', 'label' => 'Name of Vaccine (BCG/Pentavalent/OPV/PCV/MR)'],
                            ['key' => 'dose_1', 'label' => 'Dose 1 Date'],
                            ['key' => 'dose_2', 'label' => 'Dose 2 Date'],
                            ['key' => 'dose_3', 'label' => 'Dose 3 Date'],
                            ['key' => 'remarks', 'label' => 'Remarks'],
                        ],
                    ],
                ],
                'body_template'  => 'This is to certify that **{{applicant_name}}** (Date of Birth: **{{child_dob}}**, Sex: **{{sex}}**, EPI Reg. No: **{{reg_no}}**) has been immunized with the scheduled EPI vaccines under Alamdanga Pourashava as detailed below:',
                'closing_line'   => $wishEn,
                'signatories'    => $presetEnD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💉', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 11. হোল্ডিং ট্যাক্স প্রত্যয়ন পত্র
            [
                'order'          => 11,
                'name'           => 'হোল্ডিং ট্যাক্স প্রত্যয়ন পত্র',
                'slug'           => 'holding-tax-sonod',
                'memo_name'      => 'হোল্ডিং ট্যাক্স প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'tax_payer_status',
                        'label' => 'করদাতার ধরন (মালিক/ভাড়াটিয়া)',
                        'type' => 'select',
                        'options' => ['মালিক', 'ভাড়াটিয়া/ভোগদখলকারী'],
                        'required' => true,
                    ],
                    [
                        'key' => 'annual_val',
                        'label' => 'বার্ষিক মূল্যায়ন (টাকা)',
                        'type' => 'bn_number',
                        'required' => false,
                    ],
                    [
                        'key' => 'paid_up_to',
                        'label' => 'কর পরিশোধকৃত অর্থবছর (পর্যন্ত)',
                        'type' => 'text',
                        'placeholder' => 'যেমন: ২০২৫-২০২৬',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার {{ward_no}} নং ওয়ার্ডের {{holding_no}} নং হোল্ডিং এর {{tax_payer_status}}। অত্র পৌরসভার রেকর্ড অনুযায়ী তিনি একজন নিয়মিত পৌর হোল্ডিং কর পরিশোধকারী এবং **{{paid_up_to}}** অর্থবছর পর্যন্ত তাঁর যাবতীয় পৌর কর পরিশোধিত রহিয়াছে। অত্র পৌরসভায় তাঁর কোনো কর বকেয়া নাই।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetB,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏠', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 12. পারিবারিক সনদ পত্র
            [
                'order'          => 12,
                'name'           => 'পারিবারিক সনদ পত্র',
                'slug'           => 'paribarik-sonod',
                'memo_name'      => 'পারিবারিক সনদ পত্র',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'occupation', 'label' => 'পেশা', 'type' => 'text', 'required' => false],
                    [
                        'key'     => 'family_members',
                        'label'   => 'পরিবারের সদস্যদের তালিকা',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'sl', 'label' => 'ক্রম'],
                            ['key' => 'name', 'label' => 'নাম'],
                            ['key' => 'relation', 'label' => 'সম্পর্ক'],
                            ['key' => 'dob', 'label' => 'জন্ম তারিখ/বয়স'],
                            ['key' => 'nid', 'label' => 'জাতীয় পরিচয়পত্র/জন্ম নিবন্ধন নং'],
                            ['key' => 'address', 'label' => 'বর্তমান ঠিকানা'],
                        ],
                    ],
                ],
                'body_template'  => 'নিম্নবর্ণিত ব্যক্তিগণ **{{applicant_name}}** এর পরিবারের সদস্য হিসেবে প্রতীয়মান হওয়ায় নিম্নে তাদের নাম ও বিবরণ প্রদত্ত হলোঃ',
                'closing_line'   => $wishPlural,
                'signatories'    => $presetC,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '👨‍👩‍👧', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 13. ওয়ারিশ সনদ পত্র
            [
                'order'          => 13,
                'name'           => 'ওয়ারিশ সনদ পত্র',
                'slug'           => 'warish-sonod',
                'memo_name'      => 'ওয়ারিশ সনদ',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    ['key' => 'councillor_name', 'label' => 'তদারককারী কর্মকর্তা / কাউন্সিলরের নাম', 'type' => 'text', 'required' => false],
                    [
                        'key'     => 'heirs',
                        'label'   => 'ওয়ারিশগণের তালিকা',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'sl', 'label' => 'ক্রম'],
                            ['key' => 'name', 'label' => 'ওয়ারিশগণের নাম'],
                            ['key' => 'relation', 'label' => 'মৃতের সাথে সম্পর্ক'],
                            ['key' => 'nid', 'label' => 'জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন নং'],
                            ['key' => 'remarks', 'label' => 'মন্তব্য'],
                        ],
                    ],
                ],
                'body_template'  => 'মৃত **{{applicant_name}}** অত্র পৌরসভার স্থায়ী বাসিন্দা ছিলেন। মৃত্যুকালে তিনি নিম্নলিখিত ওয়ারিশগণকে রেখে মৃত্যুবরণ করেন। ({{councillor_name}} এর সুপারিশক্রমে প্রদত্ত)। ভবিষ্যতে ওয়ারিশ সংক্রান্ত কোন তথ্য গোপন বা ভুল প্রমাণিত হলে আবেদনকারী দায়ী থাকবেন এবং অত্র সনদ বাতিল বলে গণ্য হবে।',
                'closing_line'   => $wishPlural,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '📜', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 14. উত্তরাধিকার সনদ পত্র
            [
                'order'          => 14,
                'name'           => 'উত্তরাধিকার সনদ পত্র',
                'slug'           => 'uttaradhikar-sonod',
                'memo_name'      => 'উত্তরাধিকার সনদ পত্র',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    [
                        'key'     => 'heirs',
                        'label'   => 'ওয়ারিশগণের তালিকা',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'sl', 'label' => 'ক্রম'],
                            ['key' => 'name', 'label' => 'নাম'],
                            ['key' => 'relation', 'label' => 'সম্পর্ক'],
                            ['key' => 'dob', 'label' => 'জন্ম তারিখ/বয়স'],
                            ['key' => 'nid', 'label' => 'জাতীয় পরিচয়পত্র/জন্ম নিবন্ধন নং'],
                            ['key' => 'address', 'label' => 'বর্তমান ঠিকানা'],
                        ],
                    ],
                ],
                'body_template'  => 'নিম্নবর্ণিত ব্যক্তিগণ মৃত **{{applicant_name}}** এর বৈধ উত্তরাধিকারী (ওয়ারিশ) হিসেবে প্রতীয়মান হওয়ায় নিম্নে তাদের নাম ও বিবরণ প্রদত্ত হলোঃ',
                'closing_line'   => $wishPlural,
                'signatories'    => $presetC,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '📑', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 15. ক্ষমতা অর্পণ প্রত্যয়ন পত্র
            [
                'order'          => 15,
                'name'           => 'ক্ষমতা অর্পন পত্র',
                'slug'           => 'khomota-orpon',
                'memo_name'      => 'ক্ষমতা অর্পন প্রত্যয়ন',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    ['key' => 'deceased_occupation', 'label' => 'মৃত ব্যক্তির পেশা/পদবী', 'type' => 'text', 'required' => false],
                    ['key' => 'grantee_sl', 'label' => 'ক্ষমতা গ্রহণকারী ওয়ারিশের ক্রম নং', 'type' => 'bn_number', 'required' => true],
                    ['key' => 'grantee_name', 'label' => 'ক্ষমতা গ্রহণকারীর নাম', 'type' => 'text', 'required' => true],
                    [
                        'key'     => 'grantors',
                        'label'   => 'ক্ষমতা অর্পনকারী ওয়ারিশগণের তালিকা',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'sl', 'label' => 'ক্রম'],
                            ['key' => 'name', 'label' => 'নাম'],
                            ['key' => 'relation', 'label' => 'মৃতের সাথে সম্পর্ক'],
                            ['key' => 'age', 'label' => 'বয়স'],
                            ['key' => 'marital_status', 'label' => 'বৈবাহিক অবস্থা'],
                        ],
                    ],
                    [
                        'key'     => 'grantees',
                        'label'   => 'ক্ষমতা গ্রহণকারীর বিবরণ',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'sl', 'label' => 'ক্রম'],
                            ['key' => 'name', 'label' => 'নাম'],
                            ['key' => 'relation', 'label' => 'মৃতের সাথে সম্পর্ক'],
                            ['key' => 'age', 'label' => 'বয়স'],
                            ['key' => 'marital_status', 'label' => 'বৈবাহিক অবস্থা'],
                        ],
                    ],
                ],
                'body_template'  => 'মৃত **{{applicant_name}}** এর ওয়ারিশগণের মধ্যে **{{grantee_sl}}** নম্বর ওয়ারিশ **{{grantee_name}}**-কে মৃত ব্যক্তির যে-সকল প্রতিষ্ঠানে অর্থনৈতিক লেনদেন ও পাওনাদি ছিলো তা উত্তোলন ও নিষ্পত্তির জন্য সর্বসম্মতিক্রমে ক্ষমতা অর্পন করা হলো।',
                'closing_line'   => $wishPlural,
                'signatories'    => $presetB,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🤝', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 16. নতুন বিদ্যুৎ সংযোগের প্রত্যয়ন পত্র
            [
                'order'          => 16,
                'name'           => 'নিজ নামে বিদ্যুৎ সংযোগ না থাকার প্রত্যয়ন পত্র',
                'slug'           => 'bidyut-songjog-na-thaka',
                'memo_name'      => 'নিজ নামে বিদ্যুৎ না থাকার প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'nopower_reason', 'label' => 'কারণ / সূত্র', 'type' => 'select', 'options' => ['যৌথ পরিবারে বসবাস করছেন', 'আবাসিক প্রকৌশলী ওজোপাডিকো লিঃ আলমডাঙ্গার প্রত্যয়নের আলোকে'], 'required' => false],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি বর্ণিত ঠিকানায় বসবাস করছেন ({{nopower_reason}})। সে ক্ষেত্রে তাঁর **নিজ নামে কোন বিদ্যুৎ সংযোগ নাই**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '💡', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 17. মৃত্যু প্রত্যয়ন পত্র
            [
                'order'          => 17,
                'name'           => 'মৃত্যু প্রত্যয়ন পত্র',
                'slug'           => 'mrityu-pratyayan',
                'memo_name'      => 'মৃত্যু প্রত্যয়ন',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    ['key' => 'death_date', 'label' => 'মৃত্যুর তারিখ', 'type' => 'date', 'required' => true],
                    ['key' => 'death_cause', 'label' => 'মৃত্যুর কারণ', 'type' => 'text', 'required' => true],
                    ['key' => 'register_no', 'label' => 'মৃত্যু রেজিস্টার নং', 'type' => 'bn_number', 'required' => false],
                    ['key' => 'page_no', 'label' => 'রেজিস্টারের পাতা নং', 'type' => 'bn_number', 'required' => false],
                    ['key' => 'serial_no', 'label' => 'ক্রমিক নং', 'type' => 'bn_number', 'required' => false],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি গত **{{death_date}}** তারিখে **{{death_cause}}** কারণে মৃত্যুবরণ করেন। মৃত ব্যক্তির তথ্য পৌরসভার মৃত্যু রেজিস্টার নং {{register_no}}, পাতা নং {{page_no}}, ক্রমিক নং {{serial_no}}-এ লিপিবদ্ধ আছে।',
                'closing_line'   => $wishDeceased,
                'signatories'    => $presetE,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '🕊️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 18. রোহিঙ্গা নয় প্রত্যয়ন পত্র
            [
                'order'          => 18,
                'name'           => 'রোহিঙ্গা নয় প্রত্যয়ন পত্র',
                'slug'           => 'rohingya-noy-pratyayan',
                'memo_name'      => 'রোহিঙ্গা নয় প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'birth_place',
                        'label' => 'জন্মস্থান / পৈত্রিক নিবাস',
                        'type' => 'text',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার {{ward_no}} নং ওয়ার্ডের একজন স্থায়ী বাসিন্দা এবং জন্মসূত্রে গণপ্রজাতন্ত্রী বাংলাদেশের বৈধ নাগরিক। তিনি কোনো রোহিঙ্গা নাগরিক বা বহিরাগত নন এবং তাঁর বা তাঁর পরিবারের বিরুদ্ধে রাষ্ট্রবিরোধী কোনো কার্যকলাপে জড়িত থাকার তথ্য বা অভিযোগ নেই।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🌐', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 19. ভোটার তথ্য যাচাই-বাছাই প্রত্যয়ন পত্র
            [
                'order'          => 19,
                'name'           => 'ভোটার তথ্য যাচাই-বাছাই প্রত্যয়ন পত্র',
                'slug'           => 'voter-tothyo-jachai',
                'memo_name'      => 'ভোটার তথ্য যাচাই প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'voter_no',
                        'label' => 'ভোটার নম্বর / ফর্ম নম্বর',
                        'type' => 'bn_number',
                        'required' => false,
                    ],
                    [
                        'key' => 'voter_area',
                        'label' => 'ভোটার এলাকার নাম',
                        'type' => 'text',
                        'required' => false,
                    ],
                    [
                        'key' => 'verification_remarks',
                        'label' => 'যাচাই-বাছাইয়ের বিবরণ',
                        'type' => 'text',
                        'placeholder' => 'সরেজমিনে তদন্তে সঠিক পাওয়া গিয়াছে',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির ভোটার সংক্রান্ত যাবতীয় তথ্যাদি (ভোটার এলাকা: {{voter_area}}, ভোটার নম্বর: {{voter_no}}) অত্র পৌর কার্যালয়ের রেকর্ডপত্র ও স্থানীয় সরেজমিন তদন্তে পুঙ্খানুপুঙ্খভাবে যাচাই-বাছাই করা হইয়াছে। বিবরণঃ {{verification_remarks}}। উক্ত ব্যক্তি অত্র পৌরসভার বৈধ নাগরিক মর্মে প্রত্যয়ন করা হলো।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🪪', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 20. বেকারত্ব সনদ পত্র
            [
                'order'          => 20,
                'name'           => 'বেকারত্ব সনদ পত্র',
                'slug'           => 'bekarotto-sonod',
                'memo_name'      => 'বেকারত্ব সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'qualification',
                        'label' => 'সর্বোচ্চ শিক্ষাগত যোগ্যতা',
                        'type' => 'text',
                        'placeholder' => 'যেমন: স্নাতক / এইচএসসি / এসএসসি',
                        'required' => false,
                    ],
                    [
                        'key' => 'passing_year',
                        'label' => 'পাসের সন',
                        'type' => 'bn_number',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার একজন স্থায়ী বাসিন্দা (শিক্ষাগত যোগ্যতা: {{qualification}}, পাসের সন: {{passing_year}})। তিনি বর্তমানে কোনো সরকারি, আধা-সরকারি বা স্বায়ত্তশাসিত প্রতিষ্ঠানে স্থায়ী বা অস্থায়ী চাকুরিতে নিয়োজিত নন। তিনি একজন কর্মপ্রত্যাশী বেকার যুবক/যুবতী।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💼', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 21. জাতীয়তা সনদ পত্র
            [
                'order'          => 21,
                'name'           => 'জাতীয়তা সনদ পত্র',
                'slug'           => 'jatiyota-sonod',
                'memo_name'      => 'জাতীয়তা সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার {{ward_no}} নং ওয়ার্ডের একজন স্থায়ী বাসিন্দা এবং জন্মসূত্রে গণপ্রজাতন্ত্রী বাংলাদেশের গর্বিত নাগরিক। তিনি একজন নিষ্ঠাবান, সৎ ও চরিত্রবান ব্যক্তি। রাষ্ট্রবিরোধী কোনো কার্যকলাপে তাঁর সংশ্লিষ্টতা নাই।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🆔', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 22. নাগরিকত্ব সনদ পত্র
            [
                'order'          => 22,
                'name'           => 'নাগরিকত্ব সনদ পত্র',
                'slug'           => 'nagorikotto-sonod',
                'memo_name'      => 'নাগরিকত্ব সনদ',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [
                    ['key' => 'citizen_basis', 'label' => 'নাগরিকত্বের ভিত্তি', 'type' => 'select', 'options' => ['জন্মসূত্রে', 'বংশসূত্রে', 'বৈবাহিক সূত্রে'], 'required' => false],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার একজন স্থায়ী বাসিন্দা এবং **{{citizen_basis}}** বাংলাদেশের নাগরিক। আমার জানামতে তিনি রাষ্ট্র বা সমাজবিরোধী কোন কার্যকলাপের সাথে জড়িত নন।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🪪', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 23. পুনঃবিবাহ সনদ পত্র
            [
                'order'          => 23,
                'name'           => 'পুনঃবিবাহ সনদ পত্র',
                'slug'           => 'punor-bibaho-sonod',
                'memo_name'      => 'পুনঃবিবাহ সনদ',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [
                    [
                        'key' => 'marriage_date',
                        'label' => 'পুনঃবিবাহের তারিখ',
                        'type' => 'date',
                        'required' => true,
                    ],
                    [
                        'key' => 'kazi_name',
                        'label' => 'বিবাহ রেজিস্ট্রি নিকাহ রেজিস্ট্রারের নাম',
                        'type' => 'text',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি তাঁর পূর্ববর্তী বৈবাহিক বিচ্ছেদ / সঙ্গীর মৃত্যুর পর মুসলিম/ধর্মীয় পারিবারিক আইন ও রাষ্ট্রীয় বিধি মোতাবেক **{{spouse_name}}**-এর সাথে **{{marriage_date}}** তারিখে পুনরায় বিবাহ বন্ধনে আবদ্ধ হইয়াছেন (নিকাহ রেজিস্ট্রার: {{kazi_name}})। বর্তমানে তাঁরা স্বামী-স্ত্রী হিসেবে শান্তিপূর্ণ দাম্পত্য জীবন অতিবাহিত করিতেছেন।',
                'closing_line'   => $wishPlural,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '👫', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 24. ভূমিহীন সনদ পত্র
            [
                'order'          => 24,
                'name'           => 'ভূমিহীন সনদ পত্র',
                'slug'           => 'bhumihin-sonod',
                'memo_name'      => 'ভূমিহীন সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'family_members_count',
                        'label' => 'পরিবারের সদস্য সংখ্যা',
                        'type' => 'bn_number',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি ও তাঁর পরিবারের অত্র পৌরসভা বা দেশের অন্য কোনো এলাকায় কোনো প্রকার নিজস্ব আবাদি বা অনাবাদি জমি বা বাস্তুভিটা নাই। তিনি ও তাঁর পরিবার সম্পূর্ণ ভূমিহীন, নিঃস্ব এবং অন্যের জমিতে/পৌর খাস জমিতে আশ্রয় গ্রহণ করিয়া অতি কষ্টে দিনাতিপাত করিতেছেন।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🌾', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 25. নতুন ভোটার নিবন্ধন প্রত্যয়ন পত্র
            [
                'order'          => 25,
                'name'           => 'নতুন ভোটার নিবন্ধন করার প্রত্যয়ন পত্র',
                'slug'           => 'notun-voter-pratyayan',
                'memo_name'      => 'নতুন ভোটার প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি ইতিপূর্বে ভোটার তালিকাভুক্ত হন নাই। এমতাবস্থায় তাঁকে **নতুন ভোটার হিসেবে নিবন্ধন** করার জন্য অত্র প্রত্যয়ন পত্র প্রদান করা হলো।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🗳️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 26. বিধবা প্রত্যয়ন পত্র
            [
                'order'          => 26,
                'name'           => 'বিধবা প্রত্যয়ন পত্র',
                'slug'           => 'bidhoba-pratyayan',
                'memo_name'      => 'বিধবা প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'deceased_husband',
                        'label' => 'মৃত স্বামীর নাম',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'husband_death_date',
                        'label' => 'স্বামীর মৃত্যুর তারিখ',
                        'type' => 'date',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার একজন স্থায়ী বাসিন্দা। তাঁর স্বামী মৃত **{{deceased_husband}}** বিগত {{husband_death_date}} তারিখে মৃত্যুবরণ করিয়াছেন। স্বামীর মৃত্যুর পর উল্লেখিত ব্যক্তি অদ্যবধি দ্বিতীয় বিবাহ বন্ধনে আবদ্ধ হন নাই। তিনি বর্তমানে অসহায় বিধবা অবস্থায় জীবনযাপন করিতেছেন।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '👩', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 27. পেশাগত প্রত্যয়ন পত্র
            [
                'order'          => 27,
                'name'           => 'পেশাগত প্রত্যয়ন পত্র',
                'slug'           => 'peshagoto-pratyayan',
                'memo_name'      => 'পেশাগত প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'occupation', 'label' => 'পেশা (যেমন: একজন কৃষক / ব্যবসায়ী)', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি পেশায় **{{occupation}}**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🛠️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 28. সম্প্রদায় সনদ পত্র
            [
                'order'          => 28,
                'name'           => 'সম্প্রদায় সনদ পত্র',
                'slug'           => 'somproday-sonod',
                'memo_name'      => 'সম্প্রদায় সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'community_name',
                        'label' => 'সম্প্রদায়ের নাম / পরিচয়',
                        'type' => 'text',
                        'placeholder' => 'যেমন: সনাতন / খ্রিস্টান / বৌদ্ধ / অন্যান্য',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার {{ward_no}} নং ওয়ার্ডের স্থায়ী বাসিন্দা এবং **{{community_name}}** সম্প্রদায়ের একজন সম্মানিত ও দায়িত্বশীল সদস্য। এলাকায় তাঁর সামাজিক অবস্থান সুনামধন্য ও শান্তিপূর্ণ।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '👥', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 29. অভিভাবক সম্মতি পত্র
            [
                'order'          => 29,
                'name'           => 'অভিভাবক সম্মতি পত্র',
                'slug'           => 'obhibhabak-sommoti',
                'memo_name'      => 'অভিভাবক সম্মতি প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'guardian_1_name', 'label' => '১ম অভিভাবকের নাম (পিতা/অভিভাবক)', 'type' => 'text', 'required' => true],
                    ['key' => 'guardian_1_relation', 'label' => '১ম অভিভাবকের সম্পর্ক', 'type' => 'text', 'required' => true],
                    ['key' => 'guardian_2_name', 'label' => '২য় অভিভাবকের নাম (মাতা/অভিভাবক)', 'type' => 'text', 'required' => true],
                    ['key' => 'guardian_2_relation', 'label' => '২য় অভিভাবকের সম্পর্ক', 'type' => 'text', 'required' => true],
                    ['key' => 'purpose', 'label' => 'যে কাজে যোগদান/উদ্দেশ্য (যেমন: বাংলাদেশ নৌ বাহিনীতে যোগদান)', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি আমাদের সন্তান। সে **{{purpose}}** করতে চাইলে তার অভিভাবক ({{guardian_1_name}} — {{guardian_1_relation}} এবং {{guardian_2_name}} — {{guardian_2_relation}}) হিসেবে আমাদের কোন আপত্তি নাই মর্মে সজ্ঞানে সম্মতি জ্ঞাপন করছি।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'guardian_signatures' => true, 'icon' => '✍️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 30. মুক্তিযোদ্ধা প্রত্যয়ন পত্র
            [
                'order'          => 30,
                'name'           => 'মুক্তিযোদ্ধা প্রত্যয়ন পত্র',
                'slug'           => 'muktijoddha-pratyayan',
                'memo_name'      => 'মুক্তিযোদ্ধা প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'freedom_fighter_name',
                        'label' => 'বীর মুক্তিযোদ্ধার নাম',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'relation',
                        'label' => 'সম্পর্ক (যেমন: পিতা/মাতা/দাদা/নিজে)',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'gazette_no',
                        'label' => 'মুক্তিযোদ্ধা গেজেট নং',
                        'type' => 'bn_number',
                        'required' => false,
                    ],
                    [
                        'key' => 'mukti_barta_no',
                        'label' => 'লাল মুক্তিবার্তা নং',
                        'type' => 'bn_number',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির {{relation}} **{{freedom_fighter_name}}** মহান মুক্তিযুদ্ধে বীরত্বপূর্ণ অংশগ্রহণকারী একজন বীর মুক্তিযোদ্ধা (গেজেট নং: {{gazette_no}}, লাল মুক্তিবার্তা নং: {{mukti_barta_no}})। মহান মুক্তিযুদ্ধে তাঁর বীরত্ব ও আত্মত্যাগ অনস্বীকার্য এবং জাতির অহংকার।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🎖️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 31. কৃষি প্রত্যয়ন পত্র
            [
                'order'          => 31,
                'name'           => 'কৃষি প্রত্যয়ন পত্র',
                'slug'           => 'krishi-pratyayan',
                'memo_name'      => 'কৃষি প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'farmer_type',
                        'label' => 'কৃষকের ধরন',
                        'type' => 'select',
                        'options' => ['প্রান্তিক কৃষক', 'ক্ষুদ্র কৃষক', 'বর্গা চাষী', 'মাঝারি কৃষক'],
                        'required' => true,
                    ],
                    [
                        'key' => 'crop_types',
                        'label' => 'প্রধান উৎপাদিত ফসল',
                        'type' => 'text',
                        'placeholder' => 'যেমন: ধান, পাট, ভুট্টা, শাকসবজি',
                        'required' => false,
                    ],
                    [
                        'key' => 'cultivated_land',
                        'label' => 'আবাদী জমির পরিমাণ (শতক/বিঘা)',
                        'type' => 'text',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি পেশায় একজন প্রকৃত {{farmer_type}}। তিনি অত্র পৌর এলাকার কৃষিজমিতে (আবাদকৃত জমি: {{cultivated_land}}, উৎপাদিত ফসল: {{crop_types}}) সরাসরি কৃষিকাজ করিয়া জীবিকা নির্বাহ করিতেছেন। তিনি সরকারি কৃষি সহায়তা ও প্রণোদনা লাভের যোগ্য।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🌱', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 32. বৈবাহিক অবস্থার প্রত্যয়ন পত্র (অবিবাহিত)
            [
                'order'          => 32,
                'name'           => 'বৈবাহিক অবস্থার প্রত্যয়ন পত্র (অবিবাহিত)',
                'slug'           => 'obibahit-pratyayan',
                'memo_name'      => 'অবিবাহিত প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি আমার জানামতে এখনও **অবিবাহিত**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🧍', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 33. বার্ষিক আয়ের সনদ পত্র
            [
                'order'          => 33,
                'name'           => 'বার্ষিক আয়ের সনদ পত্র',
                'slug'           => 'barshik-ayer-sonod',
                'memo_name'      => 'বার্ষিক আয়ের সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'annual_income',
                        'label' => 'সর্বমোট বার্ষিক আয় (টাকা)',
                        'type' => 'bn_number',
                        'required' => true,
                    ],
                    [
                        'key' => 'annual_income_words',
                        'label' => 'কথায় (বার্ষিক আয়)',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'income_source',
                        'label' => 'আয়ের প্রধান উৎস (যেমন: চাকুরি/ব্যবসা/কৃষি)',
                        'type' => 'text',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির আয়ের প্রধান উৎস **{{income_source}}**। অত্র পৌরসভার রেকর্ড ও প্রাপ্ত তথ্যানুযায়ী তাঁর সর্বমোট বার্ষিক আয় **{{annual_income}}/-** (কথায়ঃ **{{annual_income_words}}**) টাকা মাত্র।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📈', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 34. এতিম সনদ পত্র
            [
                'order'          => 34,
                'name'           => 'এতিম সনদ পত্র',
                'slug'           => 'etim-sonod',
                'memo_name'      => 'এতিম সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'guardian_name',
                        'label' => 'বর্তমান অভিভাবক/প্রতিপালকের নাম',
                        'type' => 'text',
                        'required' => false,
                    ],
                    [
                        'key' => 'guardian_relation',
                        'label' => 'অভিভাবকের সাথে সম্পর্ক',
                        'type' => 'text',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি/শিশু পিতৃ-মাতৃহীন একজন অসহায় এতিম। বর্তমানে তিনি {{guardian_relation}} {{guardian_name}}-এর আশ্রয়ে প্রতিপালিত হইতেছেন। তিনি যেকোনো সরকারি/বেসরকারি এতিমখানা বা কল্যাণ তহবিল হতে আর্থিক সহায়তা ও সুযোগ-সুবিধা প্রাপ্তির যোগ্য।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🧒', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 35. বৈবাহিক অবস্থার প্রত্যয়ন পত্র (বিবাহিত)
            [
                'order'          => 35,
                'name'           => 'বৈবাহিক অবস্থার প্রত্যয়ন পত্র (বিবাহিত)',
                'slug'           => 'bibahit-pratyayan',
                'memo_name'      => 'বিবাহিত প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি **বিবাহিত**; তাঁর স্বামী/স্ত্রীর নাম **{{spouse_name}}**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💍', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 36. যৌতুক বিহীন বিবাহ প্রত্যয়ন পত্র
            [
                'order'          => 36,
                'name'           => 'যৌতুক বিহীন বিবাহ প্রত্যয়ন পত্র',
                'slug'           => 'joutuk-bihin-bibaho',
                'memo_name'      => 'যৌতুক বিহীন বিবাহ প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [
                    [
                        'key' => 'marriage_date',
                        'label' => 'বিবাহের তারিখ',
                        'type' => 'date',
                        'required' => false,
                    ],
                    [
                        'key' => 'kazi_office',
                        'label' => 'নিকাহ রেজিস্ট্রি অফিসের নাম',
                        'type' => 'text',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত **{{applicant_name}}** ও **{{spouse_name}}**-এর মধ্যে অনুষ্ঠিত শুভ বিবাহে কোনো প্রকার নগদ অর্থ, আসবাবপত্র বা যৌতুক দাবি বা আদান-প্রদান করা হয় নাই। উক্ত বিবাহটি সম্পূর্ণ যৌতুকবিহীনভাবে সুষ্ঠু, আইনানুগ ও ধর্মীয় মর্যাদায় অনুষ্ঠিত হইয়াছে।',
                'closing_line'   => $wishPlural,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💰', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 37. পাসপোর্ট প্রদানের প্রত্যয়ন পত্র
            [
                'order'          => 37,
                'name'           => 'পাসপোর্ট প্রদানের প্রত্যয়ন পত্র',
                'slug'           => 'passport-prodhan-pratyayan',
                'memo_name'      => 'পাসপোর্ট প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'passport_type',
                        'label' => 'পাসপোর্টের ধরন (নতুন ইস্যু / রি-ইস্যু)',
                        'type' => 'select',
                        'options' => ['নতুন পাসপোর্ট ইস্যু', 'পাসপোর্ট নবায়ন/রি-ইস্যু'],
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার একজন স্থায়ী নাগরিক। তিনি রাষ্ট্রবিরোধী কোনো অপরাধে বা কার্যকলাপে জড়িত নহেন। তাঁর অনুকূলে আন্তর্জাতিক ই-পাসপোর্ট / মেশিন রিডেবল {{passport_type}}-এর নিমিত্তে অত্র পৌরসভা হতে কোনো আপত্তি নাই মর্মে প্রত্যয়ন করা হলো।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🛂', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 38. জীবিত ব্যক্তির প্রত্যয়ন পত্র
            [
                'order'          => 38,
                'name'           => 'জীবিত থাকার প্রত্যয়ন পত্র',
                'slug'           => 'jibito-thakar-pratyayan',
                'memo_name'      => 'জীবিত থাকার প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'bank_name', 'label' => 'ব্যাংকের নাম', 'type' => 'text', 'required' => false],
                    ['key' => 'branch_name', 'label' => 'শাখার নাম', 'type' => 'text', 'required' => false],
                    ['key' => 'account_no', 'label' => 'ব্যাংক হিসাব নম্বর', 'type' => 'text', 'required' => false],
                ],
                'body_template'  => 'আমার জানামতে উল্লেখিত ব্যক্তি এখনও **জীবিত আছেন**। {{bank_name}}, {{branch_name}} শাখায় তাঁর {{account_no}} নম্বর হিসাব খোলা আছে।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🙋', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 39. মাসিক আয়ের সনদ পত্র
            [
                'order'          => 39,
                'name'           => 'মাসিক আয়ের সনদ পত্র',
                'slug'           => 'mashik-ayer-sonod',
                'memo_name'      => 'মাসিক আয়ের সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'monthly_income',
                        'label' => 'সর্বমোট মাসিক আয় (টাকা)',
                        'type' => 'bn_number',
                        'required' => true,
                    ],
                    [
                        'key' => 'monthly_income_words',
                        'label' => 'কথায় (মাসিক আয়)',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'source_of_income',
                        'label' => 'আয়ের উৎস / পেশা',
                        'type' => 'text',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির আয়ের প্রধান পেশা/উৎস **{{source_of_income}}**। প্রাপ্ত তথ্য ও সরেজমিন অনুসন্ধানে তাঁর সর্বমোট মাসিক আয় **{{monthly_income}}/-** (কথায়ঃ **{{monthly_income_words}}**) টাকা মাত্র।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💵', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 40. আর্থিক স্বচ্ছলতার সনদ পত্র
            [
                'order'          => 40,
                'name'           => 'আর্থিক স্বচ্ছলতার সনদ পত্র',
                'slug'           => 'arthik-swaccholota-sonod',
                'memo_name'      => 'আর্থিক স্বচ্ছলতার সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'financial_status',
                        'label' => 'পারিবারিক আর্থিক অবস্থা',
                        'type' => 'text',
                        'placeholder' => 'উচ্চ মধ্যবিত্ত / সচ্ছল পরিবার',
                        'required' => false,
                    ],
                    [
                        'key' => 'bank_solvency_ref',
                        'label' => 'ব্যাংক সলভেন্সি বা সম্পদের বিবরণ (যদি থাকে)',
                        'type' => 'text',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি ও তাঁর পরিবারের আর্থিক সচ্ছলতা ও সার্বিক অবস্থা অত্যন্ত সন্তোষজনক ও মজবুত। তিনি আর্থিকভাবে সম্পূর্ণ স্বাবলম্বী এবং তাঁর পরিবার যেকোনো আর্থিক দায়-দায়িত্ব সুচারুভাবে বহনে সক্ষম।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💳', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 41. অবিবাহিত অবস্থায় মৃত্যু সনদ পত্র
            [
                'order'          => 41,
                'name'           => 'অবিবাহিত অবস্থায় মৃত্যু সনদ পত্র',
                'slug'           => 'obibahit-obosthay-mrityu',
                'memo_name'      => 'অবিবাহিত অবস্থায় মৃত্যু সনদ',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    [
                        'key' => 'death_date',
                        'label' => 'মৃত্যুর তারিখ',
                        'type' => 'date',
                        'required' => true,
                    ],
                    [
                        'key' => 'death_place',
                        'label' => 'মৃত্যুর স্থান',
                        'type' => 'text',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'মৃত {{applicant_name}} অত্র পৌরসভার স্থায়ী বাসিন্দা ছিলেন। তিনি জীবদ্দশায় কোনো বিবাহ বন্ধনে আবদ্ধ হন নাই। বিগত **{{death_date}}** তারিখে তিনি **অবিবাহিত অবস্থায়** {{death_place}} মৃত্যুবরণ করিয়াছেন।',
                'closing_line'   => $wishDeceased,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🕯️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 42. আর্থিক অসচ্ছলতার সনদ পত্র
            [
                'order'          => 42,
                'name'           => 'আর্থিক অসচ্ছলতার সনদ পত্র',
                'slug'           => 'arthik-osoccholota-sonod',
                'memo_name'      => 'আর্থিক অসচ্ছলতার সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'hardship_reason',
                        'label' => 'অসচ্ছলতার কারণ / বিবরণ',
                        'type' => 'text',
                        'placeholder' => 'দরিদ্র ও প্রান্তিক পরিবার, পরিবারের কোনো নিয়মিত উপার্জন নাই',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি ও তাঁর পরিবারের আর্থিক অবস্থা অত্যন্ত নাজুক, অসচ্ছল ও দরিদ্র। তিনি ও তাঁর পরিবার সরকারি-বেসরকারি যে কোনো প্রকার সমাজকল্যাণমূলক আর্থিক সহায়তা, চিকিৎসা অনুদান ও বৃত্তি লাভের উপযুক্ত।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📉', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 43. নিজ খরচে মামলা পরিচালনায় অক্ষমতার প্রত্যয়ন পত্র
            [
                'order'          => 43,
                'name'           => 'নিজ খরচে মামলা পরিচালনায় অক্ষমতার প্রত্যয়ন পত্র',
                'slug'           => 'mamla-porichalonay-okkhomota',
                'memo_name'      => 'মামলা পরিচালনায় অক্ষমতার প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'father_occupation', 'label' => 'পিতা/অভিভাবকের পেশা', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'তিনি একজন হতদরিদ্র ও অসচ্ছল পরিবারের সন্তান। তাঁর নিজের বা পিতার কোন জমি-জায়গা নাই। তাঁর পিতা একজন **{{father_occupation}}** ও অসচ্ছল ব্যক্তি। **এমতাবস্থায় তাঁর এবং তাঁর পরিবারের পক্ষ হতে নিজ খরচে মামলা পরিচালনা করার মত অর্থনৈতিক সংগতি নাই।**',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '⚖️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 44. জাতীয় পরিচয় তথ্য সংশোধন প্রত্যয়ন পত্র
            [
                'order'          => 44,
                'name'           => 'জাতীয় পরিচয় তথ্য সংশোধন প্রত্যয়ন পত্র',
                'slug'           => 'nid-songsodhon-pratyayan',
                'memo_name'      => 'জাতীয় পরিচয় তথ্য সংশোধন প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'docname',
                        'label' => 'সনদ / দলিলের নাম',
                        'type' => 'text',
                        'placeholder' => 'যেমন: জাতীয় পরিচয়পত্র / জন্ম নিবন্ধন',
                        'required' => true,
                    ],
                    [
                        'key' => 'field_to_correct',
                        'label' => 'সংশোধনযোগ্য বিষয় (নাম/পিতার নাম/মাতার নাম/জন্মতারিখ)',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'wrong_info',
                        'label' => 'ভুলভাবে লিপিবদ্ধ তথ্য',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'correct_info',
                        'label' => 'সঠিক তথ্য (প্রকৃত তথ্য)',
                        'type' => 'text',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির **{{docname}}**-এ অনবধানতাবশত {{field_to_correct}} হিসেবে **"{{wrong_info}}"** লিপিবদ্ধ হইয়াছে। স্থানীয় অনুসন্ধান ও প্রাসঙ্গিক প্রমাণপত্র যাচাই করে দেখা গেছে যে, তাঁর প্রকৃত ও সঠিক {{field_to_correct}} হইবে **"{{correct_info}}"**। উক্ত তথ্য সংশোধনের জন্য প্রত্যয়ন প্রদান করা হলো।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📝', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 45. নিঃসন্তান প্রত্যয়ন পত্র
            [
                'order'          => 45,
                'name'           => 'নিঃসন্তান প্রত্যয়ন পত্র',
                'slug'           => 'nihsontan-pratyayan',
                'memo_name'      => 'নিঃসন্তান প্রত্যয়ন',
                'subject_status' => 'either',
                'person_fields'  => $marriedPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি আমার জানামতে **নিঃসন্তান** (তাঁর কোন পুত্র বা কন্যা সন্তান নাই)।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🚫', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 46. নির্ভরশীলতার প্রত্যয়ন পত্র
            [
                'order'          => 46,
                'name'           => 'নির্ভরশীলতার প্রত্যয়ন পত্র',
                'slug'           => 'nirbhorshilota-pratyayan',
                'memo_name'      => 'নির্ভরশীলতার প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'dependent_name', 'label' => 'নির্ভরশীল ব্যক্তির নাম', 'type' => 'text', 'required' => true],
                    ['key' => 'dependent_relation', 'label' => 'নির্ভরশীল ব্যক্তির সাথে সম্পর্ক (যেমন: মাতা/পিতা)', 'type' => 'text', 'required' => true],
                    ['key' => 'applicant_relation', 'label' => 'আবেদনকারীর সম্পর্ক (যেমন: পুত্র/কন্যা)', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির {{dependent_relation}} **{{dependent_name}}** একজন বয়োবৃদ্ধ ও অসুস্থ ব্যক্তি। তাঁর নিজস্ব কোন আয়ের উৎস নাই। তিনি সম্পূর্ণরূপে তাঁর {{applicant_relation}} উল্লেখিত ব্যক্তির উপর **নির্ভরশীল**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🤲', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 47. পৌর এলাকায় বসবাস না করার প্রত্যয়ন পত্র
            [
                'order'          => 47,
                'name'           => 'পৌর এলাকায় বসবাস না করার প্রত্যয়ন পত্র',
                'slug'           => 'pouro-elakay-bosobas-na-kora',
                'memo_name'      => 'পৌর এলাকায় বসবাস না করার প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি বর্ণিত ঠিকানায় **বসবাস করেন না**। বর্তমানে তিনি কোথায় বসবাস করছেন তাহা নিম্নস্বাক্ষরকারী অবহিত নন।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏘️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 48. চারিত্রিক প্রত্যয়ন পত্র
            [
                'order'          => 48,
                'name'           => 'চারিত্রিক প্রত্যয়ন পত্র',
                'slug'           => 'charitrik-pratyayan',
                'memo_name'      => 'চরিত্রগত প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি কোন প্রকার রাষ্ট্রবিরোধী বা সমাজবিরোধী কাজের সাথে জড়িত নয়। আমার জানামতে তাঁর **স্বভাব চরিত্র ভালো**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏅', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 49. অনাপত্তি সনদ পত্র
            [
                'order'          => 49,
                'name'           => 'অনাপত্তি সনদ পত্র',
                'slug'           => 'onapotti-sonod',
                'memo_name'      => 'অনাপত্তি সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'noc_variant', 'label' => 'অনাপত্তির ধরন', 'type' => 'select', 'options' => ['ব্যবসা/প্রতিষ্ঠান', 'ভবন নির্মাণ'], 'required' => false],
                    ['key' => 'organization_name', 'label' => 'প্রতিষ্ঠানের নাম / ভবনের বিবরণ', 'type' => 'text', 'required' => true],
                    ['key' => 'purpose', 'label' => 'ব্যবসা/কার্যক্রমের উদ্দেশ্য (যেমন: ব্যবসা পরিচালনা / নকশা অনুমোদন)', 'type' => 'text', 'required' => true],
                    [
                        'key'     => 'land_schedule',
                        'label'   => 'জমির তপশীল',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'mouza', 'label' => 'মৌজা'],
                            ['key' => 'khatian', 'label' => 'খতিয়ান নং'],
                            ['key' => 'dag', 'label' => 'দাগ নং'],
                            ['key' => 'land_type', 'label' => 'জমির ধরন/পরিমাণ'],
                            ['key' => 'survey', 'label' => 'জরিপ (আরএস/এসএ)'],
                        ],
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি তপশীল বর্ণিত জমির মালিক। উক্ত তফশীল বর্ণিত জমির উপর **"{{organization_name}}"** স্থাপিত/প্রস্তাবিত। উক্ত জমির উপর অত্র পৌরসভার কোন উন্নয়নমূলক কাজের পরিকল্পনা নাই। এমতাবস্থায় **{{purpose}}** কার্যক্রমের জন্য অনাপত্তি সনদ প্রদান করা হলো। সরকারি নীতিমালা ভঙ্গ করলে অত্র অনাপত্তি সনদ বাতিল বলে গণ্য হবে।',
                'closing_line'   => $wishBusiness,
                'signatories'    => $presetB,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '✅', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 50. অশিক্ষিত প্রত্যয়ন পত্র
            [
                'order'          => 50,
                'name'           => 'অশিক্ষিত প্রত্যয়ন পত্র',
                'slug'           => 'oshikkhito-pratyayan',
                'memo_name'      => 'অশিক্ষিত প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি **অশিক্ষিত**। ভবিষ্যতে উক্ত ব্যক্তি অক্ষরজ্ঞান অর্জন করলে অত্র প্রত্যয়ন বাতিল বলে গণ্য হবে।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🔤', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 51. ভোটার এলাকা স্থানান্তর প্রত্যয়ন পত্র
            [
                'order'          => 51,
                'name'           => 'ভোটার স্থানান্তরের প্রত্যয়ন পত্র',
                'slug'           => 'voter-sthanantor-pratyayan',
                'memo_name'      => 'ভোটার স্থানান্তর প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [
                    ['key' => 'prev_address', 'label' => 'পূর্বের ভোটার এলাকা/ঠিকানা', 'type' => 'text', 'required' => false],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি বর্তমানে অত্র পৌরসভার বর্ণিত ঠিকানায় স্থায়ীভাবে বসবাস করছেন। এমতাবস্থায় তাঁর ভোটার এলাকা ({{prev_address}}) হতে অত্র পৌর এলাকায় **ভোটার স্থানান্তর** করার জন্য প্রত্যয়ন পত্র প্রদান করা হলো।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📍', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 52. প্রতিবন্ধী সনদ পত্র
            [
                'order'          => 52,
                'name'           => 'প্রতিবন্ধী সনদ পত্র',
                'slug'           => 'protibondhi-sonod',
                'memo_name'      => 'প্রতিবন্ধী সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'disability_type',
                        'label' => 'প্রতিবন্ধকতার ধরন (শারীরিক/দৃষ্টি/শ্রবণ/বুদ্ধি/বহুবিধ)',
                        'type' => 'select',
                        'options' => ['শারীরিক প্রতিবন্ধী', 'দৃষ্টি প্রতিবন্ধী', 'শ্রবণ ও বাক প্রতিবন্ধী', 'বুদ্ধি প্রতিবন্ধী', 'বহুবিধ প্রতিবন্ধী'],
                        'required' => true,
                    ],
                    [
                        'key' => 'suborno_card_no',
                        'label' => 'সুবর্ণ নাগরিক কার্ড নম্বর (যদি থাকে)',
                        'type' => 'text',
                        'required' => false,
                    ],
                    [
                        'key' => 'disability_percentage',
                        'label' => 'প্রতিবন্ধকতার মাত্রা (যেমন: মাত্রাতিরিক্ত/মাঝারি)',
                        'type' => 'text',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি একজন **{{disability_type}}** নাগরিক (সুবর্ণ নাগরিক কার্ড নং: {{suborno_card_no}})। তিনি স্বাভাবিক জীবনযাত্রায় বিশেষ যত্নের ওপর নির্ভরশীল। রাষ্ট্রীয় সুযোগ-সুবিধা ও সমাজসেবা অধিদপ্তরের ভাতা লাভের নিমিত্তে অত্র প্রত্যয়ন প্রদান করা হলো।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '♿', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 53. নামের ভিন্নতার প্রত্যয়ন পত্র (একই ব্যক্তি)
            [
                'order'          => 53,
                'name'           => 'নামের ভিন্নতার প্রত্যয়ন পত্র (একই ব্যক্তি)',
                'slug'           => 'namer-bhinnulota-pratyayan',
                'memo_name'      => 'নামের ভিন্নতার প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [
                    ['key' => 'alternate_name', 'label' => 'দলিল/পর্চা/নথিপত্রে লিপিবদ্ধ অপর নাম', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির জমির দলিল, পর্চা ও বিভিন্ন নথিপত্রে তাঁর নাম **{{alternate_name}}** লিপিবদ্ধ হয়েছে। প্রকৃতপক্ষে **{{applicant_name}}** ও **{{alternate_name}}** উল্লেখিত নামীয় ব্যক্তি **একই ব্যক্তি**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '🧾', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 54. উপজাতি সনদ পত্র
            [
                'order'          => 54,
                'name'           => 'উপজাতি সনদ পত্র',
                'slug'           => 'upajati-sonod',
                'memo_name'      => 'উপজাতি সনদ',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'tribe_name',
                        'label' => 'উপজাতি / নৃ-গোষ্ঠীর নাম',
                        'type' => 'text',
                        'placeholder' => 'যেমন: সাঁওতাল / চাকমা / মারমা / গারো',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার একজন স্থায়ী বাসিন্দা এবং তিনি গণপ্রজাতন্ত্রী বাংলাদেশের ক্ষুদ্র নৃ-গোষ্ঠী / **{{tribe_name}}** সম্প্রদায়ের অন্তর্ভুক্ত একজন গর্বিত নাগরিক।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏕️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 55. প্রিমিসেস লাইসেন্স সনদ পত্র
            [
                'order'          => 55,
                'name'           => 'প্রিমিসেস লাইসেন্স সনদ পত্র',
                'slug'           => 'premises-license',
                'memo_name'      => 'প্রিমিসেস লাইসেন্স',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'establishment_name',
                        'label' => 'প্রতিষ্ঠানের নাম',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'business_nature',
                        'label' => 'ব্যবসার প্রকৃতি / ব্যবহারের ধরন',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'premises_address',
                        'label' => 'প্রতিষ্ঠানের অবস্থান / ঠিকানা',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'license_no',
                        'label' => 'প্রিমিসেস লাইসেন্স নং',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'validity_year',
                        'label' => 'বৈধতার অর্থবছর',
                        'type' => 'text',
                        'placeholder' => 'যেমন: ২০২৫-২০২৬',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির স্বত্বাধিকারাধীন প্রতিষ্ঠান **"{{establishment_name}}"** (ব্যবসার প্রকৃতি: {{business_nature}}, ঠিকানা: {{premises_address}})-এর অনুকূলে অত্র পৌরসভার প্রিমিসেস লাইসেন্স নং: **{{license_no}}**, অর্থবছর: **{{validity_year}}** প্রদান করা হলো। প্রতিষ্ঠানটি যাবতীয় পৌর স্বাস্থ্য ও স্যানিটেশন বিধিমালা মানিয়া চলিতে বাধ্য থাকিবে।',
                'closing_line'   => $wishBusiness,
                'signatories'    => $presetB,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏢', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 56. ট্রেড লাইসেন্স প্রত্যয়ন পত্র
            [
                'order'          => 56,
                'name'           => 'ট্রেড লাইসেন্স প্রত্যয়ন পত্র',
                'slug'           => 'trade-license-bn',
                'memo_name'      => 'ট্রেড লাইসেন্স প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'firm_name',
                        'label' => 'ব্যবসা প্রতিষ্ঠানের নাম',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'license_no',
                        'label' => 'ট্রেড লাইসেন্স নম্বর',
                        'type' => 'bn_number',
                        'required' => true,
                    ],
                    [
                        'key' => 'business_type',
                        'label' => 'ব্যবসার ধরন',
                        'type' => 'text',
                        'required' => true,
                    ],
                    [
                        'key' => 'fiscal_year',
                        'label' => 'অর্থবছর (যেমন: ২০২৫-২০২৬)',
                        'type' => 'text',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভা কর্তৃক লাইসেন্সপ্রাপ্ত প্রতিষ্ঠান **"{{firm_name}}"** (ব্যবসার ধরন: {{business_type}})-এর বৈধ স্বত্বাধিকারী/প্রোপাইটর। উক্ত প্রতিষ্ঠানের অনুকূলে ইস্যুকৃত ট্রেড লাইসেন্স নং: **{{license_no}}**, অর্থবছর: **{{fiscal_year}}** বর্তমানে সম্পূর্ণ বৈধ ও হালনাগাদকৃত রহিয়াছে।',
                'closing_line'   => $wishBusiness,
                'signatories'    => $presetB,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏪', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 57. ভোটার তালিকায় অন্তর্ভুক্তির প্রত্যয়ন পত্র
            [
                'order'          => 57,
                'name'           => 'ভোটার তালিকায় অন্তর্ভুক্তির প্রত্যয়ন পত্র',
                'slug'           => 'voter-talika-bad-pora',
                'memo_name'      => 'ভোটার তালিকায় অন্তর্ভুক্তির প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'omission_reason',
                        'label' => 'বাদ পড়ার কারণ / বিবরণ',
                        'type' => 'text',
                        'placeholder' => 'অনবধানতাবশত বিগত হালনাগাদে নাম বাদ পড়িয়াছিল',
                        'required' => false,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার {{ward_no}} নং ওয়ার্ডের একজন স্থায়ী বাসিন্দা ও যোগ্য নাগরিক হওয়া সত্ত্বেও অনবধানতাবশত ইতিপূর্বে প্রকাশিত ভোটার তালিকা হইতে তাঁর নাম বাদ পড়িয়াছিল। তিনি বাংলাদেশের অন্য কোথাও ভোটার হন নাই। এমতাবস্থায় তাঁকে ভোটার তালিকায় অন্তর্ভুক্ত করার জন্য জোর সুপারিশ করা হলো।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📋', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 58. পুনঃবিবাহ না হওয়ার প্রত্যয়ন পত্র
            [
                'order'          => 58,
                'name'           => '২য় বিবাহ না করার প্রত্যয়ন পত্র',
                'slug'           => 'ditiyo-bibaho-na-kora',
                'memo_name'      => '২য় বিবাহ না করার প্রত্যয়ন',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    ['key' => 'wife_name', 'label' => 'স্ত্রীর নাম (জীবিত)', 'type' => 'text', 'required' => true],
                    ['key' => 'wife_nid', 'label' => 'স্ত্রীর জাতীয় পরিচয়পত্র নম্বর', 'type' => 'bn_number', 'required' => true],
                ],
                'body_template'  => '{{wife_name}}, মৃত {{applicant_name}} এর একমাত্র স্ত্রী। মৃত {{applicant_name}} এর মৃত্যুর পর {{wife_name}} আর **দ্বিতীয় বিবাহ করেন নাই**। {{wife_name}} এর জাতীয় পরিচয় পত্র নম্বরঃ {{wife_nid}}।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '⛔', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 59. স্থায়ী বাসিন্দার প্রত্যয়ন পত্র
            [
                'order'          => 59,
                'name'           => 'স্থায়ী বাসিন্দার প্রত্যয়ন পত্র',
                'slug'           => 'sthayi-basinda-pratyayan',
                'memo_name'      => 'স্থায়ী বাসিন্দার প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি অত্র পৌরসভার বর্ণিত ঠিকানায় **স্থায়ীভাবে বসবাস করছেন**। তিনি বাংলাদেশের একজন স্থায়ী নাগরিক।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏡', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 60. যানবাহন লাইসেন্স সনদ পত্র
            [
                'order'          => 60,
                'name'           => 'যানবাহন লাইসেন্স সনদ পত্র',
                'slug'           => 'janbahon-license',
                'memo_name'      => 'যানবাহন লাইসেন্স',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    [
                        'key' => 'vehicle_type',
                        'label' => 'যানবাহনের ধরন (ইজিবাইক/রিকশা/ভ্যান/অটোরিকশা)',
                        'type' => 'select',
                        'options' => ['ইজিবাইক', 'অটোরিকশা', 'পায়ে চালিত রিকশা', 'ভ্যান', 'অন্যান্য'],
                        'required' => true,
                    ],
                    [
                        'key' => 'vehicle_reg_no',
                        'label' => 'লাইসেন্স / প্লেট নম্বর',
                        'type' => 'bn_number',
                        'required' => true,
                    ],
                    [
                        'key' => 'chassis_no',
                        'label' => 'চেসিস নং / মোটর নং',
                        'type' => 'text',
                        'required' => false,
                    ],
                    [
                        'key' => 'fiscal_year',
                        'label' => 'লাইসেন্সের অর্থবছর',
                        'type' => 'text',
                        'placeholder' => 'যেমন: ২০২৫-২০২৬',
                        'required' => true,
                    ],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির মালিকানাধীন যানবাহন (যানবাহনের ধরন: **{{vehicle_type}}**, চেসিস নং: {{chassis_no}})-এর অনুকূলে অত্র পৌরসভা হইতে লাইসেন্স নং: **{{vehicle_reg_no}}**, অর্থবছর: **{{fiscal_year}}** অনুমোদন প্রদান করা হলো।',
                'closing_line'   => $wishBusiness,
                'signatories'    => $presetB,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🚗', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 61. অবস্থান / পরিবেশগত প্রত্যয়ন পত্র
            [
                'order'          => 61,
                'name'           => 'অবস্থান / পরিবেশগত প্রত্যয়ন পত্র',
                'slug'           => 'obosthan-poribeshgoto-pratyayan',
                'memo_name'      => 'অবস্থান প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'organization_name', 'label' => 'প্রতিষ্ঠানের নাম', 'type' => 'text', 'required' => true],
                    ['key' => 'org_address', 'label' => 'প্রতিষ্ঠানের অবস্থান/ঠিকানা', 'type' => 'text', 'required' => true],
                    [
                        'key'     => 'land_schedule',
                        'label'   => 'তফসিল (জমির বিবরণ)',
                        'type'    => 'repeater',
                        'columns' => [
                            ['key' => 'district', 'label' => 'জেলা ও উপজেলা'],
                            ['key' => 'mouza', 'label' => 'মৌজার নাম ও জেএল নং'],
                            ['key' => 'khatian', 'label' => 'খতিয়ান নং'],
                            ['key' => 'dag', 'label' => 'দাগ নং'],
                            ['key' => 'area', 'label' => 'জমির পরিমাণ'],
                        ],
                    ],
                ],
                'body_template'  => 'বর্ণিত ব্যক্তি অত্র পৌরসভাধীন **{{org_address}}**-এ নিম্ন তফসিল বর্ণিত জমিতে **"{{organization_name}}"** নামীয় প্রতিষ্ঠান স্থাপন করেছেন। পরিবেশ সংরক্ষণ আইন ও পৌরসভার শর্তাবলী প্রতিপালন সাপেক্ষে উক্ত প্রতিষ্ঠানের অনুকূলে অবস্থানগত প্রত্যয়ন পত্র প্রদান করা হলো।',
                'closing_line'   => $wishBusiness,
                'signatories'    => $presetB,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏗️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 62. জাতীয় পরিচয় পত্রে জন্ম স্থান সংশোধনের প্রত্যয়ন পত্র
            [
                'order'          => 62,
                'name'           => 'জাতীয় পরিচয় পত্রে জন্ম স্থান সংশোধনের প্রত্যয়ন পত্র',
                'slug'           => 'jonmosthan-songsodhon',
                'memo_name'      => 'জন্মস্থান সংশোধন প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'wrong_birthplace', 'label' => 'জাতীয় পরিচয় পত্রে ভুল জন্ম জেলা/স্থান', 'type' => 'text', 'required' => true],
                    ['key' => 'correct_birthplace', 'label' => 'সঠিক জন্ম জেলা/স্থান (যেমন: চুয়াডাঙ্গা)', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির জাতীয় পরিচয় পত্রে জন্মস্থান ভুলবশত **{{wrong_birthplace}}** লিপিবদ্ধ হয়েছে। প্রকৃতপক্ষে তাঁর সঠিক জন্মস্থান জেলাঃ **{{correct_birthplace}}**। এমতাবস্থায় জাতীয় পরিচয় পত্রে জন্মস্থান সংশোধনের লক্ষ্যে অত্র প্রত্যয়ন পত্র প্রদান করা হলো।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🗺️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 63. ধর্মান্তরিত হওয়ায় নাম সংশোধনের প্রত্যয়ন পত্র
            [
                'order'          => 63,
                'name'           => 'ধর্মান্তরিত হওয়ায় জন্ম নিবন্ধনে নাম সংশোধনের প্রত্যয়ন পত্র',
                'slug'           => 'dhormantorito-pratyayan',
                'memo_name'      => 'ধর্মান্তরিত প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'previous_name', 'label' => 'পূর্বের নাম', 'type' => 'text', 'required' => true],
                    ['key' => 'new_name', 'label' => 'বর্তমান/নতুন নাম', 'type' => 'text', 'required' => true],
                    ['key' => 'previous_religion', 'label' => 'পূর্বের ধর্ম', 'type' => 'text', 'required' => true],
                    ['key' => 'new_religion', 'label' => 'বর্তমান ধর্ম', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি পূর্বে **{{previous_name}}** নামে {{previous_religion}} ধর্মাবলম্বী ছিলেন। পরবর্তীতে তিনি ধর্মান্তরিত হয়ে **{{new_religion}}** ধর্ম গ্রহণ করেছেন এবং এফিডেভিটের মাধ্যমে নাম পরিবর্তন করে **{{new_name}}** রেখেছেন। অনলাইন জন্ম নিবন্ধন ও সংশ্লিষ্ট নথিতে নাম সংশোধনের লক্ষ্যে অত্র প্রত্যয়ন পত্র প্রদান করা হলো।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '🔄', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 64. প্রবাস প্রত্যাবর্তন প্রত্যয়ন পত্র
            [
                'order'          => 64,
                'name'           => 'প্রবাস প্রত্যাবর্তন প্রত্যয়ন পত্র',
                'slug'           => 'probas-protyaborton',
                'memo_name'      => 'প্রবাস প্রত্যাবর্তন প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'passport_no', 'label' => 'পাসপোর্ট নম্বর', 'type' => 'text', 'required' => true],
                    ['key' => 'country_name', 'label' => 'প্রবাসের দেশের নাম (যেমন: মালয়েশিয়া / সৌদি আরব)', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি (পাসপোর্ট নম্বরঃ **{{passport_no}}**) দীর্ঘদিন যাবৎ **{{country_name}}** প্রবাসী ছিলেন। বর্তমানে তিনি প্রবাস জীবন সমাপ্ত করে স্থায়ীভাবে দেশে প্রত্যাবর্তন করেছেন এবং অত্র পৌর এলাকায় বসবাস করছেন।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '✈️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 65. হরিজন প্রত্যয়ন পত্র
            [
                'order'          => 65,
                'name'           => 'হরিজন প্রত্যয়ন পত্র',
                'slug'           => 'horijon-pratyayan',
                'memo_name'      => 'হরিজন প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি একজন **হরিজন সম্প্রদায়ভুক্ত** ব্যক্তি।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🧑‍🤝‍🧑', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 66. বিবিধ প্রত্যয়ন পত্র
            [
                'order'          => 66,
                'name'           => 'বিবিধ প্রত্যয়ন পত্র',
                'slug'           => 'bibidho-pratyayan',
                'memo_name'      => 'বিবিধ প্রত্যয়ন',
                'subject_status' => 'either',
                'person_fields'  => $marriedPerson,
                'fields'         => [
                    ['key' => 'custom_statement', 'label' => 'প্রত্যয়নের মূল বক্তব্য', 'type' => 'textarea', 'required' => true],
                ],
                'body_template'  => '{{custom_statement}}',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📄', 'language' => 'bn'],
                'fee'            => 0,
            ],

        ];

        $validSlugs = array_column($types, 'slug');

        // Deactivate or remove obsolete types if no certificates/applications are attached
        foreach (AttestationType::whereNotIn('slug', $validSlugs)->get() as $obsolete) {
            if ($obsolete->attestations()->exists() || $obsolete->applications()->exists()) {
                $obsolete->update(['is_active' => false, 'is_public' => false]);
            } else {
                $obsolete->delete();
            }
        }

        foreach ($types as $t) {
            AttestationType::updateOrCreate(
                ['slug' => $t['slug']],
                array_merge($t, [
                    'is_public' => true,
                    'is_active' => true,
                ])
            );
        }
    }
}

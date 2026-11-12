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
            // 01. ২য় বিবাহ না করার প্রত্যয়ন
            [
                'order'          => 1,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💍', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 02. অনাপত্তি সনদ
            [
                'order'          => 2,
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

            // 03. অবিবাহিত প্রত্যয়ন
            [
                'order'          => 3,
                'name'           => 'বৈবাহিক অবস্থার প্রত্যয়ন পত্র (অবিবাহিত)',
                'slug'           => 'obibahit-pratyayan',
                'memo_name'      => 'অবিবাহিত প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি আমার জানামতে এখনও **অবিবাহিত**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🙋', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 04. অভিভাবক সম্মতি পত্র (২ জন অভিভাবক)
            [
                'order'          => 4,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'guardian_signatures' => true, 'icon' => '🤝', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 05. অশিক্ষিত প্রত্যয়ন
            [
                'order'          => 5,
                'name'           => 'অশিক্ষিত প্রত্যয়ন পত্র',
                'slug'           => 'oshikkhito-pratyayan',
                'memo_name'      => 'অশিক্ষিত প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি **অশিক্ষিত**। ভবিষ্যতে উক্ত ব্যক্তি অক্ষরজ্ঞান অর্জন করলে অত্র প্রত্যয়ন বাতিল বলে গণ্য হবে।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📖', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 06. আয়ের প্রত্যয়ন পত্র (বার্ষিক ও মাসিক অপশন + TIN)
            [
                'order'          => 6,
                'name'           => 'বাৎসরিক / মাসিক আয়ের প্রত্যয়ন পত্র',
                'slug'           => 'ayer-pratyayan',
                'memo_name'      => 'আয়ের প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'income_period', 'label' => 'আয়ের ধরন', 'type' => 'select', 'options' => ['বাৎসরিক', 'মাসিক'], 'required' => false],
                    ['key' => 'earner_target', 'label' => 'কার আয়', 'type' => 'select', 'options' => ['পিতার পেশা', 'নিজ পেশা', 'মাতার পেশা', 'স্বামীর পেশা'], 'required' => false],
                    ['key' => 'father_occupation', 'label' => 'পেশা (যেমন: কৃষি কাজ / ব্যবসা)', 'type' => 'text', 'required' => true],
                    ['key' => 'annual_income', 'label' => 'আয়ের পরিমাণ (টাকায়)', 'type' => 'amount_with_words', 'required' => true],
                    ['key' => 'tin_no', 'label' => 'TIN নম্বর (থাকলে)', 'type' => 'text', 'required' => false],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির {{earner_target}} {{father_occupation}}। বর্ণিত পেশা হতে তাঁর {{income_period}} আনুমানিক আয়ঃ **{{annual_income}}/- ({{annual_income_words}})** টাকা মাত্র।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetF,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '💰', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 07. উত্তরাধিকার সনদ পত্র
            [
                'order'          => 7,
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
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '📜', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 08. ক্ষমতা অর্পন পত্র
            [
                'order'          => 8,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '✍️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 09. চরিত্রগত প্রত্যয়ন
            [
                'order'          => 9,
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

            // 10. ছাদ বাগানের প্রত্যয়ন
            [
                'order'          => 10,
                'name'           => 'ছাদ বাগানের প্রত্যয়ন পত্র',
                'slug'           => 'chad-bagan-pratyayan',
                'memo_name'      => 'ছাদ বাগানের প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তির বর্ণিত ঠিকানায় আবাসিক ভবনের উপর **ছাদ বাগান রয়েছে**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetB,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🌱', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 11. জীবিত থাকার প্রত্যয়ন
            [
                'order'          => 11,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💓', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 12. ধর্মান্তরিত প্রত্যয়ন
            [
                'order'          => 12,
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
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '🕌', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 13. নামের ভিন্নতার প্রত্যয়ন
            [
                'order'          => 13,
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
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '🪪', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 14. নিজ খরচে মামলা পরিচালনার অক্ষমতা
            [
                'order'          => 14,
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

            // 15. নিজ নামে বিদ্যুৎ সংযোগ না থাকা
            [
                'order'          => 15,
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

            // 16. নির্ভরশীলতার প্রত্যয়ন
            [
                'order'          => 16,
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

            // 17. নিঃসন্তান প্রত্যয়ন
            [
                'order'          => 17,
                'name'           => 'নিঃসন্তান প্রত্যয়ন পত্র',
                'slug'           => 'nihsontan-pratyayan',
                'memo_name'      => 'নিঃসন্তান প্রত্যয়ন',
                'subject_status' => 'either',
                'person_fields'  => $marriedPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি আমার জানামতে **নিঃসন্তান** (তাঁর কোন পুত্র বা কন্যা সন্তান নাই)।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '👶', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 18. পারিবারিক সনদ পত্র
            [
                'order'          => 18,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏠', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 19. পেশাগত প্রত্যয়ন
            [
                'order'          => 19,
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

            // 20. পৌর এলাকায় বসবাস না করা
            [
                'order'          => 20,
                'name'           => 'পৌর এলাকায় বসবাস না করার প্রত্যয়ন পত্র',
                'slug'           => 'pouro-elakay-bosobas-na-kora',
                'memo_name'      => 'পৌর এলাকায় বসবাস না করার প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি বর্ণিত ঠিকানায় **বসবাস করেন না**। বর্তমানে তিনি কোথায় বসবাস করছেন তাহা নিম্নস্বাক্ষরকারী অবহিত নন।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🚶', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 21. বিবাহিত প্রত্যয়ন
            [
                'order'          => 21,
                'name'           => 'বৈবাহিক অবস্থার প্রত্যয়ন পত্র (বিবাহিত)',
                'slug'           => 'bibahit-pratyayan',
                'memo_name'      => 'বিবাহিত প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $marriedPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি **বিবাহিত**; তাঁর স্বামী/স্ত্রীর নাম **{{spouse_name}}**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💑', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 22. মৃত্যু সনদপত্র (রেজিস্টারে লিপিবদ্ধ)
            [
                'order'          => 22,
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

            // 23. মৃত্যু প্রত্যয়ন (পৌরসভা প্রতিষ্ঠার আগে)
            [
                'order'          => 23,
                'name'           => 'মৃত্যু প্রত্যয়ন পত্র (পৌরসভা প্রতিষ্ঠার পূর্বে)',
                'slug'           => 'mrityu-pratyayan-purbe',
                'memo_name'      => 'মৃত্যু প্রত্যয়ন',
                'subject_status' => 'deceased',
                'person_fields'  => $deceasedPerson,
                'fields'         => [
                    ['key' => 'death_date', 'label' => 'মৃত্যুর তারিখ (অজানা থাকলে - দিন)', 'type' => 'text', 'required' => false],
                    ['key' => 'death_cause', 'label' => 'মৃত্যুর কারণ', 'type' => 'text', 'required' => true],
                    ['key' => 'investigator_name', 'label' => 'তদন্তকারী/টিকাদানকারীর নাম', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত মৃত ব্যক্তি পৌরসভা প্রতিষ্ঠিত হওয়ার পূর্বে (**{{death_date}}**, কারণ: {{death_cause}}) মৃত্যুবরণ করায় পৌরসভার মৃত্যু রেজিস্টারে তাঁর মৃত্যু তথ্য লিপিবদ্ধ হয় নাই। অত্রাফিসের টিকাদানকারী **{{investigator_name}}** এর সরেজমিনে তদন্তপূর্বক অত্র মৃত্যু প্রত্যয়ন পত্র প্রদান করা হলো।',
                'closing_line'   => $wishDeceased,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '🕯️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 24. সংখ্যালঘু প্রত্যয়ন
            [
                'order'          => 24,
                'name'           => 'সংখ্যালঘু প্রত্যয়ন পত্র',
                'slug'           => 'sonkhyaloghu-pratyayan',
                'memo_name'      => 'সংখ্যালঘু প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'community', 'label' => 'সম্প্রদায়/ধর্ম (যেমন: সনাতন ধর্মাবলম্বী)', 'type' => 'text', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি একজন সংখ্যালঘু **{{community}}** সম্প্রদায়ভুক্ত ব্যক্তি।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🕉️', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 25. সার্টিফিকেট সংশোধন প্রত্যয়ন
            [
                'order'          => 25,
                'name'           => 'সনদ পত্রে নাম সংশোধন প্রত্যয়ন পত্র',
                'slug'           => 'certificate-songsodhon',
                'memo_name'      => 'সার্টিফিকেট প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'certificate_type', 'label' => 'সনদের ধরন (যেমন: এসএসসি সনদ পত্রে পিতার নাম)', 'type' => 'text', 'required' => true],
                    ['key' => 'wrong_name', 'label' => 'সনদে লিপিবদ্ধ ভুল নাম', 'type' => 'text', 'required' => true],
                    ['key' => 'correct_name', 'label' => 'প্রকৃত/সঠিক নাম (ইংরেজি সহ)', 'type' => 'text', 'required' => true],
                    ['key' => 'reference_nid', 'label' => 'সংশ্লিষ্ট জাতীয় পরিচয়পত্র নম্বর', 'type' => 'bn_number', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তির {{certificate_type}} ভুলবশত **{{wrong_name}}** লিপিবদ্ধ হয়েছে। প্রকৃতপক্ষে জাতীয় পরিচয়পত্র অনুযায়ী সঠিক নাম **{{correct_name}}**। এমতাবস্থায় সনদপত্রে নাম সংশোধনের জন্য অত্র প্রত্যয়ন পত্র প্রদান করা হলো। সংশ্লিষ্ট জাতীয় পরিচয়পত্র নম্বরঃ **{{reference_nid}}**।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🎓', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 26. সুদ মওকুফের প্রত্যয়ন
            [
                'order'          => 26,
                'name'           => 'সুদ মওকুফ করার প্রত্যয়ন পত্র',
                'slug'           => 'sud-moukuf-pratyayan',
                'memo_name'      => 'সুদ মওকুফের প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [
                    ['key' => 'bank_name', 'label' => 'ব্যাংকের নাম', 'type' => 'text', 'required' => true],
                    ['key' => 'branch_name', 'label' => 'শাখার নাম', 'type' => 'text', 'required' => true],
                    ['key' => 'loan_type', 'label' => 'ঋণের ধরন (যেমন: ব্যবসার উপর সিসি ঋণ)', 'type' => 'text', 'required' => true],
                    ['key' => 'reason_details', 'label' => 'অসচ্ছলতা/ক্ষতির সংক্ষিপ্ত কারণ', 'type' => 'textarea', 'required' => true],
                ],
                'body_template'  => 'উল্লেখিত ব্যক্তি **{{bank_name}}**, {{branch_name}} শাখা হতে {{loan_type}} গ্রহণ করেছিলেন। পরবর্তীতে {{reason_details}}। এমতাবস্থায় মানবিক বিবেচনায় তাঁর ঋণ হিসাবটির **সুদ মওকুফ** করার প্রয়োজনীয় ব্যবস্থা গ্রহণের জন্য জোর সুপারিশ করছি।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetA,
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '🏦', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 27. স্থায়ী বাসিন্দার প্রত্যয়ন
            [
                'order'          => 27,
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

            // 28. হরিজন প্রত্যয়ন
            [
                'order'          => 28,
                'name'           => 'হরিজন প্রত্যয়ন পত্র',
                'slug'           => 'horijon-pratyayan',
                'memo_name'      => 'হরিজন প্রত্যয়ন',
                'subject_status' => 'living',
                'person_fields'  => $stdPerson,
                'fields'         => [],
                'body_template'  => 'উল্লেখিত ব্যক্তি একজন **হরিজন সম্প্রদায়ভুক্ত** ব্যক্তি।',
                'closing_line'   => $wishGeneral,
                'signatories'    => $presetD,
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🧹', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 29. নতুন ভোটার নিবন্ধন প্রত্যয়ন
            [
                'order'          => 29,
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

            // 30. ভোটার স্থানান্তর প্রত্যয়ন
            [
                'order'          => 30,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🔄', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 31. জন্মস্থান সংশোধন প্রত্যয়ন
            [
                'order'          => 31,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📍', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 32. প্রবাস প্রত্যাবর্তন প্রত্যয়ন
            [
                'order'          => 32,
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

            // 33. অবস্থান / পরিবেশগত প্রত্যয়ন পত্র
            [
                'order'          => 33,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🏭', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 34. ওয়ারিশ সনদ পত্র
            [
                'order'          => 34,
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
                'print_options'  => ['with_header' => false, 'watermark' => true, 'icon' => '👨‍👩‍👧‍👦', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 35. নাগরিকত্ব সনদ পত্র
            [
                'order'          => 35,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🇧🇩', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // 36. বিবিধ প্রত্যয়ন পত্র
            [
                'order'          => 36,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📋', 'language' => 'bn'],
                'fee'            => 0,
            ],

            // =========================================================================
            // 🌐 10 ENGLISH CERTIFICATES (from সনদের_সেবাসমূহ (2).html)
            // =========================================================================

            // 37. Character Certificate (English)
            [
                'order'          => 37,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🎖️', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 38. Nationality Certificate (English)
            [
                'order'          => 38,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🌐', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 39. Unmarried Certification (English)
            [
                'order'          => 39,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💠', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 40. Married Certification (English)
            [
                'order'          => 40,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '💒', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 41. Family Relation Certificate (English)
            [
                'order'          => 41,
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

            // 42. Death Certificate - Register Format (English)
            [
                'order'          => 42,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🕊️', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 43. Death Certificate - Descriptive (English)
            [
                'order'          => 43,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '🕯️', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 44. Authorization Letter (English)
            [
                'order'          => 44,
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
                'print_options'  => ['with_header' => true, 'watermark' => true, 'icon' => '📜', 'language' => 'en'],
                'fee'            => 0,
            ],

            // 45. Trade License (English)
            [
                'order'          => 45,
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

            // 46. Child Dose of Vaccine / Children Card (English)
            [
                'order'          => 46,
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
        ];

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

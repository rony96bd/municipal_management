<?php

namespace Tests\Feature\Attestation;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Municipal\Attestation\Enums\ApplicationStatus;
use Municipal\Attestation\Models\Attestation;
use Municipal\Attestation\Models\AttestationApplication;
use Municipal\Attestation\Models\AttestationType;
use Municipal\Attestation\Support\MemoGenerator;
use Tests\TestCase;

class AttestationSystemTest extends TestCase
{
    use DatabaseTransactions;

    protected function setUp(): void
    {
        parent::setUp();
        if (AttestationType::count() === 0) {
            $this->seed(\Municipal\Attestation\Database\Seeders\AttestationSignatorySeeder::class);
            $this->seed(\Municipal\Attestation\Database\Seeders\AttestationTypeSeeder::class);
        }
    }

    public function test_seeded_types_and_public_pages_load(): void
    {
        $this->assertGreaterThanOrEqual(66, AttestationType::count());

        $bibahit = AttestationType::where('slug', 'bibahit-pratyayan')->firstOrFail();
        $this->assertSame('বিবাহিত প্রত্যয়ন', $bibahit->memo_name);
        $this->assertStringContainsString('বিবাহিত', $bibahit->body_template);

        $enChar = AttestationType::where('slug', 'en-character-certificate')->firstOrFail();
        $this->assertSame('en', $enChar->language);

        $response = $this->get(route('attestation.apply.index'));
        $response->assertStatus(200);
        $response->assertSee('অনলাইন প্রত্যয়ন সেবা');
        $response->assertSee('সনদের সেবাসমূহ');
        $response->assertSee('Character Certificate');

        $formResponse = $this->get(route('attestation.apply.show', $bibahit->slug));
        $formResponse->assertStatus(200);
        $formResponse->assertSee($bibahit->name);
        $formResponse->assertSee('প্রমাণক সংযুক্তি');
    }

    public function test_citizen_can_apply_and_track_and_admin_can_edit_and_approve(): void
    {
        $type = AttestationType::where('slug', 'bibahit-pratyayan')->firstOrFail();

        // 1. Citizen applies publicly
        $postResponse = $this->post(route('attestation.apply.store', $type->slug), [
            'applicant_name' => 'মোঃ করিম উদ্দিন',
            'mobile'         => '01711223344',
            'id_type'        => 'nid',
            'id_no'          => '1990123456789',
            'father_name'    => 'মোঃ রহিম উদ্দিন',
            'mother_name'    => 'মোছাঃ আমেনা বেগম',
            'spouse_name'    => 'মোছাঃ সালমা খাতুন',
            'ward_no'        => '০৫',
            'holding_no'     => '০৪৬০-১০',
            'mohalla'        => 'কলেজপাড়া',
            'upazila'        => 'আলমডাঙ্গা',
            'district'       => 'চুয়াডাঙ্গা',
        ]);

        $app = AttestationApplication::where('mobile', '01711223344')->latest()->firstOrFail();
        $postResponse->assertRedirect(route('attestation.apply.confirmation', $app->tracking_no));
        $this->assertSame(ApplicationStatus::Pending, $app->status);

        // 2. Citizen tracks application
        $trackResponse = $this->post(route('attestation.track.track'), [
            'tracking_no' => $app->tracking_no,
            'mobile'      => '01711223344',
        ]);
        $trackResponse->assertStatus(200);
        $trackResponse->assertSee($app->tracking_no);

        // 3. Admin logs in, edits application, and approves it
        $admin = User::first() ?? User::factory()->create();

        $this->actingAs($admin)
            ->put(route('attestation.applications.update', $app), [
                'applicant_name' => 'মোঃ করিম উদ্দিন (সংশোধিত)',
                'mobile'         => '01711223344',
                'id_type'        => 'nid',
                'id_no'          => '1990123456789',
                'father_name'    => 'মোঃ রহিম উদ্দিন',
                'mother_name'    => 'মোছাঃ আমেনা বেগম',
                'spouse_name'    => 'মোছাঃ সালমা খাতুন',
                'ward_no'        => '০৫',
                'holding_no'     => '০৪৬০-১০',
                'mohalla'        => 'কলেজপাড়া',
                'upazila'        => 'আলমডাঙ্গা',
                'district'       => 'চুয়াডাঙ্গা',
                'payment_status' => 'paid',
                'paid_amount'    => 50,
                'receipt_no'     => 'R-1001',
            ])
            ->assertRedirect(route('attestation.applications.show', $app));

        $approveResponse = $this->actingAs($admin)
            ->post(route('attestation.applications.approve', $app), [
                'payment_status' => 'paid',
                'paid_amount'    => 50,
                'receipt_no'     => 'R-1001',
            ]);

        $cert = Attestation::where('application_id', $app->id)->firstOrFail();
        $approveResponse->assertRedirect(route('attestation.certificates.show', $cert));

        $this->assertStringContainsString('আঃপৌঃ/বিবাহিত প্রত্যয়ন/', $cert->memo_no);
        $this->assertSame('মোঃ করিম উদ্দিন (সংশোধিত)', $cert->subject_name);

        // 4. Print view renders cleanly
        $printResponse = $this->actingAs($admin)
            ->get(route('attestation.certificates.print', $cert));
        $printResponse->assertStatus(200);
        $printResponse->assertSee($cert->memo_no);
        $printResponse->assertSee($cert->verification_code);

        // 4b. Pad mode print view with custom margin
        $padPrintResponse = $this->actingAs($admin)
            ->get(route('attestation.certificates.print', [$cert, 'with_header' => 0, 'pad' => 1.8]));
        $padPrintResponse->assertStatus(200);
        $padPrintResponse->assertSee('প্যাড মার্জিন');
        $padPrintResponse->assertSee('1.8');

        // 5. Public QR verify page renders cleanly
        $verifyResponse = $this->get(route('attestation.verify.show', $cert->verification_code));
        $verifyResponse->assertStatus(200);
        $verifyResponse->assertSee($cert->memo_no);
        $verifyResponse->assertSee('প্রত্যয়নপত্রটি বৈধ ও সত্য');
    }

    public function test_memo_sequence_increments_per_type_and_resets_yearly(): void
    {
        $type1 = AttestationType::where('slug', 'obibahit-pratyayan')->firstOrFail();
        $type2 = AttestationType::where('slug', 'bibahit-pratyayan')->firstOrFail();

        $m1 = MemoGenerator::next($type1->id, $type1->memo_name, 2030);
        $m2 = MemoGenerator::next($type1->id, $type1->memo_name, 2030);
        $m3 = MemoGenerator::next($type1->id, $type1->memo_name, 2031); // new year -> resets to 1
        $m4 = MemoGenerator::next($type2->id, $type2->memo_name, 2030); // different type -> starts at 1

        $this->assertSame(1, $m1['serial']);
        $this->assertSame(2, $m2['serial']);
        $this->assertSame(1, $m3['serial']);
        $this->assertSame(1, $m4['serial']);

        $this->assertSame('আঃপৌঃ/অবিবাহিত প্রত্যয়ন/২০৩০/০১', $m1['memo_no']);
        $this->assertSame('আঃপৌঃ/অবিবাহিত প্রত্যয়ন/২০৩০/০২', $m2['memo_no']);
        $this->assertSame('আঃপৌঃ/অবিবাহিত প্রত্যয়ন/২০৩১/০১', $m3['memo_no']);
        $this->assertSame('আঃপৌঃ/বিবাহিত প্রত্যয়ন/২০৩০/০১', $m4['memo_no']);

        // English certificate memo check
        $enType = AttestationType::where('slug', 'en-character-certificate')->firstOrFail();
        $mEn = MemoGenerator::next($enType->id, $enType->memo_name, 2030);
        $this->assertSame('A:P:/Character Certificate/2030/01', $mEn['memo_no']);
    }
}

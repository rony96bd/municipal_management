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
        $response->assertSee('Tiro Bangla');

        $formResponse = $this->get(route('attestation.apply.show', $bibahit->slug));
        $formResponse->assertStatus(200);
        $formResponse->assertSee($bibahit->name);
        $formResponse->assertSee('প্রমাণক সংযুক্তি');
        $formResponse->assertSee('Tiro Bangla');

        $this->assertSame('Tiro Bangla', config('attestation.print.font'));
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
        $printResponse->assertSee('Tiro Bangla');
        $printResponse->assertSee('--ink: #000000;');
        $printResponse->assertSee('--muted: #000000;');

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
        $verifyResponse->assertSee('Tiro Bangla');
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

    public function test_pre_pourasava_death_certificate_type_exists_and_shares_memo_sequence(): void
    {
        $old = AttestationType::where('slug', 'mrityu-pratyayan')->firstOrFail();
        $new = AttestationType::where('slug', 'mrityu-pratyayan-pourasava-purbe')->firstOrFail();

        $this->assertSame('মৃত্যু প্রত্যয়ন', $new->memo_name);
        $this->assertStringContainsString('পৌরসভা প্রতিষ্ঠিত হওয়ার পূর্বে', $new->body_template);

        $m1 = MemoGenerator::next($old->id, $old->memo_name, 2035);
        $m2 = MemoGenerator::next($new->id, $new->memo_name, 2035);
        $this->assertSame($m1['serial'] + 1, $m2['serial']);
        $this->assertNotSame($m1['memo_no'], $m2['memo_no']);

        $admin = User::factory()->create();
        $form = $this->actingAs($admin)->get(route('attestation.certificates.create', ['type_id' => $new->id]));
        $form->assertStatus(200);
        $form->assertSee('বার্ধক্য জনিত');
        $form->assertSee('মোঃ মানোয়ার হোসেন');
    }

    public function test_cancelled_certificate_can_be_deleted_from_admin(): void
    {
        $admin = User::factory()->create();
        $type = AttestationType::firstOrFail();

        $cert = Attestation::create([
            'attestation_type_id' => $type->id,
            'memo_no'             => 'আঃপৌঃ/চারিত্রিক সনদ/২০২৬/৯৯',
            'year'                => 2026,
            'serial'              => 99,
            'issue_date'          => today(),
            'verification_code'   => Attestation::generateVerificationCode(),
            'snapshot'            => ['fields' => []],
            'subject_name'        => 'পরীক্ষামূলক নাগরিক',
            'id_no'               => '1234567890',
            'fee'                 => 100,
            'payment_status'      => 'paid',
            'paid_amount'         => 100,
            'issued_by'           => $admin->id,
            'is_cancelled'        => false,
        ]);

        // 1. Initially active certificate should NOT have delete button on index
        $indexResponse = $this->actingAs($admin)->get(route('attestation.certificates.index'));
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee($cert->memo_no);
        $indexResponse->assertDontSee('🗑 ডিলিট');

        // Trying to delete active certificate should be blocked
        $failDelete = $this->actingAs($admin)->delete(route('attestation.certificates.destroy', $cert));
        $failDelete->assertRedirect(route('attestation.certificates.index'));
        $this->assertDatabaseHas('attestations', ['id' => $cert->id, 'deleted_at' => null]);

        // 2. Cancel certificate
        $cancelResponse = $this->actingAs($admin)->post(route('attestation.certificates.cancel', $cert), [
            'cancel_reason' => 'ভুল তথ্যের কারণে বাতিল',
        ]);
        $cancelResponse->assertRedirect(route('attestation.certificates.index'));
        $cert->refresh();
        $this->assertTrue($cert->is_cancelled);

        // 3. Cancelled certificate should now show delete button on index
        $indexResponseAfterCancel = $this->actingAs($admin)->get(route('attestation.certificates.index'));
        $indexResponseAfterCancel->assertStatus(200);
        $indexResponseAfterCancel->assertSee('বাতিল');
        $indexResponseAfterCancel->assertSee('🗑 ডিলিট');

        // 4. Delete cancelled certificate
        $deleteResponse = $this->actingAs($admin)->delete(route('attestation.certificates.destroy', $cert));
        $deleteResponse->assertRedirect(route('attestation.certificates.index'));

        // Certificate should now be soft deleted
        $this->assertSoftDeleted('attestations', ['id' => $cert->id]);
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Municipal\Attestation\Database\Seeders\AttestationTypeSeeder;
use Municipal\Attestation\Enums\ApplicationStatus;
use Municipal\Attestation\Models\AttestationApplication;
use Municipal\Attestation\Models\AttestationType;
use Tests\TestCase;

class AttestationTrackFlexibleTest extends TestCase
{
    use RefreshDatabase;

    private function createSampleApplication(string $trackingNo, string $mobile, string $name = 'রহিম উদ্দিন'): AttestationApplication
    {
        if (AttestationType::count() === 0) {
            $this->seed(AttestationTypeSeeder::class);
        }

        $type = AttestationType::firstOrFail();

        return AttestationApplication::create([
            'attestation_type_id' => $type->id,
            'tracking_no'         => $trackingNo,
            'applicant_name'      => $name,
            'mobile'              => $mobile,
            'status'              => ApplicationStatus::Pending,
            'form_data'           => ['nid' => '1234567890'],
        ]);
    }

    public function test_track_with_tracking_no_only_via_get_and_post(): void
    {
        $app = $this->createSampleApplication('ATT-2026-1111', '01711223344', 'মো: সুমন');

        // GET tracking_no only
        $getResponse = $this->get(route('attestation.track.index', ['tracking_no' => 'ATT-2026-1111']));
        $getResponse->assertStatus(200);
        $getResponse->assertSee('মো: সুমন');
        $getResponse->assertSee('ATT-2026-1111');

        // POST tracking_no only
        $postResponse = $this->post(route('attestation.track.track'), ['tracking_no' => 'ATT-2026-1111']);
        $postResponse->assertStatus(200);
        $postResponse->assertSee('মো: সুমন');
        $postResponse->assertSee('ATT-2026-1111');
    }

    public function test_track_with_mobile_only_via_get_and_post(): void
    {
        $app = $this->createSampleApplication('ATT-2026-2222', '01899887766', 'মোছা: মরিয়ম');

        // GET mobile only
        $getResponse = $this->get(route('attestation.track.index', ['mobile' => '01899887766']));
        $getResponse->assertStatus(200);
        $getResponse->assertSee('মোছা: মরিয়ম');
        $getResponse->assertSee('ATT-2026-2222');

        // POST mobile only
        $postResponse = $this->post(route('attestation.track.track'), ['mobile' => '01899887766']);
        $postResponse->assertStatus(200);
        $postResponse->assertSee('মোছা: মরিয়ম');
        $postResponse->assertSee('ATT-2026-2222');
    }

    public function test_track_with_bengali_digits_converted_automatically(): void
    {
        $this->createSampleApplication('ATT-2026-3333', '01712345678', 'তারিক হাসান');

        // Search using Bengali digits in mobile: ০১৭১২৩৪৫৬৭৮
        $response = $this->post(route('attestation.track.track'), ['mobile' => '০১৭১২৩৪৫৬৭৮']);
        $response->assertStatus(200);
        $response->assertSee('তারিক হাসান');
        $response->assertSee('ATT-2026-3333');
    }

    public function test_track_lists_multiple_applications_for_same_mobile(): void
    {
        $this->createSampleApplication('ATT-2026-4001', '01700000000', 'আবেদন এক');
        $this->createSampleApplication('ATT-2026-4002', '01700000000', 'আবেদন দুই');

        $response = $this->post(route('attestation.track.track'), ['mobile' => '01700000000']);
        $response->assertStatus(200);
        $response->assertSee('ATT-2026-4001');
        $response->assertSee('ATT-2026-4002');
        $response->assertSee('আবেদন এক');
        $response->assertSee('আবেদন দুই');
    }

    public function test_track_paginates_when_more_than_twenty_applications(): void
    {
        for ($i = 1; $i <= 25; $i++) {
            $num = str_pad((string) $i, 4, '0', STR_PAD_LEFT);
            $this->createSampleApplication("ATT-PAGE-{$num}", '01755555555', "আবেদনকারী {$i}");
        }

        $response = $this->get(route('attestation.track.index', ['mobile' => '01755555555']));
        $response->assertStatus(200);
        $response->assertSee('আবেদনসমূহ (মোট: ২৫টি)');
        $response->assertSee('ATT-PAGE-0025');
        $response->assertSee('page=2');
    }

    public function test_track_requires_at_least_one_input(): void
    {
        $response = $this->post(route('attestation.track.track'), [
            'tracking_no' => '',
            'mobile'      => '',
        ]);

        $response->assertSessionHasErrors(['tracking_no']);
    }

    public function test_track_routes_have_strict_fifteen_per_minute_rate_limiting(): void
    {
        $getIndexRoute = app('router')->getRoutes()->getByName('attestation.track.index');
        $this->assertContains('throttle:15,1,track', $getIndexRoute->gatherMiddleware());

        $postTrackRoute = app('router')->getRoutes()->getByName('attestation.track.track');
        $this->assertContains('throttle:15,1,track', $postTrackRoute->gatherMiddleware());
    }
}

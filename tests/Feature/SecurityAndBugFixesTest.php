<?php

namespace Tests\Feature;

use App\Models\media\MediaModel;
use App\Models\notice\NoticeModel;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Municipal\Attestation\Enums\ApplicationStatus;
use Municipal\Attestation\Models\AttestationApplication;
use Municipal\Attestation\Models\AttestationType;
use Tests\TestCase;

class SecurityAndBugFixesTest extends TestCase
{
    use DatabaseTransactions;

    public function test_clear_cache_requires_auth_and_returns_json_without_dd(): void
    {
        $this->post(route('clear.cache'))
            ->assertRedirect(route('login'));

        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->postJson(route('clear.cache'));

        $response->assertStatus(200)
            ->assertJson([
                'status' => 'success',
            ])
            ->assertJsonStructure(['status', 'messages']);
    }

    public function test_public_search_never_exposes_users_and_renders_results_view(): void
    {
        $admin = User::factory()->create([
            'name' => 'SecretAdminUserXYZ',
            'email' => 'secretadminxyz@example.com',
        ]);

        // Empty or wildcard query must not dump users or crash with missing view
        $emptyResponse = $this->get(route('search', ['query' => '']));
        $emptyResponse->assertStatus(200);
        $emptyResponse->assertDontSee('SecretAdminUserXYZ');
        $emptyResponse->assertDontSee('secretadminxyz@example.com');

        $wildcardResponse = $this->get(route('search', ['query' => '%']));
        $wildcardResponse->assertStatus(200);
        $wildcardResponse->assertDontSee('SecretAdminUserXYZ');
        $wildcardResponse->assertDontSee('secretadminxyz@example.com');

        // Searching by an admin user's exact name must NOT expose user record/email
        $userSearchResponse = $this->get(route('search', ['query' => 'SecretAdminUserXYZ']));
        $userSearchResponse->assertStatus(200);
        $userSearchResponse->assertSee('কোনো ফলাফল পাওয়া যায়নি');
        $userSearchResponse->assertDontSee('secretadminxyz@example.com');

        // Searching for a public notice works
        $notice = new NoticeModel();
        $notice->topic = 'বিশেষ পৌর নোটিশ ২০২৬';
        $notice->description = 'বিস্তারিত তথ্য';
        $notice->page_url = 'test-notice-2026';
        $notice->save();

        $noticeSearch = $this->get(route('search', ['query' => 'বিশেষ পৌর নোটিশ']));
        $noticeSearch->assertStatus(200);
        $noticeSearch->assertSee('বিশেষ পৌর নোটিশ ২০২৬');
    }

    public function test_notice_store_and_update_preserves_existing_file_when_not_replaced(): void
    {
        $admin = User::factory()->create();

        // Store without file
        $storeResponse = $this->actingAs($admin)->post(route('store-notice'), [
            'topic' => 'নতুন জরুরি নোটিশ',
            'description' => 'বিবরণ',
        ]);
        $storeResponse->assertRedirect(route('notice'));

        $notice = NoticeModel::where('topic', 'নতুন জরুরি নোটিশ')->firstOrFail();
        $notice->file_path = 'attestments/existing_sample.pdf';
        $notice->save();

        // Update without uploading a new file -> existing file_path must be preserved
        $updateResponse = $this->actingAs($admin)->put(route('notice-update', $notice->id), [
            'topic' => 'আপডেটেড জরুরি নোটিশ',
            'description' => 'নতুন বিবরণ',
        ]);
        $updateResponse->assertRedirect(route('notice'));

        $notice->refresh();
        $this->assertSame('আপডেটেড জরুরি নোটিশ', $notice->topic);
        $this->assertSame('attestments/existing_sample.pdf', $notice->file_path);
    }

    public function test_media_upload_records_actual_file_size_and_deletes_safely(): void
    {
        $admin = User::factory()->create();
        $file = UploadedFile::fake()->image('banner.jpg', 100, 100)->size(42);

        $response = $this->actingAs($admin)->post(route('media-store'), [
            'file' => $file,
        ]);
        $response->assertRedirect();

        $media = MediaModel::latest('id')->firstOrFail();
        $this->assertGreaterThan(0, (int) $media->size);

        $uploadedFullPath = public_path($media->file_path);
        $this->assertFileExists($uploadedFullPath);

        // Clean up via destroy endpoint
        $this->actingAs($admin)->delete(route('media-destroy', $media->id))
            ->assertRedirect();

        $this->assertFileDoesNotExist($uploadedFullPath);
    }

    public function test_attestation_get_track_requires_mobile_to_prevent_idor(): void
    {
        if (AttestationType::count() === 0) {
            $this->seed(\Municipal\Attestation\Database\Seeders\AttestationTypeSeeder::class);
        }

        $type = AttestationType::firstOrFail();
        $app = AttestationApplication::create([
            'attestation_type_id' => $type->id,
            'tracking_no'         => 'ATT-TEST-99999',
            'applicant_name'      => 'গোপন আবেদনকারী',
            'mobile'              => '01799887766',
            'status'              => ApplicationStatus::Pending,
            'form_data'           => [],
        ]);

        // GET with only tracking_no (no mobile) must NOT leak applicant details
        $withoutMobile = $this->get(route('attestation.track.index', [
            'tracking_no' => 'ATT-TEST-99999',
        ]));
        $withoutMobile->assertStatus(200);
        $withoutMobile->assertDontSee('গোপন আবেদনকারী');

        // GET with matching tracking_no AND mobile shows the application
        $withMobile = $this->get(route('attestation.track.index', [
            'tracking_no' => 'ATT-TEST-99999',
            'mobile'      => '01799887766',
        ]));
        $withMobile->assertStatus(200);
        $withMobile->assertSee('গোপন আবেদনকারী');
    }

    public function test_non_admin_user_cannot_access_user_management(): void
    {
        $staff = User::factory()->create(['role' => 'staff']);

        $this->actingAs($staff)->get(route('users-list'))->assertStatus(403);
        $this->actingAs($staff)->get(route('create-user'))->assertStatus(403);
        $this->actingAs($staff)->get(route('site-setting'))->assertStatus(403);
        $this->actingAs($staff)->get(route('menus'))->assertStatus(403);
        $this->actingAs($staff)->get(route('sidebar'))->assertStatus(403);
        $this->actingAs($staff)->postJson(route('clear.cache'))->assertStatus(403);
        $this->actingAs($staff)->post(route('store-user'), [
            'name' => 'Hacker',
            'email' => 'hacker@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ])->assertStatus(403);
    }

    public function test_admin_cannot_downgrade_self_or_last_admin_and_role_change_invalidates_session(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $otherAdmin = User::factory()->create(['role' => 'admin']);

        // Admin cannot downgrade themselves
        $this->actingAs($admin)->put(route('update-user', $admin->id), [
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => 'staff',
        ])->assertSessionHas('error');

        $admin->refresh();
        $this->assertSame('admin', $admin->role);

        // Downgrading another admin succeeds and invalidates their session on next request
        $this->actingAs($otherAdmin)
            ->withSession(['auth_user_role' => 'admin'])
            ->get(route('dashboard'))
            ->assertStatus(200);

        $this->actingAs($admin)->put(route('update-user', $otherAdmin->id), [
            'name' => $otherAdmin->name,
            'email' => $otherAdmin->email,
            'role' => 'staff',
        ])->assertRedirect(route('users-list'));

        $otherAdmin->refresh();
        $this->assertSame('staff', $otherAdmin->role);

        // Next request by downgraded user with stale session role is logged out
        $this->actingAs($otherAdmin)
            ->withSession(['auth_user_role' => 'admin'])
            ->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_single_page_renders_redesigned_view_sanitizes_html_and_returns_404_when_missing(): void
    {
        $page = new \App\Models\page\createpage();
        $page->page_name = 'পৌরসভার বাজেট ২০২৬';
        $page->page_url = 'test-budget-2026';
        $page->page_data = '<p>বাজেট তথ্য</p><script>alert(1)</script>';
        $page->file_path = 'pages/sample-budget.pdf';
        $page->save();

        $response = $this->get(route('page-details', 'test-budget-2026'));
        $response->assertStatus(200);
        $response->assertSee('পৌরসভার বাজেট ২০২৬');
        $response->assertSee('বাজেট তথ্য');
        $response->assertDontSee('<script>alert(1)</script>', false);
        $response->assertSee('ডাউনলোড করুন');
        $response->assertSee('detail-card');
        $response->assertSee('detail-lightbox');

        $this->get(route('page-details', 'non-existent-page-xyz'))->assertStatus(404);
    }
}

<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_cannot_access_user_management(): void
    {
        $response = $this->get(route('users-list'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('create-user'));
        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_view_users_list(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('users-list'));

        $response->assertStatus(200);
        $response->assertSee($user->name);
        $response->assertSee($user->email);
        $response->assertSee('ইউজার লিস্ট');
    }

    public function test_authenticated_user_can_view_create_user_page(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('create-user'));

        $response->assertStatus(200);
        $response->assertSee('নতুন ইউজার');
    }

    public function test_authenticated_user_can_create_new_user(): void
    {
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->post(route('store-user'), [
            'name' => 'নতুন এডমিন',
            'email' => 'newadmin@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('users-list'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('users', [
            'name' => 'নতুন এডমিন',
            'email' => 'newadmin@example.com',
        ]);

        $newUser = User::where('email', 'newadmin@example.com')->first();
        $this->assertTrue(Hash::check('password123', $newUser->password));
    }

    public function test_user_creation_validation(): void
    {
        $admin = User::factory()->create();

        // Duplicate email
        $existing = User::factory()->create(['email' => 'duplicate@example.com']);

        $response = $this->actingAs($admin)->post(route('store-user'), [
            'name' => 'টেস্ট',
            'email' => 'duplicate@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors('email');

        // Password mismatch
        $response = $this->actingAs($admin)->post(route('store-user'), [
            'name' => 'টেস্ট',
            'email' => 'unique@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different',
        ]);

        $response->assertSessionHasErrors('password');
    }

    public function test_authenticated_user_can_view_edit_page(): void
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('edit-user', $targetUser->id));

        $response->assertStatus(200);
        $response->assertSee($targetUser->name);
        $response->assertSee($targetUser->email);
    }

    public function test_authenticated_user_can_update_user_info_without_password(): void
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create([
            'name' => 'পুরাতন নাম',
            'email' => 'old@example.com',
            'password' => Hash::make('originalpassword'),
        ]);

        $response = $this->actingAs($admin)->put(route('update-user', $targetUser->id), [
            'name' => 'হালনাগাদ নাম',
            'email' => 'updated@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        $response->assertRedirect(route('users-list'));
        $response->assertSessionHas('success');

        $targetUser->refresh();
        $this->assertEquals('হালনাগাদ নাম', $targetUser->name);
        $this->assertEquals('updated@example.com', $targetUser->email);
        $this->assertTrue(Hash::check('originalpassword', $targetUser->password));
    }

    public function test_authenticated_user_can_update_user_with_new_password_in_edit(): void
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create([
            'password' => Hash::make('originalpassword'),
        ]);

        $response = $this->actingAs($admin)->put(route('update-user', $targetUser->id), [
            'name' => $targetUser->name,
            'email' => $targetUser->email,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('users-list'));
        $targetUser->refresh();
        $this->assertTrue(Hash::check('newpassword123', $targetUser->password));
    }

    public function test_authenticated_user_can_view_change_password_page(): void
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create();

        $response = $this->actingAs($admin)->get(route('change-password-user', $targetUser->id));

        $response->assertStatus(200);
        $response->assertSee($targetUser->name);
        $response->assertSee('পাসওয়ার্ড');
    }

    public function test_authenticated_user_can_change_password(): void
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create([
            'password' => Hash::make('oldpassword'),
        ]);

        $response = $this->actingAs($admin)->put(route('update-password-user', $targetUser->id), [
            'password' => 'brandnewpass123',
            'password_confirmation' => 'brandnewpass123',
        ]);

        $response->assertRedirect(route('users-list'));
        $response->assertSessionHas('success');

        $targetUser->refresh();
        $this->assertTrue(Hash::check('brandnewpass123', $targetUser->password));
    }

    public function test_authenticated_user_can_delete_another_user(): void
    {
        $admin = User::factory()->create();
        $targetUser = User::factory()->create();

        $response = $this->actingAs($admin)->delete(route('delete-user', $targetUser->id));

        $response->assertRedirect(route('users-list'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('users', [
            'id' => $targetUser->id,
        ]);
    }

    public function test_user_cannot_delete_themselves(): void
    {
        $admin = User::factory()->create();
        User::factory()->create(); // second user so count > 1

        $response = $this->actingAs($admin)->delete(route('delete-user', $admin->id));

        $response->assertRedirect(route('users-list'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $admin->id,
        ]);
    }

    public function test_cannot_delete_last_remaining_user(): void
    {
        User::query()->delete();
        $onlyUser = User::factory()->create();

        $caller = User::make(['id' => 99999, 'name' => 'Mock Admin']);

        $response = $this->actingAs($caller)->delete(route('delete-user', $onlyUser->id));
        $response->assertRedirect(route('users-list'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('users', [
            'id' => $onlyUser->id,
        ]);
    }
}

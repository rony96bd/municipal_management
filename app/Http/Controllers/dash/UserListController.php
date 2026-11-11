<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserListController extends Controller
{
    /**
     * Display a listing of all admin users.
     */
    public function UsersList()
    {
        $page_title = 'ইউজার লিস্ট';
        $users = User::orderBy('id', 'desc')->get();
        return view('dashboard.users.users', compact('page_title', 'users'));
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        $page_title = 'নতুন ইউজার যুক্ত করুন';
        return view('dashboard.users.create', compact('page_title'));
    }

    /**
     * Store a newly created admin user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ], [
            'name.required' => 'ইউজারের নাম প্রদান করা আবশ্যক।',
            'email.required' => 'ই-মেইল প্রদান করা আবশ্যক।',
            'email.email' => 'সঠিক ই-মেইল ঠিকানা প্রদান করুন।',
            'email.unique' => 'এই ই-মেইল ঠিকানাটি ইতোমধ্যে ব্যবহার করা হয়েছে।',
            'password.required' => 'পাসওয়ার্ড প্রদান করা আবশ্যক।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মেলেনি।',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users-list')->with('success', 'নতুন ইউজার সফলভাবে যুক্ত করা হয়েছে।');
    }

    /**
     * Show the form for editing the specified admin user.
     */
    public function edit($id)
    {
        $page_title = 'ইউজার তথ্য সম্পাদনা করুন';
        $user = User::findOrFail($id);
        return view('dashboard.users.edit', compact('page_title', 'user'));
    }

    /**
     * Update the specified admin user in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', Password::defaults(), 'confirmed'],
        ], [
            'name.required' => 'ইউজারের নাম প্রদান করা আবশ্যক।',
            'email.required' => 'ই-মেইল প্রদান করা আবশ্যক।',
            'email.email' => 'সঠিক ই-মেইল ঠিকানা প্রদান করুন।',
            'email.unique' => 'এই ই-মেইল ঠিকানাটি ইতোমধ্যে ব্যবহার করা হয়েছে।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মেলেনি।',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users-list')->with('success', 'ইউজারের তথ্য সফলভাবে আপডেট করা হয়েছে।');
    }

    /**
     * Show the form for changing the user's password.
     */
    public function changePassword($id)
    {
        $page_title = 'ইউজার পাসওয়ার্ড পরিবর্তন করুন';
        $user = User::findOrFail($id);
        return view('dashboard.users.change-password', compact('page_title', 'user'));
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'password' => ['required', 'string', Password::defaults(), 'confirmed'],
        ], [
            'password.required' => 'নতুন পাসওয়ার্ড প্রদান করা আবশ্যক।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মেলেনি।',
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('users-list')->with('success', "{$user->name} এর পাসওয়ার্ড সফলভাবে পরিবর্তন করা হয়েছে।");
    }

    /**
     * Remove the specified admin user from storage.
     */
    public function destroy($id)
    {
        if (auth()->id() == $id) {
            return redirect()->route('users-list')->with('error', 'আপনি নিজের সক্রিয় একাউন্ট ডিলিট করতে পারবেন না।');
        }

        if (User::count() <= 1) {
            return redirect()->route('users-list')->with('error', 'সিস্টেমের একমাত্র ইউজার মুছে ফেলা সম্ভব নয়।');
        }

        $user = User::findOrFail($id);
        $userName = $user->name;
        $user->delete();

        return redirect()->route('users-list')->with('success', "{$userName} ইউজারকে সফলভাবে মুছে ফেলা হয়েছে।");
    }
}

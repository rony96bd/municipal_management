<?php

namespace App\Http\Controllers\dash;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserListController extends Controller
{
    public function UsersList()
    {
        $page_title = 'ইউজার লিস্ট';
        $users = User::all();
        return view('dashboard.users.users', compact('page_title', 'users'));
    }
}

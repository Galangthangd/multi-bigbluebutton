<?php

namespace App\Http\Controllers\BBB;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function create() {
        return view('pages.user.create');
    }

    public function store() {
        $this->validate(request(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|min:6|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed'
        ]);

        Log::info("Creating user...");
        Log::info(request(['name', 'username', 'email', 'password']));
        User::create(request(['name', 'username', 'email', 'password']));

        return redirect()->to('/home');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

final class RegistrationController
{
    //Register a user
    public function store(Request $request)
    {
        $data = $request->validate([
            "email" => ["required", "email"],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        return User::create($data);
    }
}

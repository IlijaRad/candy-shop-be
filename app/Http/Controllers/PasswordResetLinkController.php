<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController
{
    public function store(Request $request)
    {
        $request->validate([
            "email" => ["required", "email"],
        ]);

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if (null !== $user) {
            defer(function () use ($request) {
                Password::sendResetLink($request->only('email'));
            });
        }

        return response()->noContent();
    }
}

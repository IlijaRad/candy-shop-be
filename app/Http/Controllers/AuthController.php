<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

final class AuthController
{

    //Login
    public function store(Request $request): JsonResponse
    {

        $request->validate([
            "email" => ["required", "email"],
            "password" => "required"
        ]);

        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if (! $user) {
            throw ValidationException::withMessages([
                'email' => ['Nepostojeća email adresa'],
            ]);
        }

        if (! Hash::check($request->get('password'), $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['Pogrešna lozinka'],
            ]);
        }

        $expiresAt = now()->addDay();

        return response()->json([
            'token' => $user->createToken(User::AUTHENTICATION_TOKEN_NAME, ['*'], $expiresAt)->plainTextToken,
        ]);
    }

    //Get authenticated user
    public function show() {}

    //Logout
    public function destroy(Request $request): Response
    {
        $user = $request->user();

        $token = $user->currentAccessToken();
        $token->delete();

        return response()->noContent();
    }
}

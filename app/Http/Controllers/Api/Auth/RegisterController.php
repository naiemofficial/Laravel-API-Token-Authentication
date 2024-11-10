<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{   
    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterRequest $request)
    {
        $user = User::create();
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => "User registered successfully",
            'access_token' => $token,
            'token_type' => "Bearer"
        ], 201);
    }
}

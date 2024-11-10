<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;


class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(LoginRequest $request)
    {
        $email = $request->email;
        $password = $request->password;

        $user = User::where('email', $email)->first();
        
        // Invalid credentials
        if(!$user || !Hash::check($password, $user->password)){
            return response()->json([
                'message' => "The provided credentials are incorrect"
            ], 401);
        }


        // Delete old tokens
        $user->tokens()->delete();
        

        
        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => "Bearer"
        ], 200);
        
    }
}



<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SendResetLinkRequest;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use App\Mail\PasswordUpdated;

class PasswordResetController extends Controller
{
    //
    public function sendResetLink(SendResetLinkRequest $request){
        try {
            Mail::to($request->email)->send(new ResetPassword($request->email));
            // Mail::to($request->email)->queue(new ResetPassword($request->email));

            return response()->json([
                'message' => 'Reset link sent successfully'
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'message'   => 'Failed to send reset link',
                'error'     => $error->getMessage()
            ], 500);
        }
    }
    public function resetPassword(ResetPasswordRequest $request){
        $user = User::where('email', $request->email)->first();

        if(!$user){
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        $response = ['message' => 'Password reset successfully'];

        try {
            Mail::to($user->email)->send(new PasswordUpdated());
        } catch (\Exception $error) {
            $response['error'][] = 'Failed to send password updated email';
        }
        
        return response()->json($response, 200);
        
    }
}

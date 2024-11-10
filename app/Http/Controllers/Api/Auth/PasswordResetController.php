<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SendResetLinkRequest;
use App\Mail\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;

class PasswordResetController extends Controller
{
    //
    public function sendResetLink(SendResetLinkRequest $request){
        try {
            $url = URL::temporarySignedRoute('password.reset', now()->addMinute(30), ['email' => $request->email]);
            Mail::to($request->email)->send(new ResetPassword($url));
            // Mail::to($request->email)->queue(new ResetPassword());

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

        
        return response()->json([
            'message' => 'Password reset successfully'
        ], 200);
        
    }
}

<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SendVerificationEmailRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerification;
use App\Mail\EmailVerificationComplete;
use App\Http\Requests\VerifyEmailRequest;

class VerifyEmailController extends Controller
{
    public function sendVerificationEmail(SendVerificationEmailRequest $request){
        $is_verified = auth()->user()->email_verified_at;
        if($is_verified){
            return response()->json([
                'message' => 'Email already verified'
            ], 400);
        }

        try {
            Mail::to(auth()->user()->email)->send(new EmailVerification(auth()->user()));

            return response()->json([
                'message' => 'Verification email sent successfully'
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'message'   => 'Failed to send verification email',
                'error'     => $error->getMessage()
            ], 500);
        }
    }


    public function verifyEmail(VerifyEmailRequest $request){
        $user = auth()->user();
        if($user->hasVerifiedEmail()){
            return response()->json([
                'message' => 'Email already verified'
            ], 400);
        }


        // Update the user email_verified_at column
        $user->forceFill([
            'email_verified_at' => now(),
        ])->save();


        $response = ['message' => 'Email verified successfully'];
        try {
            Mail::to($user->email)->send(new EmailVerificationComplete($user));
        } catch (\Exception $error) {
            $response['error'][] = 'Failed to send verification email';
        }

        return response()->json($response, 200);

    }
}

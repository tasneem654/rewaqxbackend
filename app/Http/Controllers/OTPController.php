<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\OTP;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Carbon\Carbon;

class OTPController extends Controller
{
    // 1. Send OTP
    public function sendOTP(Request $request)
{
    $request->validate(['email' => 'required|email']);
    
    \Log::info("Attempting to send OTP to: " . $request->email);
    
    try {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            \Log::warning("User not found for email: " . $request->email);
            return response()->json([
                'message' => 'Email not found. Please, Check with your company admin',
            ], 404);
        }

        \Log::info("Found user: " . json_encode([
            'id' => $user->id,
            'email' => $user->email,
            'created_at' => $user->created_at
        ]));

        // Rate Limit Check
        $key = 'otp-send-' . $request->email;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            return response()->json(['error' => 'Too many OTP requests. Try again later.'], 429);
        }
        RateLimiter::hit($key, 3600);

        $otpCode = random_int(100000, 999999);
        \Log::info("Generated OTP: $otpCode");

        // Save OTP to Database
        try {
            OTP::updateOrCreate(
                ['email' => $request->email],
                ['otp' => Hash::make($otpCode), 'expires_at' => Carbon::now()->addMinutes(5)]
            );
            \Log::info("OTP saved successfully for email: {$request->email}");
        } catch (\Exception $e) {
            \Log::error("Failed to save OTP: " . $e->getMessage());
            return response()->json(['error' => 'Failed to save OTP.'], 500);
        }

        // Send Email - ADD EXTRA LOGGING HERE
        \Log::info("Attempting to send email to: " . $user->email);
        try {
            Mail::raw("Your OTP Code: $otpCode", function ($message) use ($user) {
                $message->to($user->email)->subject("Your OTP Code");
                \Log::info("Mailer configured to send to: " . $user->email);
            });
            \Log::info("OTP email sent to: {$user->email}");
        } catch (\Exception $e) {
            \Log::error("Failed to send email: " . $e->getMessage());
            \Log::error("Full exception: " . (string) $e);
            return response()->json([
                'error' => 'Failed to send OTP email.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }

        return response()->json(['message' => 'OTP sent successfully!']);

    } catch (\Exception $e) {
        \Log::error("Unexpected error in sendOTP: " . $e->getMessage());
        return response()->json(['error' => 'An unexpected error occurred'], 500);
    }
}

    // 2. Verify OTP
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required'
        ]);

        $otpRecord = OTP::where('email', $request->email)->first();

        if (!$otpRecord || Carbon::now()->gt($otpRecord->expires_at)) {
            return response()->json(['error' => 'Invalid or expired OTP'], 400);
        }

        // Verify OTP
        if (!Hash::check($request->otp, $otpRecord->otp)) {
            return response()->json(['error' => 'Invalid OTP'], 400);
        }

        // Delete OTP after successful verification
        $otpRecord->delete();

        // Find or create the user by email
        $user = User::firstOrCreate(
            ['email' => $request->email],
            ['password' => Hash::make('default-password')] // Adjust as needed
        );

        return response()->json(['message' => 'OTP verified successfully!']);
    }
}
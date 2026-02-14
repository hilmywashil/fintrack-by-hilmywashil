<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\SendOtpMail;
use DB;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showEmailForm()
    {
        return view('auth.forgot-password');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email tidak terdaftar');
        }

        $otp = rand(100000, 999999);

        DB::table('password_reset_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10),
                'created_at' => now(),
                'updated_at' => now()
            ]
        );

        Mail::to($request->email)->send(new SendOtpMail($otp));

        session(['reset_email' => $request->email]);

        return redirect()->route('otp.form')
            ->with('success', 'Kode OTP telah dikirim ke email');
    }

    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required'
        ]);

        $email = session('reset_email');

        $record = DB::table('password_reset_otps')
            ->where('email', $email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record) {
            return back()->with('error', 'OTP salah');
        }

        if (Carbon::parse($record->expires_at) < now()) {
            return back()->with('error', 'OTP sudah kadaluarsa');
        }

        session(['otp_verified' => true]);

        return redirect()->route('reset.password.form');
    }

    public function showResetPasswordForm()
    {
        return view('auth.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        $email = session('reset_email');

        User::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);

        DB::table('password_reset_otps')->where('email', $email)->delete();
        
        session()->forget('reset_email');
        session()->forget('otp_verified');

        return redirect()->route('login')
            ->with('success', 'Password berhasil diubah');
    }

}


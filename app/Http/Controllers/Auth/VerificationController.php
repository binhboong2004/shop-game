<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class VerificationController extends Controller
{
    /**
     * Handle the custom email verification via token.
     */
    public function verifyToken($token)
    {
        $user = \App\Models\User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('dangnhap')->withErrors(['email' => 'Mã xác thực không hợp lệ hoặc tài khoản đã được xác thực.']);
        }

        $user->is_verified = true;
        $user->activation_token = null;
        $user->email_verified_at = now();
        $user->save();

        return redirect('/')->with('success', 'Tài khoản của bạn đã được xác thực thành công!');
    }
}

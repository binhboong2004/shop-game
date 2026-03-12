<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Illuminate\Support\Str;
use App\Mail\VerifyAccountMail;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            // Check role and redirect
            $redirectUrl = '/';
            if ($user->role === 'admin') {
                $redirectUrl = '/admin/dashboard';
            } elseif ($user->role === 'agent') {
                $redirectUrl = '/agent/dashboard';
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đăng nhập thành công! Đang chuyển hướng...',
                    'redirect' => $redirectUrl
                ]);
            }

            return redirect()->intended($redirectUrl);
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Email hoặc mật khẩu không chính xác.'
            ], 422);
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('auth_state_changed', true);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'email.unique' => 'Email này đã được sử dụng.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải chứa ít nhất 6 ký tự.'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'member',
            'balance' => 0,
            'status' => 'active',
            'is_verified' => false,
            'activation_token' => Str::random(60),
        ]);

        // Gửi email xác thực tài khoản
        Mail::to($user->email)->send(new VerifyAccountMail($user));

        Auth::login($user);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.',
                'redirect' => '/'
            ]);
        }

        return redirect('/')->with('success', 'Đăng ký thành công! Vui lòng kiểm tra email để xác thực tài khoản.');
    }
}

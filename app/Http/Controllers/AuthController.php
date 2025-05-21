<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    public function showLogin()
    {
        // Redirect if user is already logged in
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($role === 'content') {
                return redirect()->route('admin.makes.index');
            } elseif ($role === 'saler') {
                return redirect()->route('admin.invoices.index');
            } else {
                // Regular users will be redirected to purchase history page
                return redirect()->route('user.purchases');
            }
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Check if input is an email or username
        $loginField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = [
            $loginField => $request->username,
            'password' => $request->password
        ];

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            $role = Auth::user()->role;

            // Log the login activity
            \App\Services\ActivityLogService::log(
                'login',
                'auth',
                Auth::id(),
                ['role' => $role]
            );

            // Redirect based on role
            if ($role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Login successful!');
            } elseif ($role === 'content') {
                // Content staff will be redirected to makes management instead of blog
                return redirect()->route('admin.makes.index')->with('success', 'Login successful!');
            } elseif ($role === 'saler') {
                // Sales staff will be redirected to invoice management
                return redirect()->route('admin.invoices.index')->with('success', 'Login successful!');
            } else {
                // Regular users will be redirected to purchase history page
                return redirect()->route('user.purchases')->with('success', 'Login successful!');
            }
        }

        return back()->withErrors([
            'username' => 'Invalid login credentials.',
        ])->withInput($request->except('password'));
    }

    public function showRegister()
    {
        // Check if this would be the first user
        $isFirstUser = DB::table('users')->count() === 0;

        return view('auth.register', compact('isFirstUser'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users,username|min:3|max:50',
            'fullname' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|unique:users,phone|min:10|max:15',
            'address' => 'required|string|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // at least one lowercase letter
                'regex:/[A-Z]/',      // at least one uppercase letter
                'regex:/[0-9]/',      // at least one number
                'regex:/[^A-Za-z0-9]/'// at least one special character
            ],
        ], [
            'username.required' => 'Please enter a username',
            'username.unique' => 'Username already exists',
            'email.unique' => 'Email already in use',
            'phone.unique' => 'Phone number already in use',
            'password.confirmed' => 'Password confirmation does not match',
            'password.min' => 'Password must be at least 8 characters',
            'password.regex' => 'Password must include uppercase and lowercase letters, numbers and special characters',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except('password', 'password_confirmation'));
        }

        // Check if this is the first user
        $isFirstUser = DB::table('users')->count() === 0;

        // Set role based on whether this is the first user
        $role = $isFirstUser ? 'admin' : 'user';

        $user = User::create([
            'username' => $request->username,
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => $role,
            'is_active' => true,
        ]);

        Auth::login($user);

        // Send email verification notification
        $user->sendEmailVerificationNotification();

        if ($isFirstUser) {
            // Set special session flag for first admin
            session(['first_admin' => true]);
            return redirect('/')->with('success', 'Welcome! You are the first user to register and have been assigned as the administrator. Please verify your email address.');
        }

        return redirect('/email/verify')->with('success', 'Registration successful! Please verify your email address.');
    }

    public function logout(Request $request)
    {
        // Log the logout activity
        if (Auth::check()) {
            \App\Services\ActivityLogService::log(
                'logout',
                'auth',
                Auth::id(),
                ['role' => Auth::user()->role]
            );
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logout successful!');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function showResetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => [
                'required',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // at least one lowercase letter
                'regex:/[A-Z]/',      // at least one uppercase letter
                'regex:/[0-9]/',      // at least one number
                'regex:/[^A-Za-z0-9]/'// at least one special character
            ],
        ], [
            'password.min' => 'Password must be at least 8 characters',
            'password.confirmed' => 'Password confirmation does not match',
            'password.regex' => 'Password must include uppercase and lowercase letters, numbers and special characters',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect('/admin')->with('status', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\ResetsUserPasswords;

class UserController extends Controller
{
    public function showSignupForm()
    {
        return view('users.signup');
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'frist_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agree' => ['required', 'accepted'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Use Fortify's CreateNewUser action
        $creator = app(CreatesNewUsers::class);
        $user = $creator->create([
            'name' => $request->frist_name, // Note: typo in view, but using as is
            'email' => $request->email,
            'password' => $request->password,
            'password_confirmation' => $request->password,
            'terms' => $request->agree,
        ]);

        // Log the user in after registration
        Auth::login($user);

        return redirect('/')->with('status', 'Registration successful!');
    }

    public function showResetPasswordForm(Request $request, $token = null)
    {
        return view('users.reset-password')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'confirm-password' => 'required|same:password',
        ]);

        $status = Password::reset(
            array_merge($request->only('email', 'password', 'token'), [
                'password_confirmation' => $request->input('confirm-password')
            ]),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();

                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect('/')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}

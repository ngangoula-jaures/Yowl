<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function showVerifyEmail() {
        return Inertia::render("Auth/EmailVerify");
    }

    public function verifyEmailStepOne(Request $request) {
        $request->validate([
            "email" => ["required", "email", "unique:users,email"],
        ]);

        $token = rand(100000, 999999);

        DB::table('tmp_users')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now(), 'updated_at' => now()]
        );

        Session::put('pending_email', $request->email);

        Mail::raw("Votre code de vérification Yowl : $token", function($message) use ($request) {
            $message->to($request->email)->subject("Vérification de votre compte Yowl");
        });

        return Inertia::location(route('verify.code'));
    }

    public function showVerifyCode() {
        return Inertia::render("Auth/VerifyCode");
    }

    public function verifyCode(Request $request) {
        $request->validate([
            "code" => ["required", "digits:6"],
        ]);

        $email = Session::get('pending_email');
        $tmp = DB::table('tmp_users')->where('email', $email)->first();

        if (!$tmp || $tmp->token != $request->code) {
            return back()->withErrors(["code" => "Code invalide ou expiré."]);
        }

        DB::table('tmp_users')->where('email', $email)->delete();

        return Inertia::location(route('register'));
    }

    public function showRegister() {
        return Inertia::render("Auth/Register", [
            'email' => Session::get('pending_email')
        ]);
    }

    public function register(Request $request) {
        $request->validate([
            "pseudo" => ["required", "string", "max:255", "unique:users,pseudo"],
            "age" => ["required", "integer", "min:13", "max:35"],
            "email" => ["required", "email", "unique:users"],
            "password" => ["required", "min:8", "confirmed"],
        ]);

        $user = User::create([
            "pseudo" => $request->pseudo,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);

        Session::forget('pending_email');
        Auth::login($user);

        return Inertia::location(route('Post.index'));
    }

    public function showLogin() {
        return Inertia::render("Auth/Login");
    }

    public function authenticate(Request $request) {
        $credentials = $request->validate([
            "email" => ["required", "email"],
            "password" => ["required"]
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $defaultRoute = route("Post.index");
            $intended_route = redirect()->intended($defaultRoute)->getTargetUrl();
            return Inertia::location($intended_route);
        }

        return back()->withErrors([
            "email" => "Paramètres d'authentification incorrects."
        ]);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Inertia::location("/login");
    }
}
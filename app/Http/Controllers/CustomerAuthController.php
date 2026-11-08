<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Socialite;
use Illuminate\Support\Str;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::guard('customer')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function redirectToGoogle()
    {
        if (! $this->googleIsConfigured()) {
            return redirect()->route('customer.login')
                ->withErrors(['google' => 'Google sign-in is not configured. Please try again later.']);
        }

        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        if (! $this->googleIsConfigured()) {
            return redirect()->route('customer.login')
                ->withErrors(['google' => 'Google sign-in is not configured. Please try again later.']);
        }

        if ($request->filled('error') || ! $request->filled('code')) {
            return redirect()->route('customer.login')
                ->withErrors(['google' => 'Google sign-in was cancelled or could not be completed.']);
        }

        $googleUser = Socialite::driver('google')->user();
        $email = strtolower(trim((string) $googleUser->getEmail()));

        if (! filter_var($email, FILTER_VALIDATE_EMAIL)
            || ! filter_var(data_get($googleUser->user, 'verified_email'), FILTER_VALIDATE_BOOLEAN)) {
            return redirect()->route('customer.login')
                ->withErrors(['google' => 'Google must provide a verified email address to sign in.']);
        }

        $customer = Customer::query()->where('email', $email)->first();

        if (! $customer) {
            $customer = Customer::create([
                'name' => $googleUser->getName() ?: Str::before($email, '@'),
                'email' => $email,
                'email_verified_at' => now(),
                'password' => Str::random(40),
            ]);
        }

        Auth::guard('customer')->login($customer);
        $request->session()->regenerate();

        return redirect()->intended(route('customer.dashboard'));
    }

    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('customer.login');
    }

    private function googleIsConfigured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'))
            && filled(config('services.google.redirect'));
    }
}
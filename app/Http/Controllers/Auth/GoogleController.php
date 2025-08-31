<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirect to Google OAuth
     */
    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function callback(): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user already exists with this Google ID
            $existingUser = User::where('google_id', $googleUser->id)->first();

            if ($existingUser) {
                // Update avatar and tokens
                $existingUser->update([
                    'avatar' => $googleUser->avatar,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken ?? null,
                ]);

                Auth::login($existingUser);

                return redirect()->intended('/dashboard');
            }

            // Check if user exists with same email
            $userWithEmail = User::where('email', $googleUser->email)->first();

            if ($userWithEmail) {
                // Link Google account to existing user
                $userWithEmail->update([
                    'google_id' => $googleUser->id,
                    'avatar' => $googleUser->avatar,
                    'google_token' => $googleUser->token,
                    'google_refresh_token' => $googleUser->refreshToken ?? null,
                ]);

                Auth::login($userWithEmail);

                return redirect()->intended('/dashboard');
            }

            // Create new user
            $user = User::create([
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_id' => $googleUser->id,
                'avatar' => $googleUser->avatar,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken ?? null,
                'email_verified_at' => now(),
                'provider' => 'google',
                'provider_id' => $googleUser->id,
                'password' => bcrypt(Str::random(16)), // Random password for security
            ]);

            // Create profile for the user
            $user->profile()->create([
                'bio' => null,
                'location' => null,
                'avatar_url' => $googleUser->avatar,
            ]);

            Auth::login($user);

            return redirect()->intended('/dashboard');

        } catch (\Exception $e) {
            return redirect('/login')->withErrors(['error' => 'Authentication failed. Please try again.']);
        }
    }
}

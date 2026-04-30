<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUser;

class GoogleAuthService
{
    public function handleCallback(SocialiteUser $googleUser, Request $request): RedirectResponse
    {
        $existed = User::where('email', $googleUser->getEmail())->exists();

        $user = User::updateOrCreate(
            [
                'email'  => $googleUser->getEmail(),
                'origin' => $request->session()->get('oauth_origin', 'mentoria'),
            ],
            [
                'name'                    => $googleUser->getName(),
                'google_id'               => $googleUser->getId(),
                'avatar'                  => $googleUser->getAvatar(),
                'google_access_token'     => $googleUser->token,
                'google_refresh_token'    => $googleUser->refreshToken,
                'google_token_expires_at' => now()->addSeconds($googleUser->expiresIn),
            ]
        );

        if ($googleUser->getAvatar()) {
            $this->storeAvatar($user, $googleUser->getAvatar());
        }

        Auth::login($user);

        return $existed
            ? redirect()->route('dashboard')
            : redirect()->route('linkedin.redirect.view');
    }

    protected function storeAvatar(User $user, string $url): void
    {
        try {
            $contents = @file_get_contents($url);
            if ($contents === false) {
                return;
            }

            $filename = 'google_' . Str::random(10) . '.jpg';
            Storage::disk('public')->put('avatars/' . $filename, $contents);

            $user->avatar = $filename;
            $user->save();
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
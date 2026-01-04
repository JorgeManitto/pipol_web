<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class LinkedInController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('linkedin-openid')->redirect();
        // return Socialite::driver('linkedin-openid')->redirect();

    }

    public function callback()
    {
        $linkedinUser = Socialite::driver('linkedin-openid')->stateless()->user();
        $avatarPath = null;

        if ($linkedinUser->getAvatar()) {
            $contents = Http::get($linkedinUser->getAvatar())->body();
            $filename =  uniqid() . '.jpg';

            Storage::disk('public')->put('avatars/' .$filename, $contents);
            $avatarPath = $filename;
        }
        $isUserExist = User::where('email', $linkedinUser->getEmail())->first();
        $user = User::updateOrCreate(
            ['email' => $linkedinUser->getEmail()],
            [
                'name' => $linkedinUser->getName(),
                'linkedin_id' => $linkedinUser->getId(),
                'avatar' => $avatarPath,
                'password' => bcrypt(str()->random(24)),
                'active' => false,
            ]
        );

        Auth::login($user);

        if ($isUserExist) {
            return redirect()->route('dashboard');
        }
        else{
            return redirect()->route('linkedin.redirect.view');
        }
    }

    function redirectToLinkedinView()
    {
        return view('backend.admin.auth.linkedin-redirect');
    }
    function setUserAsMentor() {
        $user = Auth::user();
        $user->is_mentor = true;
        $user->save();

        return redirect()->route('dashboard');
    }
}

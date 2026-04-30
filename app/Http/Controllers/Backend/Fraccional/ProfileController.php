<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('backend.fraccional.profile.edit', [
            'user' => auth()->user()->load('skills'),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'                    => 'required|string|max:100',
            'last_name'               => 'nullable|string|max:100',
            'profession'              => 'nullable|string|max:150',
            'currentPosition'         => 'nullable|string|max:150',
            'bio'                     => 'nullable|string|max:2000',
            'bio_laboral'             => 'nullable|string|max:2000',
            'linkedin_url'            => 'nullable|url|max:255',
            'website'                 => 'nullable|url|max:255',
            'country'                 => 'nullable|string|max:100',
            'city'                    => 'nullable|string|max:100',
            'years_of_experience'     => 'nullable|integer|min:0|max:70',
            'seniority'               => 'nullable|in:junior,semi-senior,senior',
            'hourly_rate'             => 'nullable|numeric|min:0',
            'currency'                => 'nullable|string|size:3',
            'weekly_hours_available'  => 'nullable|integer|min:0|max:80',
            'workingNow'              => 'nullable|boolean',
            'languages'               => 'nullable|string|max:255',
            'sectors'                 => 'nullable|string|max:500',
        ]);

        $data['workingNow'] = $request->boolean('workingNow');

        $user->update($data);

        return back()->with('success', 'Perfil actualizado correctamente.');
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $user = auth()->user();

        if ($user->avatar && Storage::disk('public')->exists('avatars/'.$user->avatar)) {
            Storage::disk('public')->delete('avatars/'.$user->avatar);
        }

        $filename = uniqid('avatar_') . '.' . $request->file('avatar')->getClientOriginalExtension();
        $request->file('avatar')->storeAs('avatars', $filename, 'public');

        $user->update(['avatar' => $filename]);

        return back()->with('success', 'Foto actualizada.');
    }
}
<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Skills;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Mostrar el perfil público de un usuario (mentor o mentee)
     */
    public function show($id)
    {

        $user = User::with('skills')->findOrFail($id);
        // dd($user);
        if(!$user->is_mentor){
            return view('backend.profiles.show-not-mentor', compact('user'));
        }
        return view('backend.profiles.show', compact('user'));
    }

    /**
     * Mostrar formulario de edición del perfil propio
     */
    public function edit()
    {
        $user = Auth::user();
        $skills = Skills::orderBy('name')->get();

        if($user->is_mentor){
            return view('backend.profiles.edit', compact('user', 'skills'));
        }else{
            return view('backend.profiles.edit-not-mentor', compact('user'));
        }
    }

    /**
     * Actualizar los datos del perfil
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'last_name'      => 'nullable|string|max:255',
            'email'          => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'bio'            => 'nullable|string|max:2000',
            'country'        => 'nullable|string|max:100',
            'city'           => 'nullable|string|max:100',
            'profession'     => 'nullable|string|max:255',
            'linkedin_url'   => 'nullable|url|max:255',
            'website'        => 'nullable|url|max:255',
            'hourly_rate'    => 'nullable|numeric|min:0',
            'currency'       => 'nullable|string|size:3',
            'avatar'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'skills'         => 'array',
            'skills.*'       => 'integer|exists:skills,id',
            'paypal_email'  => 'nullable|email|max:255',
            'is_mentor'     => 'nullable|boolean',
            'bio_laboral'   => 'nullable|string|max:2000',
        ]);

        // Subir avatar
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = basename($path);
        }

        // Actualizar datos
        $user->update($validated);

        // Actualizar skills si es mentor
        if ($user->is_mentor && $request->has('skills')) {
            // dd($request->skills);
            $user->skills()->sync($request->skills);
        }

        return redirect()
            ->route('profile.edit')
            ->with('success', 'Perfil actualizado correctamente.');
    }

    /**
     * Eliminar avatar actual
     */
    public function deleteAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
            $user->avatar = null;
            $user->save();
        }

        return back()->with('success', 'Avatar eliminado.');
    }
}

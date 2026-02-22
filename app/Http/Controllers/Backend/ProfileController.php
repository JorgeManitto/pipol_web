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
     * Mostrar el perfil público de un usuario
     */
    public function show($id)
    {
        $user = User::with('skills')->findOrFail($id);
        $mentor = User::where('id', $id)->first();
        $ratingReviews = ($mentor->reviewsReceived()->avg('rating')) ? round($mentor->reviewsReceived()->avg('rating'), 2) : 0;
        $totalReviews = $mentor->reviewsReceived()->count();
        $totalSessions = $mentor->sessionsAsMentor()->where('status', 'completed')->count();
        
        return view('backend.profiles.show', compact('user', 'ratingReviews', 'totalReviews', 'totalSessions'));
    }

    /**
     * Mostrar formulario de edición del perfil propio
     */
    public function edit()
    {
        $user = Auth::user();
        $skills = Skills::orderBy('name')->get();

        if ($user->is_mentor) {
            return view('backend.profiles.edit', compact('user', 'skills'));
        } else {
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
            // Información Básica
            'name'           => 'required|string|max:255',
            'last_name'      => 'nullable|string|max:255',
            'email'          => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'birth_date'     => 'nullable|date|before:today',
            'gender'         => 'nullable|in:Masculino,Femenino,Otro,Prefiero no decir',
            'country'        => 'required|string|max:100',
            'city'           => 'nullable|string|max:100',
            'profession'     => 'nullable|string|max:255',
            
            // Perfil Profesional (bio_laboral REMOVIDO)
            'bio'            => 'nullable|string|max:2000',
            'years_of_experience' => 'nullable|integer|min:0|max:50',
            'seniority'      => 'nullable|in:Trainee,Junior,Semi-Senior,Senior,Jefe,Director',
            'skills'         => 'nullable|string|max:1000',
            
            // Experiencia Laboral
            'workingNow'     => 'nullable|boolean',
            'currentPosition' => 'nullable|string|max:255',
            'lastPosition'   => 'nullable|string|max:255',
            'companies'      => 'nullable|string|max:500',
            'sectors'        => 'nullable|string|max:500',
            
            // Formación
            'education'      => 'nullable|string|max:1000',
            'languages'      => 'nullable|string|max:500',
            
            // Tarifas y Pagos
            'hourly_rate'    => 'nullable|numeric|min:0|max:9999.99',
            'currency'       => 'nullable|string|size:3',
            'paypal_email'   => 'nullable|email|max:255',
            
            // Enlaces
            'linkedin_url'   => 'nullable|url|max:255',
            'website'        => 'nullable|url|max:255',
            
            // Imágenes
            'avatar'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'selfie'         => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'documentPhoto'  => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            
            // Otros
            'is_mentor'      => 'nullable|boolean',
        ]);

    // Procesar Avatar (público)
    if ($request->hasFile('avatar')) {
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }
        $path = $request->file('avatar')->store('avatars', 'public');
        $validated['avatar'] = basename($path);
    }

    // Procesar Selfie (privado - sin 'public')
    if ($request->hasFile('selfie')) {
        if ($user->selfie && Storage::exists($user->selfie)) {
            Storage::delete($user->selfie);
        }
        $path = $request->file('selfie')->store('selfies');
        $validated['selfie'] = $path;
    }

    // Procesar Documento (privado - sin 'public')
    if ($request->hasFile('documentPhoto')) {
        if ($user->documentPhoto && Storage::exists($user->documentPhoto)) {
            Storage::delete($user->documentPhoto);
        }
        $path = $request->file('documentPhoto')->store('documents');
        $validated['documentPhoto'] = $path;
    }

    $user->update($validated);

    return redirect()
        ->route('profile.edit')
        ->with('success', '✓ Perfil actualizado correctamente.');
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

        return back()->with('success', 'Avatar eliminado correctamente.');
    }
}
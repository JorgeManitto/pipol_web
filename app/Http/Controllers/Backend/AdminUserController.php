<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Muestra la lista de usuarios
    public function index()
    {
        $users = User::paginate(20);
        return view('backend.admin.users.index', compact('users'));
    }

    // Muestra un usuario específico
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('backend.admin.users.show', compact('user'));
    }

    // Muestra el formulario de edición
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.admin.users.edit', compact('user'));
    }

    // Actualiza los datos del usuario
    public function update(Request $request, User $user)
    {
        // VALIDACIÓN
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',

            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'gender' => 'nullable|string|max:20',
            'profession' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'bio_laboral' => 'nullable|string',

            'linkedin_url' => 'nullable|url',
            'website' => 'nullable|url',

            'hourly_rate' => 'nullable|numeric',
            'currency' => 'nullable|string|max:10',
            'paypal_email' => 'nullable|email',
            'stripe_connect_id' => 'nullable|string|max:255',

            'is_mentor' => 'nullable|boolean',
            'role' => 'nullable|string|max:50',
            'active' => 'nullable|boolean',
            'session_complete' => 'nullable|boolean',
            'average_rating' => 'nullable|numeric',
            'years_of_experience' => 'nullable|integer|min:0',

            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // MANEJO DE CONTRASEÑA (solo si se envía)
        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
                Storage::delete('public/avatars/' . $user->avatar);
            }

            $path = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = basename($path);
        }

        // ACTUALIZAR USUARIO
        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Usuario actualizado correctamente.');
    }


    // Elimina un usuario
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuario eliminado');
    }

    function testMeet() {
        $meet = app(\App\Services\GoogleMeetService::class)
        ->createMeet(
            'Reunión con cliente',
            now()->addHour(),
            now()->addHours(2)
        );

    return $meet;

    }
}

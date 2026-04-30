<?php
namespace App\Http\Controllers\Backend\Fraccional;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};

class AuthController extends Controller
{
    public function show(Request $request)
    {
        $tab  = $request->query('tab', 'login');
        $type = $request->query('type', 'company');
        return view('backend.fraccional.auth.index', compact('tab', 'type'));
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
            'remember' => 'sometimes|boolean',
        ]);

        if (!Auth::attempt(
            ['email' => $data['email'], 'password' => $data['password']],
            $request->boolean('remember')
        )) {
            return response()->json([
                'message' => 'Credenciales incorrectas.',
                'errors'  => ['email' => ['Credenciales incorrectas.']],
            ], 422);
        }

        $user = Auth::user();

        return response()->json([
            'message'  => 'Sesión iniciada.',
            'redirect' => $this->redirectFor($user),
        ]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'                  => 'required|string|min:3|max:100',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|string|min:8|confirmed',
            'type'                  => 'required|in:company,professional',
            'terms'                 => 'accepted',
        ]);

        $role = $data['type'] === 'professional'
            ? User::ROLE_FRACCIONAL_PROFESSIONAL
            : User::ROLE_FRACCIONAL_COMPANY;

        $user = User::create([
            'name'      => $data['name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => $role,
            'is_mentor' => false,
            'active'    => true,
        ]);

        Auth::login($user);
        $user->sendEmailVerificationNotification();

        return response()->json([
            'message'  => 'Cuenta creada.',
            'redirect' => $this->redirectFor($user),
        ]);
    }

    protected function redirectFor(User $user): string
    {
        if ($user->isFraccionalProfessional()) {
            return route('fraccional.profile.edit');
        }
        if ($user->isFraccionalCompany()) {
            return route('home.nuevoDiagnostico');
        }
        // Usuarios de mentoría que entren por acá: van a su flujo
        return route('dashboard');
    }
    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('fraccional.auth.show');
    }
}
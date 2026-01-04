<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthTabs extends Component
{
    public string $activeTab = 'login';

    // Campos de login
    public string $loginEmail = '';
    public string $loginPassword = '';
    public bool $remember = false;

    // Campos de registro
    public string $registerName = '';
    public string $registerEmail = '';
    public string $registerPassword = '';
    public string $registerConfirmPassword = '';

    public $is_mentor = false;

    protected $queryString = ['is_mentor'];

    public function mount()
    {
        if ($this->is_mentor) {
            $this->activeTab = 'register';
        }
    }

    public function showLogin()
    {
        $this->activeTab = 'login';
    }

    public function showRegister()
    {
        $this->activeTab = 'register';
    }

    public function login()
    {
        $this->validate([
            'loginEmail' => 'required|email',
            'loginPassword' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $this->loginEmail, 'password' => $this->loginPassword], $this->remember)) {
            return redirect()->route('dashboard');
        }

        $this->addError('loginEmail', 'Credenciales incorrectas.');
    }

    public function register()
    {
        
        $this->validate([
            'registerName' => 'required|min:3',
            'registerEmail' => 'required|email|unique:users,email',
            'registerPassword' => 'required|min:8|same:registerConfirmPassword',
            'is_mentor' => 'boolean',
        ]);

        $user = User::create([
            'name' => $this->registerName,
            'email' => $this->registerEmail,
            'password' => Hash::make($this->registerPassword),
            'is_mentor' => $this->is_mentor,
            'active' => true,
        ]);

        Auth::login($user);

        return redirect()->route('profile.show', ['id' => $user->id]);
        // if ($this->is_mentor) {
        //     return redirect()->route('profile.show', ['id' => $user->id]);
        // }else{
        //     return redirect()->route('dashboard');
        // }
    }

    public function render(Request $request)
    {

        return view('livewire.auth-tabs');
    }
}

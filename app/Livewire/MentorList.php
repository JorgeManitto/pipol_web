<?php

namespace App\Livewire;

use App\Models\Pipol_sessions;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Livewire\Component;

class MentorList extends Component
{
public $mentors;
    public $selectedMentor;
    public $selectedDate;
    public $selectedTime;
    public $showModal = false;
    public $availableTimes = [];

    protected $rules = [
        'selectedDate' => 'required|date|after:today',
        'selectedTime' => 'required',
    ];

    public function mount()
    {
        $this->mentors = User::where('is_mentor', true)->with('skills')->get();
    }

      public function openModal($mentorId)
    {
        $this->selectedMentor = User::with('skills')->find($mentorId);
        $this->selectedDate = null;
        $this->selectedTime = null;
        $this->showModal = true;

        // Emitimos evento JS para abrir el modal y renderizar calendario
        // $this->dispatchBrowserEvent('open-modal', [
        //     'mentor' => [
        //         'name' => $this->selectedMentor->name . ' ' . $this->selectedMentor->last_name,
        //         'profession' => $this->selectedMentor->profession,
        //         'avatar' => $this->selectedMentor->avatar
        //             ? asset('storage/avatars/'.$this->selectedMentor->avatar)
        //             : asset('images/default-avatar.png'),
        //         'price' => "{$this->selectedMentor->currency} {$this->selectedMentor->hourly_rate}"
        //     ]
        // ]);
        // dd($this->selectedMentor);
        $this->dispatch('open-modal', [
    'mentor' => [
        'name' => $this->selectedMentor->name . ' ' . $this->selectedMentor->last_name,
        'profession' => $this->selectedMentor->profession,
        'avatar' => $this->selectedMentor->avatar
            ? asset('storage/avatars/'.$this->selectedMentor->avatar)
            : asset('images/default-avatar.png'),
        'price' => "{$this->selectedMentor->currency} {$this->selectedMentor->hourly_rate}"
    ]
]);

    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->dispatch('close-modal');
    }

    public function setDate($date)
    {
        $this->selectedDate = $date;
    }

    public function setTime($time)
    {
        $this->selectedTime = $time;
    }

    public function createReservation()
    {
        $this->validate();

        if (!Auth::check()) {
            session()->flash('error', 'Debes iniciar sesión para reservar una sesión.');
            return redirect()->route('login');
        }

        Pipol_sessions::create([
            'mentor_id' => $this->selectedMentor->id,
            'mentee_id' => Auth::id(),
            'scheduled_at' => Carbon::parse("{$this->selectedDate} {$this->selectedTime}"),
            'duration_minutes' => 60,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'price' => $this->selectedMentor->hourly_rate,
            'currency' => $this->selectedMentor->currency,
        ]);

        $this->closeModal();
        session()->flash('success', '¡Reserva creada correctamente! Recibirás la confirmación por email.');
    }

    public function render()
    {
        return view('livewire.mentor-list');
    }
}

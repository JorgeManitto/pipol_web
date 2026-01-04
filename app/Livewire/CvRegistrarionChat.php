<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;

class CvRegistrarionChat extends Component
{
    use WithFileUploads;
    public $step = 1;
    public $seniority = 'jefe';
    public $confirmSeniority = '';
    public $sessionPrices = [];
    public $selectedPrice = '';
    public $selfie;
    public $documentPhoto;
    public $loading = false;
    public $buttonDisabled = false;

    public $stepHistory = [];
    public $messages = [];


    public function mount()
    {
        // dd(auth()->user());
        $this->seniority = auth()->user()->seniority ?? 'jefe';
        $this->addBotMessage('Continuemos con tu registro. ¿Cuál es tu nivel de seniority?');
    }

    private function addBotMessage($message)
    {
        $this->messages[] = ['type' => 'bot', 'content' => $message];
    }

    public function showError(){
        $this->addBotMessage('Hubo un error con tu respuesta. Por favor, intenta nuevamente.');
    }

    public function submitResponse()
    {
        $this->loading = true;
        $this->buttonDisabled = true;

        $this->stepHistory[] = $this->step;

        // Lógica para manejar las respuestas según el paso actual
        switch ($this->step) {
            case 1:
                $this->validate(['seniority' => 'required'], 
                [
                    'seniority.required' => 'Por favor, selecciona tu nivel de seniority.'
                ]);
                
                $this->confirmSeniority = $this->seniority;
                $this->addBotMessage("Has seleccionado '$this->confirmSeniority' como tu nivel de seniority.");
                $this->step++;
                
                $this->sessionPrices = [50, 75, 100];
                $this->addBotMessage('Con base en tu perfil, te proponemos estas opciones para el valor de tu hora. (Recuerda que puedes modificar este valor cuando lo desees.)');
                $this->dispatchScrollEvent();
                break;
            case 2:
                $this->validate(['selectedPrice' => 'required'], 
                [
                    'selectedPrice.required' => 'Por favor, selecciona un valor para tu hora de mentoría.'
                ]);
                
                $this->addBotMessage("Has seleccionado $$this->selectedPrice como el valor de tu hora.");
                $this->step++;
                $this->addBotMessage('Por favor, sube una selfie reciente.');
                $this->dispatchScrollEvent();
                break;
            case 3:
                $this->validate(['selfie' => 'required|image|max:2048', 'documentPhoto' => 'required|image|max:2048'], 
                [
                    'selfie.required' => 'Por favor, sube una selfie reciente.',
                    'selfie.image' => 'El archivo debe ser una imagen válida.',
                    'selfie.max' => 'La imagen no debe superar los 2MB.',
                    'documentPhoto.required' => 'Por favor, sube una foto de tu documento de identidad.',
                    'documentPhoto.image' => 'El archivo debe ser una imagen válida.',
                    'documentPhoto.max' => 'La imagen no debe superar los 2MB.',
                ]);
                  
                $this->addBotMessage('Selfie y foto de documento recibidos correctamente. ¡Gracias por completar tu registro!');
                $this->addBotMessage('Tu perfil está casi listo. Nos pondremos en contacto contigo pronto.');
                 // Aquí podrías guardar las imágenes o procesarlas según sea necesario
                $this->step++;
                $this->dispatchScrollEvent();
                $this->guardarInfo();
                break;
           

            default:
                break;
        }

        $this->loading = false;
        $this->buttonDisabled = false;
    }

    public function render()
    {
        return view('livewire.cv-registrarion-chat');
    }

        public function goBack()
    {
        if (count($this->stepHistory) === 0) {
            return;
        }

        // Volver al paso anterior
        $this->step = array_pop($this->stepHistory);

        // Eliminar último mensaje del usuario
        for ($i = count($this->messages) - 1; $i >= 0; $i--) {
            if ($this->messages[$i]['type'] === 'user') {
                array_splice($this->messages, $i, 1);
                break;
            }
        }

        // Limpiar errores de validación
        $this->resetErrorBag();

        // Mensaje de feedback
        $this->addBotMessage('Perfecto, volvamos un paso atrás 🙂');

        // 👉 Repetir la pregunta del step actual
        $question = $this->getStepQuestion($this->step);
        if ($question) {
            $this->addBotMessage($question);
        }

        $this->dispatchScrollEvent();

    }
    public function getStepQuestion() {
        
        return match ($this->step) {
            1 => 'Continuemos con tu registro. ¿Cuál es tu nivel de seniority?',
            2 => 'Con base en tu perfil, te proponemos estas opciones para el valor de tu hora. (Recuerda que puedes modificar este valor cuando lo desees.)',
            3 => 'Por favor, sube una selfie reciente.',
            4 => 'Ahora, por favor sube una foto de tu documento de identidad.',
            default => null,
        };
    }
    public function dispatchScrollEvent()
    {
        // $this->dispatchBrowserEvent('scrollToBottom');
        $this->dispatch('scrollToBottom', param1: 'hola');
    }

    public function guardarInfo(){
        $user = User::find(auth()->user()->id);

        $user->seniority = $this->seniority;

        $user->hourly_rate = str_replace('$', '', $this->selectedPrice);
        $user->is_register_end = true;

        if($this->selfie){
            $selfiePath = $this->selfie->store('selfies', 'private');
            $user->selfie = $selfiePath;
        }
        if($this->documentPhoto){
            $documentPath = $this->documentPhoto->store('documents', 'private');
            $user->documentPhoto = $documentPath;
        }

        $user->save();
    }
}

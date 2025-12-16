<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class MentorRegistrationChat extends Component
{
    use WithFileUploads;

    public $step = 1;
    public $loadMethod = '';
    public $name = '';
    public $birthDate = '';
    public $country = '';
    public $city = '';
    public $workingNow = '';
    public $currentPosition = '';
    public $lastPosition = '';
    public $yearsExperience = '';
    public $addCompanies = '';
    public $companies = '';
    public $sectors = '';
    public $hasEducation = '';
    public $education = '';
    public $languages = '';
    public $skills = '';
    public $bio = '';
    public $availability = '';
    public $seniority = 'Gerente';
    public $confirmSeniority = '';
    public $sessionPrices = [];
    public $selectedPrice = '';
    public $selfie;
    public $documentPhoto;

    public $messages = [];
    public $loading = false;

    public function mount()
    {
        $this->addBotMessage('¿Cómo quieres cargar tu perfil?');
    }

    private function addBotMessage($message)
    {
        $this->messages[] = ['type' => 'bot', 'content' => $message];
    }

    public function showError(){
        $this->addBotMessage('Hubo un error con tu respuesta. Por favor, intenta nuevamente.');
    }
    private function getUserResponseContent()
    {
        return match ($this->step) {
            1 => $this->loadMethod === 'cv' ? 'Cargar CV / LinkedIn' : 'Cargar datos manualmente',
            2 => trim("{$this->name}\n{$this->birthDate}\n{$this->country}\n{$this->city}"),
            3 => $this->workingNow === 'yes' ? 'Sí' : 'No',
            4 => $this->workingNow === 'yes' ? $this->currentPosition : $this->lastPosition,
            5 => $this->yearsExperience,
            6 => $this->addCompanies === 'yes' ? 'Sí' : 'No',
            7 => $this->companies,
            8 => $this->sectors,
            9 => $this->hasEducation === 'yes' ? 'Sí' : 'No',
            10 => $this->education,
            11 => $this->languages,
            12 => $this->skills,
            13 => $this->bio,
            14 => $this->availability,
            15 => $this->confirmSeniority === 'yes' ? 'Sí' : 'No',
            16 => $this->seniority,
            17 => '$' . $this->selectedPrice,
            18 => 'Selfie y documento cargados',
            default => 'Respuesta enviada',
        };
    }
    public function submitResponse()
    {
        // $this->loading = true;
        $userMessage = $this->getUserResponseContent();
        if ($userMessage) {
            $this->messages[] = [
                'type' => 'user',
                'content' => $userMessage
            ];
        }
        switch ($this->step) {
            case 1:
                if ($this->loadMethod === 'manual') {
                    $this->addBotMessage('¡Gracias! Ahora vamos a construir tu perfil profesional.');
                    $this->step = 2;
                    $this->addBotMessage('Para comenzar, necesitamos algunos datos básicos: Nombre y apellido, Fecha de nacimiento, País y ciudad de residencia.');
                } else {
                    // Maneja CV/LinkedIn si lo implementas
                    $this->addBotMessage('Cargando desde CV/LinkedIn... (falta implementar lógica acá)');
                }
                break;
            case 2:
                $validated = $this->validate(['name' => 'required', 'birthDate' => 'required|date', 'country' => 'required', 'city' => 'required'],
                [
                    'name.required' => 'Por favor, ingresa tu nombre y apellido.',
                    'birthDate.required' => 'Por favor, ingresa tu fecha de nacimiento.',
                    'birthDate.date' => 'La fecha de nacimiento debe ser una fecha válida.',
                    'country.required' => 'Por favor, ingresa tu país de residencia.',
                    'city.required' => 'Por favor, ingresa tu ciudad de residencia.'
                ]);
                
                $this->addBotMessage('¡Gracias! Ahora vamos a construir tu perfil profesional.');
                $this->step = 3;
                $this->addBotMessage('¿Trabajas actualmente?');
                break;
            case 3:
                $this->validate(['workingNow' => 'required|in:yes,no'],
                [
                    'workingNow.required' => 'Por favor, indica si estás trabajando actualmente.',
                    'workingNow.in' => 'La respuesta debe ser "yes" o "no".'
                ]
            );
                $this->step = 4;
                if ($this->workingNow === 'yes') {
                    $this->addBotMessage('¿Cuál es tu cargo actual?');
                } else {
                    $this->addBotMessage('¿Cuál fue tu último cargo?');
                }
                break;
            case 4:
                if ($this->workingNow === 'yes') {
                    $this->validate(['currentPosition' => 'required'],
                    [
                        'currentPosition.required' => 'Por favor, ingresa tu cargo actual.'
                    ]
                );
                } else {
                    $this->validate(['lastPosition' => 'required'],
                    [
                        'lastPosition.required' => 'Por favor, ingresa tu último cargo.'
                    ]);
                }
                $this->step = 5;
                $this->addBotMessage('Para entender mejor tu recorrido profesional: ¿Cuántos años de experiencia laboral tienes? (respuesta numérica o rangos sugeridos)');
                break;
            case 5:
                $this->validate(['yearsExperience' => 'required|numeric'],
                [
                    'yearsExperience.required' => 'Por favor, ingresa tus años de experiencia laboral.',
                    'yearsExperience.numeric' => 'Los años de experiencia deben ser un número válido.'
                ]);
                $this->step = 6;
                $this->addBotMessage('¿Quieres indicar las empresas donde trabajaste?');
                break;
            case 6:
                $this->validate(['addCompanies' => 'required|in:yes,no'], 
                [
                    'addCompanies.required' => 'Por favor, indica si deseas agregar las empresas donde trabajaste.',
                    'addCompanies.in' => 'La respuesta debe ser "yes" o "no".'
                ]);
                if ($this->addCompanies === 'yes') {
                    $this->step = 7;
                    $this->addBotMessage('Por favor, escríbelas separadas por coma.');
                } else {
                    $this->step = 8;
                    $this->addBotMessage('¿En qué rubros o industrias desarrollaste tu experiencia? (Campo de texto libre)');
                }
                break;
            case 7:
                $this->validate(['companies' => 'required'], 
                [
                    'companies.required' => 'Por favor, ingresa las empresas donde trabajaste.'
                ]);
                $this->step = 8;
                $this->addBotMessage('¿En qué rubros o industrias desarrollaste tu experiencia? (Campo de texto libre)');
                break;
            case 8:
                $this->sectors = $this->normalizeSectors($this->sectors);
                $this->addBotMessage('Perfecto. Continuemos.');
                $this->step = 9;
                $this->addBotMessage('¿Tienes estudios formales y/o certificaciones relevantes?');
                break;
            case 9:
                $this->validate(['hasEducation' => 'required|in:yes,no'], 
                [
                    'hasEducation.required' => 'Por favor, indica si tienes estudios formales y/o certificaciones relevantes.',
                    'hasEducation.in' => 'La respuesta debe ser "yes" o "no".'
                ]);
                if ($this->hasEducation === 'yes') {
                    $this->step = 10;
                    $this->addBotMessage('Escríbelos e indica dónde los realizaste.');
                } else {
                    $this->step = 11;
                    $this->addBotMessage('¿Qué idiomas hablas de manera fluida? (Campo libre + sugerencias automáticas)');
                }
                break;
            case 10:
                $this->validate(['education' => 'required'],
                [
                    'education.required' => 'Por favor, ingresa tus estudios formales y/o certificaciones relevantes.'
                ]);
                $this->step = 11;
                $this->addBotMessage('¿Qué idiomas hablas de manera fluida? (Campo libre + sugerencias automáticas)');
                break;
            case 11:
                $this->step = 12;
                $this->addBotMessage('Esta información es clave para que los mentees te encuentren. ¿Qué habilidades técnicas y/o competencias blandas puedes mentorear? (Escribe palabras o frases cortas. Ejemplo: liderazgo de equipos, toma de decisiones, gestión del talento)');
                break;
            case 12:
                $this->skills = $this->tagSkills($this->skills);
                $this->step = 13;
                $this->addBotMessage('Ahora vamos a crear tu bio profesional. Escríbenos tu bio directamente (puedes describirte como mentor).');
                break;
            case 13:
                $this->validate(['bio' => 'required|string|min:5'], 
                [
                    'bio.required' => 'Por favor, ingresa tu bio profesional.',
                    'bio.string' => 'La bio debe ser un texto válido.',
                    'bio.min' => 'La bio debe tener al menos 5 caracteres.'
                ]);
                $this->addBotMessage('Excelente. Una buena bio aumenta tus oportunidades de recibir solicitudes.');
                $this->step = 14;
                $this->addBotMessage('Vamos a configurar tu disponibilidad de agenda. Indica qué días y en qué franjas horarias estás disponible. (Respuesta libre o con chips sugeridos)');
                break;
            case 14:
                $this->step = 15;
                $this->addBotMessage('Según tu experiencia, detectamos un nivel de seniority ' . $this->seniority . '. ¿Es correcto?');
                // Sugiere precios (placeholder)
                $this->sessionPrices = [50, 75, 100];
                break;
            case 15:
                $this->validate(['confirmSeniority' => 'required|in:yes,no'], 
                [
                    'confirmSeniority.required' => 'Por favor, confirma si el seniority sugerido es correcto.',
                    'confirmSeniority.in' => 'La respuesta debe ser "yes" o "no".'
                ]);
                if ($this->confirmSeniority === 'yes') {
                    $this->step = 17;
                    $this->addBotMessage('Con base en tu perfil, te proponemos estas opciones para el valor de tu hora. (Recuerda que puedes modificar este valor cuando lo desees.)');
                } else {
                    $this->step = 16;
                    $this->addBotMessage('Selecciona tu seniority:');
                }
                break;
            case 16:
                $this->validate(['seniority' => 'required'], 
                [
                    'seniority.required' => 'Por favor, selecciona tu seniority.'
                ]);
                $this->step = 17;
                $this->addBotMessage('Con base en tu perfil, te proponemos estas opciones para el valor de tu hora. (Recuerda que puedes modificar este valor cuando lo desees.)');
                break;
            case 17:
                $this->validate(['selectedPrice' => 'required'], 
                [
                    'selectedPrice.required' => 'Por favor, selecciona un valor para tu hora de mentoría.'
                ]);
                $this->step = 18;
                $this->addBotMessage('Ya casi terminamos. Para validar tu perfil y garantizar una comunidad segura, te pedimos: Tomarte una selfie y cargar una foto de tu documento.');
                break;
            case 18:
                $this->validate(['selfie' => 'required|image', 'documentPhoto' => 'required|image'],
                [
                    'selfie.required' => 'Por favor, carga una selfie.',
                    'selfie.image' => 'La selfie debe ser un archivo de imagen válido.',
                    'documentPhoto.required' => 'Por favor, carga una foto de tu documento.',
                    'documentPhoto.image' => 'La foto del documento debe ser un archivo de imagen válido.'
                ]);
                // Almacena archivos: $this->selfie->store('photos');
                $this->step = 19;
                $this->addBotMessage('¡Listo! Tu perfil fue enviado para validación. En breve recibirás una notificación para comenzar a mentorear en Pipol.');
                // Aquí guarda todo en BD: Mentor::create([...]);
                break;
        }

        $this->dispatchScrollEvent();
        $this->loading = false;
    }

    private function normalizeSectors($input)
    {
        return str_replace(['gastronmia', 'gastronómico'], 'Gastronomía', $input);
    }

    private function tagSkills($input)
    {
        return $input;
    }

    public function render()
    {
        return view('livewire.mentor-registration-chat');
    }
    public function dispatchScrollEvent()
    {
        // $this->dispatchBrowserEvent('scrollToBottom');
        $this->dispatch('scrollToBottom', param1: 'hola');
    }
}
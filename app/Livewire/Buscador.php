<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Buscador extends Component
{
    protected $listeners = [
        'busquedaGenerada' => 'busquedaGeneradaFn'
    ];
    public $searchText = '';
    public $loader = false;

    public function render()
    {
        return view('livewire.buscador');
    }

    public function busqueda(){
        if(empty($this->searchText))return;
        $skills = User::whereNotNull('skills')
        ->pluck('skills')
        ->flatMap(function ($skills) {
            return collect(explode(',', $skills))
                ->map(fn ($skill) => trim(mb_strtolower($skill)));
        })
        ->unique()
        ->values();
        $skillsString = $skills->implode(', ');
        $this->loader = true;

        $this->dispatch('ejecutarBusqueda', data : $this->searchText, tags: $skillsString);
    }
    public function busquedaGeneradaFn($data) {
       
        $clean = $this->cleanAiJson($data);
        $clean = json_decode($clean, true);
       
        if ($clean['tags']) {
            return redirect()->route('mentors.index', ['params' => $clean['tags']]);
        }

        return redirect()->route('mentors.index',['error' => 'No se encotraron resultados.']);
    }

    public function cleanAiJson(string $response): string
    {
        // Eliminar comillas triples
        $response = trim($response, "\" \n");

        // Eliminar bloques ```json y ```
        $response = preg_replace('/```json|```/i', '', $response);

        return trim($response);
    }
    function extractJson(string $text): ?array
    {
        if (preg_match('/\[[\s\S]*\]/', $text, $matches)) {
            return json_decode($matches[0], true);
        }

        return null;
    }
}

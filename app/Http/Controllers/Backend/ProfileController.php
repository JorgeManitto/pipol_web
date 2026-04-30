<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Skills;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\PdfToText\Pdf;
use Smalot\PdfParser\Parser;

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
        
        // Perfil Profesional
        'bio'            => 'nullable|string|max:2000',
        'years_of_experience' => 'nullable|integer|min:0|max:50',
        'seniority'      => 'nullable',
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
        'hourly_rate'    => 'nullable|numeric',
        'currency'       => 'nullable|string|size:3',
        
        // Enlaces
        'linkedin_url'   => 'nullable|url|max:255',
        'website'        => 'nullable|url|max:255',
        
        // Imágenes
        'avatar'         => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        'selfie'         => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        'documentPhoto'  => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        
        // Otros
        'is_mentor'      => 'nullable|boolean',
    ], [
        // Información Básica
        'name.required'        => 'El nombre es obligatorio.',
        'name.max'             => 'El nombre no puede superar los 255 caracteres.',
        'last_name.max'        => 'El apellido no puede superar los 255 caracteres.',
        'email.required'       => 'El correo electrónico es obligatorio.',
        'email.email'          => 'Ingresá un correo electrónico válido.',
        'email.unique'         => 'Este correo electrónico ya está en uso.',
        'birth_date.date'      => 'La fecha de nacimiento no es válida.',
        'birth_date.before'    => 'La fecha de nacimiento debe ser anterior a hoy.',
        'gender.in'            => 'El género seleccionado no es válido.',
        'country.required'     => 'El país es obligatorio.',
        'country.max'          => 'El país no puede superar los 100 caracteres.',
        'city.max'             => 'La ciudad no puede superar los 100 caracteres.',
        'profession.max'       => 'La profesión no puede superar los 255 caracteres.',

        // Perfil Profesional
        'bio.max'                    => 'La biografía no puede superar los 2000 caracteres.',
        'years_of_experience.integer' => 'Los años de experiencia deben ser un número entero.',
        'years_of_experience.min'    => 'Los años de experiencia no pueden ser negativos.',
        'years_of_experience.max'    => 'Los años de experiencia no pueden superar 50.',
        'skills.max'                 => 'Las habilidades no pueden superar los 1000 caracteres.',

        // Experiencia Laboral
        'workingNow.boolean'      => 'El campo "trabajando actualmente" no es válido.',
        'currentPosition.max'     => 'El puesto actual no puede superar los 255 caracteres.',
        'lastPosition.max'        => 'El último puesto no puede superar los 255 caracteres.',
        'companies.max'           => 'Las empresas no pueden superar los 500 caracteres.',
        'sectors.max'             => 'Los sectores no pueden superar los 500 caracteres.',

        // Formación
        'education.max'  => 'La formación no puede superar los 1000 caracteres.',
        'languages.max'  => 'Los idiomas no pueden superar los 500 caracteres.',

        // Tarifas y Pagos
        'hourly_rate.numeric' => 'La tarifa por hora debe ser un valor numérico.',
        'currency.size'       => 'La moneda debe tener exactamente 3 caracteres.',

        // Enlaces
        'linkedin_url.url' => 'El enlace de LinkedIn no es una URL válida.',
        'linkedin_url.max' => 'El enlace de LinkedIn no puede superar los 255 caracteres.',
        'website.url'      => 'El sitio web no es una URL válida.',
        'website.max'      => 'El sitio web no puede superar los 255 caracteres.',

        // Imágenes
        'avatar.image'         => 'El avatar debe ser una imagen.',
        'avatar.mimes'         => 'El avatar debe ser JPG, JPEG, PNG o GIF.',
        'avatar.max'           => 'El avatar no puede superar los 2 MB.',
        'selfie.image'         => 'La selfie debe ser una imagen.',
        'selfie.mimes'         => 'La selfie debe ser JPG, JPEG o PNG.',
        'selfie.max'           => 'La selfie no puede superar los 5 MB.',
        'documentPhoto.image'  => 'El documento debe ser una imagen.',
        'documentPhoto.mimes'  => 'El documento debe ser JPG, JPEG o PNG.',
        'documentPhoto.max'    => 'El documento no puede superar los 5 MB.',

        // Otros
        'is_mentor.boolean' => 'El campo mentor no es válido.',
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
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => 'required|current_password',
        ], [
            'password.required' => 'Debes ingresar tu contraseña para confirmar.',
            'password.current_password' => 'La contraseña ingresada no es correcta.',
        ]);

        $user = Auth::user();

        // Eliminar archivos asociados
        if ($user->avatar && Storage::exists('public/avatars/' . $user->avatar)) {
            Storage::delete('public/avatars/' . $user->avatar);
        }
        if ($user->selfie && Storage::exists($user->selfie)) {
            Storage::delete($user->selfie);
        }
        if ($user->documentPhoto && Storage::exists($user->documentPhoto)) {
            Storage::delete($user->documentPhoto);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Tu cuenta ha sido eliminada correctamente.');
    }


    public function returnTextFromCv(Request $request)
    {
        $validated = $request->validate(
            ['cvFile' => 'required|file|mimes:pdf,doc,docx|max:10240'],
            [
                'cvFile.required' => 'Por favor, carga tu CV.',
                'cvFile.file'     => 'El archivo debe ser un archivo válido.',
                'cvFile.mimes'    => 'El archivo debe ser PDF o documento de Word.',
                'cvFile.max'      => 'El archivo no puede superar los 10 MB.',
            ]
        );

        $file = $request->file('cvFile');
        $ext  = strtolower($file->getClientOriginalExtension());
        $path = $file->getRealPath();

        try {
            $text = match (true) {
                in_array($ext, ['doc', 'docx']) => $this->extractFromWord($path, $ext),
                default                         => $this->extractFromPdf($path),
            };
        } catch (\Throwable $e) {
            // Log::error('CV parsing failed', [
            //     'file'  => $file->getClientOriginalName(),
            //     'error' => $e->getMessage(),
            // ]);

            return response()->json([
                'error' => 'No se pudo extraer el texto del archivo.',
            ], 422);
        }

        $text = $this->cleanText($text);

        if (empty($text)) {
            return response()->json([
                'error' => 'No se pudo extraer texto de este PDF. '
                        . 'Probá subirlo en formato DOCX.',
            ], 422);
        }

        return response()->json(['text' => $text]);
    }

    /**
     * Extrae texto del PDF con Smalot optimizado.
     * Intenta página por página si el método global falla.
     */
    private function extractFromPdf(string $path): string
    {
        $parser = new Parser();
        $pdf    = $parser->parseFile($path);

        // Intento 1: extracción global
        $text = $pdf->getText();

        if ($this->isUsableText($text)) {
            return $text;
        }

        // Intento 2: página por página (a veces funciona mejor)
        $text  = '';
        $pages = $pdf->getPages();

        foreach ($pages as $page) {
            try {
                $text .= $page->getText() . "\n";
            } catch (\Throwable $e) {
                // Saltar páginas problemáticas
                continue;
            }
        }

        if ($this->isUsableText($text)) {
            return $text;
        }

        // Intento 3: extraer texto de los objetos internos del PDF
        $text = $this->extractFromPdfObjects($pdf);

        return $text;
    }

    /**
     * Recorre los objetos internos del PDF buscando texto.
     * Útil cuando getText() falla por encoding.
     */
    private function extractFromPdfObjects(\Smalot\PdfParser\Document $pdf): string
    {
        $text = '';

        try {
            $objects = $pdf->getObjects();

            foreach ($objects as $object) {
                if (method_exists($object, 'getText')) {
                    try {
                        $content = $object->getText();
                        if (!empty(trim($content))) {
                            $text .= $content . ' ';
                        }
                    } catch (\Throwable $e) {
                        continue;
                    }
                }
            }
        } catch (\Throwable $e) {
            // Log::warning('PDF object extraction failed', [
            //     'error' => $e->getMessage(),
            // ]);
        }

        return $text;
    }

    /**
     * Extrae texto de archivos Word sin dependencias externas.
     */
    private function extractFromWord(string $path, string $ext): string
    {
        if ($ext !== 'docx') {
            return ''; // .doc requiere binarios externos
        }

        $zip = new \ZipArchive();

        if ($zip->open($path) !== true) {
            return '';
        }

        $xml = $zip->getFromName('word/document.xml');
        $zip->close();

        if (empty($xml)) {
            return '';
        }

        // Agregar espacios antes de tags para separar palabras
        $xml = str_replace('<', ' <', $xml);

        return strip_tags($xml);
    }

    private function cleanText(string $text): string
    {
        // Eliminar caracteres de control
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F]/', '', $text);
        // Normalizar espacios
        $text = preg_replace('/\s+/', ' ', $text);

        return trim($text);
    }

    /**
     * Verifica que el texto extraído sea útil.
     */
    private function isUsableText(string $text): bool
    {
        $cleaned = trim(preg_replace('/\s+/', '', $text));

        if (mb_strlen($cleaned) < 50) {
            return false;
        }

        $letters = preg_match_all('/\pL/u', $cleaned);
        $ratio   = $letters / max(mb_strlen($cleaned), 1);

        return $ratio > 0.5;
    }
}
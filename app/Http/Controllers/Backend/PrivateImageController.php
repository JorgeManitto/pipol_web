<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PrivateImageController extends Controller
{
    /**
     * Servir imágenes del storage privado
     */
    public function show($path)
    {
        // Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            abort(403, 'No autorizado');
        }

        // Decodificar el path (por si tiene caracteres especiales)
        $decodedPath = urldecode($path);
        
        // Verificar que el archivo existe
        if (!Storage::exists($decodedPath)) {
            abort(404, 'Imagen no encontrada');
        }

        // Obtener el archivo
        $file = Storage::get($decodedPath);
        $type = Storage::mimeType($decodedPath);

        // Retornar la imagen con el tipo MIME correcto
        return response($file, 200)->header('Content-Type', $type);
    }

    /**
     * Servir imágenes privadas con más seguridad (solo el dueño o admin)
     */
    public function showSecure($path)
    {
        $user = Auth::user();
        
        if (!$user) {
            abort(403, 'No autorizado');
        }

        $decodedPath = urldecode($path);
        
        // Verificar que el archivo pertenece al usuario actual
        // Asumiendo que el path incluye el user_id o algún identificador
        $belongsToUser = false;
        
        // Verificar si es admin o si es el dueño del archivo
        if ($user->role === 'admin') {
            $belongsToUser = true;
        } else {
            // Buscar si algún usuario tiene este selfie o documento
            $owner = \App\Models\User::where('selfie', $decodedPath)
                ->orWhere('documentPhoto', $decodedPath)
                ->first();
            
            if ($owner && $owner->id === $user->id) {
                $belongsToUser = true;
            }
        }

        if (!$belongsToUser) {
            abort(403, 'No tienes permiso para ver esta imagen');
        }

        if (!Storage::exists($decodedPath)) {
            abort(404, 'Imagen no encontrada');
        }

        $file = Storage::get($decodedPath);
        $type = Storage::mimeType($decodedPath);

        return response($file, 200)->header('Content-Type', $type);
    }
}
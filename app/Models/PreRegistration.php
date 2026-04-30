<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PreRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'cv_path',
        'cv_original_name',
        'linkedin_url',
        'ip_address',
        'user_agent',
        'status',
        'email_sent_at',
    ];

    protected $casts = [
        'email_sent_at' => 'datetime',
    ];

    /**
     * URL temporal para descargar el CV (1 hora).
     */
    public function getCvUrlAttribute(): ?string
    {
        if (!$this->cv_path) {
            return null;
        }

        return Storage::disk('private')->temporaryUrl(
            $this->cv_path,
            now()->addHour()
        );
    }

    /**
     * Borra el archivo físico al borrar el registro.
     */
    protected static function booted(): void
    {
        static::deleting(function (PreRegistration $registration) {
            if ($registration->cv_path) {
                Storage::disk('private')->delete($registration->cv_path);
            }
        });
    }
}

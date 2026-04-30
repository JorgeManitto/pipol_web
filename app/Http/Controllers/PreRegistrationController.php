<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePreRegistrationRequest;
use App\Mail\PreRegistrationConfirmation;
use App\Models\PreRegistration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class PreRegistrationController extends Controller
{
    public function store(StorePreRegistrationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $cvPath = null;
        $cvOriginalName = null;

        // Subida del CV (privado)
        if ($request->hasFile('cv')) {
            $file = $request->file('cv');
            $cvOriginalName = $file->getClientOriginalName();

            $filename = Str::slug(pathinfo($cvOriginalName, PATHINFO_FILENAME))
                . '_' . Str::random(8)
                . '.' . $file->getClientOriginalExtension();

            $cvPath = $file->storeAs('cvs', $filename, 'private');
        }

        $registration = PreRegistration::create([
            'email'            => $data['email'],
            'cv_path'          => $cvPath,
            'cv_original_name' => $cvOriginalName,
            'linkedin_url'     => $data['linkedin_url'] ?? null,
            'ip_address'       => $request->ip(),
            'user_agent'       => $request->userAgent(),
            'status'           => 'pending',
        ]);

        // Mail de confirmación (encolado)
        try {
            Mail::to($registration->email)
                ->queue(new PreRegistrationConfirmation($registration));

            $registration->update(['email_sent_at' => now()]);
        } catch (\Throwable $e) {
            report($e); // No bloqueamos el flujo si falla el mail
        }

        return back()->with('success', '¡Listo! Te pre registraste con éxito. Revisá tu email.');
    }
}
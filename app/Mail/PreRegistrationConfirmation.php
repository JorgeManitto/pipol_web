<?php

namespace App\Mail;

use App\Models\PreRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PreRegistrationConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public PreRegistration $registration) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Bienvenido a Pipol! Tu pre registro fue exitoso 🎉',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pre-registration-confirmation',
            with: ['email' => $this->registration->email],
        );
    }
}
<?php

namespace App\Mail;

use App\Models\AsistenteForo;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class InscripcionConfirmada extends Mailable
{
    public function __construct(public AsistenteForo $asistente)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: 'Registro confirmado · Foro TI 2026');
    }

    public function content(): Content
    {
        return new Content(view: 'emails.inscripcion');
    }
}
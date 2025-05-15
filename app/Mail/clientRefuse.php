<?php

namespace App\Mail;

use App\Models\Reservation; 
use App\Models\User; 
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class clientRefuse extends Mailable 
{
    use Queueable, SerializesModels;

 
    public Reservation $reservation;

   
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Information concernant votre demande de réservation CampShare', 
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.clientRefuse',
        );
    }

    public function attachments(): array
    {
        return [];
    }

}
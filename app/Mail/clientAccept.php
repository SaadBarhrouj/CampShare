<?php

namespace App\Mail;

use App\Models\User;
use App\Models\Reservation; 
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log; 

class clientAccept extends Mailable
{
    use Queueable, SerializesModels;

  
    public User $partner;

  
    public Reservation $reservation;

    public User $client;
 
    public function __construct(User $partner, Reservation $reservation)
    {
        $this->partner = $partner;
        $this->reservation = $reservation;
        $this->client = $reservation->client;
        
        Log::info("Email clientAccept préparé pour: {$this->client->email}, réservation #{$this->reservation->id}");
    }

  
    public function envelope(): Envelope
    {
        return new Envelope(

            subject: 'Votre réservation CampShare a été acceptée !', 
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.clientAccept', 
        );
    }


    public function attachments(): array
    {

        return [];
    }

}
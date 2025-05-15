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

class partnerAccept extends Mailable
{
    use Queueable, SerializesModels;


    public User $client;
    

    public Reservation $reservation;
    

    public User $partner;


    public function __construct(User $client, Reservation $reservation)
    {
        $this->client = $client;
        $this->reservation = $reservation;
        $this->partner = $reservation->partner;
        
        // Log pour le débogage
        Log::info("Email partnerAccept préparé pour: {$this->partner->email}, réservation #{$this->reservation->id}");
    }


    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Vous avez accepté une réservation CampShare', 
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.partnerAccept',
        );
    }


    public function attachments(): array
    {
        return [];
    }
}
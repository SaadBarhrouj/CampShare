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
use Illuminate\Mail\Mailables\Address;

class RequestPartnerToReviewClientMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;
    public User $partner;
    public string $clientName;
    public string $itemName;

    public function __construct(Reservation $reservation, User $partner, string $clientName, string $itemName)
    {
        $this->reservation = $reservation;
        $this->partner = $partner;
        $this->clientName = $clientName;
        $this->itemName = $itemName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            to: $this->partner->email,
            subject: 'Évaluez votre expérience avec le client ' . $this->clientName,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reviews.request_partner_to_review_client',
            with: [
                'partnerName' => $this->partner->username,
                'clientName' => $this->clientName,
                'itemName' => $this->itemName,
                'reservationId' => $this->reservation->id,
                'reviewClientUrl' => route('reviews.create', [
                    'reservation' => $this->reservation->id,
                    'type' => 'review_client'
                ]),
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
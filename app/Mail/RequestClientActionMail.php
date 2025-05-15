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

class RequestClientActionMail extends Mailable
{
    use Queueable, SerializesModels;

    public Reservation $reservation;
    public User $client;
    public string $itemName;
    public string $partnerName;
    public bool $needsObjectReview;
    public bool $needsPartnerReview;

    public function __construct(Reservation $reservation, User $client, string $itemName, string $partnerName, bool $needsObjectReview, bool $needsPartnerReview)
    {
        $this->reservation = $reservation;
        $this->client = $client;
        $this->itemName = $itemName;
        $this->partnerName = $partnerName;
        $this->needsObjectReview = $needsObjectReview;
        $this->needsPartnerReview = $needsPartnerReview;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            to: $this->client->email,
            subject: 'Votre avis compte : Évaluez votre récente location CampShare !',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reviews.request_client_actions',
            with: [
                'clientName' => $this->client->username,
                'itemName' => $this->itemName,
                'partnerName' => $this->partnerName,
                'reservationId' => $this->reservation->id,
                'reviewObjectUrl' => $this->needsObjectReview ? route('reviews.create', ['reservation' => $this->reservation->id, 'type' => 'review_object']) : null,
                'reviewPartnerUrl' => $this->needsPartnerReview ? route('reviews.create', ['reservation' => $this->reservation->id, 'type' => 'review_partner']) : null,
                'needsObjectReview' => $this->needsObjectReview,
                'needsPartnerReview' => $this->needsPartnerReview,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
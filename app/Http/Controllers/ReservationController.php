<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Reservation;
use App\Models\Notification;
use App\Models\User;
use App\Mail\clientAccept;
use App\Mail\partnerAccept; 
use App\Mail\clientRefuse;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ReservationController extends Controller
{
    
     public function store(Request $request)
    {
        // --- 1. Validation des données du formulaire ---
        $validator = Validator::make($request->all(), [
            'listing_id' => 'required|integer|exists:listings,id',
            'start_date' => 'required|date_format:Y-m-d|after_or_equal:today',
            'end_date' => 'required|date_format:Y-m-d|after_or_equal:start_date',
            'delivery_option' => 'nullable|boolean',
        ]);


        if ($validator->fails()) {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }


        // Récupérer les données validées
        $validatedData = $validator->validated();


        // --- 2. Récupérer les informations nécessaires ---
        $listing = Listing::with('item.partner')->findOrFail($validatedData['listing_id']);
        $client = Auth::user();
        


        if (!$listing->item?->partner) {
             return redirect()->back()
                         ->with('error', 'Impossible de trouver le propriétaire de cet équipement.')
                          // -----------------
                         ->withInput();
        }
        $partner = $listing->item->partner;

   
        if ($client->id === $partner->id) {
             return redirect()->back()
                         ->with('error', 'Vous ne pouvez pas réserver votre propre équipement.')

                         ->withInput();
        }



        if ($listing->status !== 'active') {
             return redirect()->back()
                         ->with('error', 'Cet équipement n\'est plus disponible à la location.')
                          //--------------
                         ->withInput();
        }


        $startDate = \Carbon\Carbon::parse($validatedData['start_date']);
        $endDate = \Carbon\Carbon::parse($validatedData['end_date']);


        if ($listing->start_date && $startDate->isBefore($listing->start_date)) {
            return redirect()->back()
                         ->with('error', 'La date de début demandée est avant la disponibilité de l\'équipement.')
                          //-------
                         ->withInput();
        }
        if ($listing->end_date && $endDate->isAfter($listing->end_date)) {
            return redirect()->back()
                         ->with('error', 'La date de fin demandée est après la disponibilité de l\'équipement.')
                          //--------
                         ->withInput();
        }


        $overlappingReservations = Reservation::where('listing_id', $listing->id)
            ->whereIn('status', ['confirmed', 'ongoing'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    // La nouvelle résa commence PENDANT une existante
                    $q->where('start_date', '<=', $startDate)
                      ->where('end_date', '>=', $startDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    // La nouvelle résa finit PENDANT une existante
                    $q->where('start_date', '<=', $endDate)
                      ->where('end_date', '>=', $endDate);
                })->orWhere(function ($q) use ($startDate, $endDate) {
                    $q->where('start_date', '>=', $startDate)
                      ->where('end_date', '<=', $endDate);
                });
            })
            ->exists();


        if ($overlappingReservations) {
            return redirect()->back()
                         ->with('error', 'Les dates sélectionnées ne sont plus disponibles car elles chevauchent une réservation existante.')
                          //-------
                         ->withInput();
        }


        // --- 4. Gestion de l'option de livraison ---
        $deliveryRequested = $request->has('delivery_option') && $validatedData['delivery_option'] == '1';
        $applyDelivery = false;


        if ($deliveryRequested && !$listing->delivery_option) {
             // Si l'utilisateur coche livraison mais que le listing ne l'offre pas
             return redirect()->back()
                         ->with('error', 'L\'option de livraison n\'est pas disponible pour cet équipement.')
                          //---------
                         ->withInput();
        } elseif ($deliveryRequested && $listing->delivery_option) {
             $applyDelivery = true;
        }


        // --- 5. Création de la Réservation ---
        // try {
            $reservation = new Reservation();
            $reservation->listing_id = $listing->id;
            $reservation->client_id = $client->id;
            $reservation->partner_id = $partner->id;
            $reservation->start_date = $startDate;
            $reservation->end_date = $endDate;
            $reservation->status = 'pending';
            $reservation->delivery_option = $applyDelivery;
            $reservation->save();


             // Modification : Rediriger vers la page des réservations du client
             return redirect()->route('HomeClient.reservations')
                              ->with('success', 'Votre réservation a été enregistrée !')
                              ->with('notificationType', 'success');


        // } catch (\Exception $e) {
        //     \Log::error('Erreur lors de la création de la réservation: ' . $e->getMessage());


        //     return redirect()->back()
        //                  ->with('error', 'Une erreur est survenue lors de la création de votre réservation. Veuillez réessayer.')
        //                  ->withInput();
        // }
    }


   public function accept(Reservation $reservation)
{
    // Étape 1 : Vérifications initiales (votre code existant - inchangé)
    if (Auth::id() !== $reservation->partner_id) { abort(403); }
    if ($reservation->status !== 'pending') {
        return redirect()->back()
                         ->with('error', 'Déjà traitée.');
    }

    // Étape 2 : Vérification de conflit de dates (votre code existant - inchangé)
    $startDate = Carbon::parse($reservation->start_date);
    $endDate = Carbon::parse($reservation->end_date);
    $conflicting = Reservation::where('listing_id', $reservation->listing_id)
         ->where('id', '!=', $reservation->id)->whereIn('status', ['confirmed', 'ongoing'])
         ->where(fn($q) => $q->where('start_date', '<', $endDate)->where('end_date', '>', $startDate))->exists();
    if ($conflicting) {
        return redirect()->back()
                         ->with('error', 'Conflit de dates.');
    }

    // Étape 3 : Mise à jour du statut de la réservation (votre code existant - inchangé)
    try {
        $reservation->status = 'confirmed';
        $reservation->save();
    } catch (\Exception $e) {
        Log::error("Erreur sauvegarde accept Résa ID: {$reservation->id}: " . $e->getMessage());
        return redirect()->back()
                         ->with('error', 'Erreur sauvegarde statut.');
    }

    // Étape 4 : Récupération des données nécessaires
    $client = $reservation->client;
    $partner = $reservation->partner;
    // --- MODIFICATION 1 : Charger la relation listing et son item ---
    $reservation->loadMissing('listing.item');
    $listing = $reservation->listing;

    // Étape 5 : Vérifier si toutes les données sont présentes avant d'envoyer emails et notifications
    // --- MODIFICATION 2 : Mettre à jour la condition IF ---
    if ($client && $partner && $listing && $listing->item) {
        // Envoi des emails (votre code existant - inchangé)
        try {
            Log::info("Préparation de l'email pour le client: {$client->email}");
            Mail::to($client->email)->send(new clientAccept($partner, $reservation));
            Log::info("Email envoyé avec succès au client: {$client->email}");
        } catch (\Exception $e) {
            Log::error("Échec email CLIENT accept Résa ID: {$reservation->id}: " . $e->getMessage());
        }

        try {
            Log::info("Préparation de l'email pour le partenaire: {$partner->email}");
            Mail::to($partner->email)->send(new partnerAccept($client, $reservation));
            Log::info("Email envoyé avec succès au partenaire: {$partner->email}");
        } catch (\Exception $e) {
            Log::error("Échec email PARTENAIRE accept Résa ID: {$reservation->id}: " . $e->getMessage());
        }

        // --- MODIFICATION 3 : Création de la notification pour le client (votre code existant pour cela) ---
        try {
            $partnerName = trim(($partner->first_name ?? '') . ' ' . ($partner->last_name ?? ''));
            if (empty($partnerName)) {
                $partnerName = $partner->username; // Fallback au nom d'utilisateur
            }

            $contactInfo = " Contactez le partenaire ({$partnerName}) :";
            $contactInfo .= " Email: {$partner->email}";
            if ($partner->phone_number) {
                $contactInfo .= ", Tél: {$partner->phone_number}";
            }
            $contactInfo .= ".";

            // $listing et $listing->item sont maintenant disponibles
            Notification::create([
                'user_id' => $client->id,
                'type' => 'accepted_reservation',
                'message' => "Bonne nouvelle ! Votre réservation pour '{$listing->item->title}' du " .
                             Carbon::parse($reservation->start_date)->format('d/m/Y') . " au " .
                             Carbon::parse($reservation->end_date)->format('d/m/Y') .
                             " a été acceptée." . $contactInfo,
                'listing_id' => $listing->id, // Utilisation de $listing->id
                'reservation_id' => $reservation->id,
                'is_read' => false,
            ]);
            Log::info("Notification 'accepted_reservation' avec infos partenaire créée pour le client ID: {$client->id} pour la réservation ID: {$reservation->id}");
        } catch (\Exception $e) {
            Log::error("Échec création notification CLIENT accept Résa ID: {$reservation->id}: " . $e->getMessage(), ['exception' => $e]);
        }

    } else {
        // Log amélioré si des informations sont manquantes (recommandé de garder ceci)
        $missingInfo = [];
        if (!$client) $missingInfo[] = 'client';
        if (!$partner) $missingInfo[] = 'partner';
        if (!$listing) $missingInfo[] = 'listing';
        elseif (!$listing->item) $missingInfo[] = 'listing->item (l\'item de l\'annonce est manquant)';
        Log::error("Infos manquantes pour emails/notifications (accept) Résa ID: {$reservation->id}. Manquant: " . implode(', ', $missingInfo));
    }

    // Étape 6 : Redirection (votre code existant - inchangé)
    // Le message flash a été mis à jour pour inclure "Le client a été notifié."
    return redirect()->back()
                     ->with('success', 'Réservation acceptée ! Le client a été notifié.')
                     ->with('notificationType', 'success');
}


public function reject(Reservation $reservation)
{
    // Étape 1 : Vérifications initiales (votre code existant - inchangé)
    if (Auth::id() !== $reservation->partner_id) { abort(403); }
    if ($reservation->status !== 'pending') {
        return redirect()->back()
                         ->with('error', 'Déjà traitée.');
    }

    // Étape 2 : Mise à jour du statut de la réservation (votre code existant - inchangé)
    try {
        $reservation->status = 'canceled';
        $reservation->save();
    } catch (\Exception $e) {
        Log::error("Erreur sauvegarde refus Résa ID: {$reservation->id}: " . $e->getMessage());
        return redirect()->back()
                         ->with('error', 'Erreur sauvegarde statut.');
    }

    // Étape 3 : Récupération des données nécessaires
    $client = $reservation->client;
    // --- MODIFICATION 1 (reject) : Charger la relation listing et son item ---
    $reservation->loadMissing('listing.item');
    $listing = $reservation->listing;

    // Étape 4 : Vérifier si toutes les données sont présentes avant d'envoyer email et notification
    // --- MODIFICATION 2 (reject) : Mettre à jour la condition IF ---
    if ($client && $listing && $listing->item) { // Note: $partner n'est pas requis pour le message de refus au client
        // Envoi email au client (votre code existant - inchangé)
        if ($client->email) { // Vérification ajoutée pour $client->email pour plus de robustesse
            try {
                Mail::to($client->email)->send(new clientRefuse($reservation));
                Log::info("Email de refus envoyé au client: {$client->email} pour Résa ID: {$reservation->id}");
            }
            catch (\Exception $e) {
                Log::error("Échec email CLIENT refus Résa ID: {$reservation->id}: " . $e->getMessage());
            }
        } else {
            Log::error("Email du client manquant pour la notification de refus. Résa ID: {$reservation->id}");
        }

        // --- MODIFICATION 3 (reject) : Création de la notification de refus pour le client ---
        try {
            // $listing et $listing->item sont maintenant disponibles
            Notification::create([
                'user_id' => $client->id,
                'type' => 'rejected_reservation',
                'message' => "Malheureusement, votre réservation pour '{$listing->item->title}' du " .
                             Carbon::parse($reservation->start_date)->format('d/m/Y') . " au " .
                             Carbon::parse($reservation->end_date)->format('d/m/Y') .
                             " n'a pas pu être acceptée.",
                'listing_id' => $listing->id,
                'reservation_id' => $reservation->id,
                'is_read' => false,
            ]);
            Log::info("Notification 'rejected_reservation' créée pour le client ID: {$client->id} pour la réservation ID: {$reservation->id}");
        } catch (\Exception $e) {
            Log::error("Échec création notification CLIENT refus Résa ID: {$reservation->id}: " . $e->getMessage(), ['exception' => $e]);
        }

    } else {
        // Log amélioré si des informations sont manquantes
        $missingInfo = [];
        if (!$client) $missingInfo[] = 'client';
        if (!$listing) $missingInfo[] = 'listing';
        elseif (!$listing->item) $missingInfo[] = 'listing->item (l\'item de l\'annonce est manquant)';
        Log::error("Infos manquantes pour email/notification (reject) Résa ID: {$reservation->id}. Manquant: " . implode(', ', $missingInfo));
    }

    // Étape 5 : Redirection (votre code existant - inchangé)
    // Le message flash a été mis à jour pour inclure "Le client a été notifié."
    return redirect()->back()
                     ->with('success', 'Réservation refusée. Le client a été notifié.')
                     ->with('notificationType', 'success');
}


}
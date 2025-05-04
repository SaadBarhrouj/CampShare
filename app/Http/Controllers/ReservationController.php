<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Reservation;
use App\Models\User;
use App\Mail\clientAccept;
use App\Mail\partnerAccept; // Importer
use App\Mail\clientRefuse;  // Importer
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log; // Gardé pour les erreurs critiques
use Carbon\Carbon;

class ReservationController extends Controller
{
    
     public function store(Request $request)
     {
         // --- 1. Validation ---
         $validator = Validator::make($request->all(), [/* ... règles ... */]);
         if ($validator->fails()) { /* ... retour erreur validation ... */ }
         $validatedData = $validator->validated();

         // --- 2. Récupération Infos ---
         $listing = Listing::with(['item.partner'])->find($validatedData['listing_id']);
         if (!$listing?->item?->partner) { /* ... retour erreur équipement/partenaire non trouvé ... */ }
         $partner = $listing->item->partner;
         $client = Auth::user();

         // --- 3. Vérifications Disponibilité/Conflit ---
         if ($listing->status !== 'active') { /* ... retour erreur inactif ... */ }
         $startDate = Carbon::parse($validatedData['start_date']);
         $endDate = Carbon::parse($validatedData['end_date']);
         if ($listing->start_date && $startDate->isBefore(Carbon::parse($listing->start_date))) { /* ... retour erreur date début ... */ }
         if ($listing->end_date && $endDate->isAfter(Carbon::parse($listing->end_date))) { /* ... retour erreur date fin ... */ }
         $overlappingReservations = Reservation::where('listing_id', $listing->id)
             ->whereIn('status', ['confirmed', 'ongoing'])
             ->where(fn($q) => $q->where('start_date', '<', $endDate)->where('end_date', '>', $startDate))
             ->exists();
         if ($overlappingReservations) { /* ... retour erreur chevauchement ... */ }

         // --- 4. Gestion Livraison ---
         $deliveryRequested = $request->has('delivery_option') && $request->input('delivery_option') == '1';
         $applyDelivery = false;
         if ($deliveryRequested) {
             if (!$listing->delivery_option) { /* ... retour erreur livraison non dispo ... */ }
             $applyDelivery = true;
         }

         // --- 5. Création Réservation ---
         try {
             $reservation = new Reservation();
             $reservation->listing_id = $listing->id; $reservation->client_id = $client->id;
             $reservation->partner_id = $partner->id; $reservation->start_date = $startDate->toDateString();
             $reservation->end_date = $endDate->toDateString(); $reservation->status = 'pending';
             $reservation->delivery_option = $applyDelivery; $reservation->save();

             // Optionnel: Notifier partenaire de la nouvelle demande ici

             return redirect()->back()->with('success', 'Votre demande de réservation a été envoyée avec succès !');
         } catch (\Exception $e) {
             Log::error('Erreur création réservation: ' . $e->getMessage());
             return redirect()->back()->with('error', 'Erreur technique lors de la réservation.')->withInput();
         }
     }


   
    public function accept(Reservation $reservation)
    {
        // Vérifications initiales
        if (Auth::id() !== $reservation->partner_id) { abort(403); }
        if ($reservation->status !== 'pending') { return redirect()->back()->with('error', 'Déjà traitée.'); }

        // Vérification conflit
        $startDate = Carbon::parse($reservation->start_date);
        $endDate = Carbon::parse($reservation->end_date);
        $conflicting = Reservation::where('listing_id', $reservation->listing_id)
             ->where('id', '!=', $reservation->id)->whereIn('status', ['confirmed', 'ongoing'])
             ->where(fn($q) => $q->where('start_date', '<', $endDate)->where('end_date', '>', $startDate))->exists();
        if ($conflicting) { return redirect()->back()->with('error', 'Conflit de dates.'); }

        // Mise à jour statut
        try {
            $reservation->status = 'confirmed';
            $reservation->save();
        } catch (\Exception $e) {
            Log::error("Erreur sauvegarde accept Résa ID: {$reservation->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur sauvegarde statut.');
        }

        // Récupération données pour emails
        $client = $reservation->client;
        $partner = $reservation->partner; 

        if ($client && $partner) {
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
        } else {
            Log::error("Infos client/partenaire manquantes pour emails Résa ID: {$reservation->id}");
        }

        return redirect()->back()->with('success', 'Réservation acceptée ! Notifications envoyées.');
    }

  
    public function reject(Reservation $reservation)
    {
        // Vérifications initiales
        if (Auth::id() !== $reservation->partner_id) { abort(403); }
        if ($reservation->status !== 'pending') { return redirect()->back()->with('error', 'Déjà traitée.'); }

        // Mise à jour statut
        try {
            $reservation->status = 'canceled'; 
            $reservation->save();
        } catch (\Exception $e) {
            Log::error("Erreur sauvegarde refus Résa ID: {$reservation->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Erreur sauvegarde statut.');
        }

        // Récupération client pour email
        $client = $reservation->client;

        // Envoi email au client 
        if ($client?->email) { 
            try { Mail::to($client->email)->send(new clientRefuse($reservation)); }
            catch (\Exception $e) { Log::error("Échec email CLIENT refus Résa ID: {$reservation->id}: " . $e->getMessage()); }
        } else {
            Log::error("Infos client manquantes pour email refus Résa ID: {$reservation->id}");
        }

        return redirect()->back()->with('success', 'Réservation refusée. Le client a été notifié.');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


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
                         ->withInput();
        }
        $partner = $listing->item->partner;




        if ($listing->status !== 'active') {
             return redirect()->back()
                         ->with('error', 'Cet équipement n\'est plus disponible à la location.')
                         ->withInput();
        }


        $startDate = \Carbon\Carbon::parse($validatedData['start_date']);
        $endDate = \Carbon\Carbon::parse($validatedData['end_date']);


        if ($listing->start_date && $startDate->isBefore($listing->start_date)) {
            return redirect()->back()
                         ->with('error', 'La date de début demandée est avant la disponibilité de l\'équipement.')
                         ->withInput();
        }
        if ($listing->end_date && $endDate->isAfter($listing->end_date)) {
            return redirect()->back()
                         ->with('error', 'La date de fin demandée est après la disponibilité de l\'équipement.')
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
                         ->withInput();
        }


        // --- 4. Gestion de l'option de livraison ---
        $deliveryRequested = $request->has('delivery_option') && $validatedData['delivery_option'] == '1';
        $applyDelivery = false;


        if ($deliveryRequested && !$listing->delivery_option) {
             // Si l'utilisateur coche livraison mais que le listing ne l'offre pas
             return redirect()->back()
                         ->with('error', 'L\'option de livraison n\'est pas disponible pour cet équipement.')
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


       


             return redirect()->back()->with('success', 'Votre demande de réservation a été envoyée !');


        // } catch (\Exception $e) {
        //     \Log::error('Erreur lors de la création de la réservation: ' . $e->getMessage());


        //     return redirect()->back()
        //                  ->with('error', 'Une erreur est survenue lors de la création de votre réservation. Veuillez réessayer.')
        //                  ->withInput();
        // }
    }


}
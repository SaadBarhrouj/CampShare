<?php


namespace App\Http\Controllers;


use App\Models\Listing;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;


class EquipmentDetailController extends Controller
{
    public function show(Listing $listing)
    {
        if (!$listing->isAvailable()) {
             abort(404, 'Ce matériel n\'est plus disponible ou n\'existe pas.');
         }


        $listing->load([
            'item.partner',
            'item.category',
            'item.images',
            'city',
        ]);


        $reviews = $listing->getVisibleReviews();
        $ratingData = $listing->getRatingData();
        $unavailableDates = $this->generateDisabledDates($listing);

        
        return view('client.listings.show', [
            'listing' => $listing,
            'reviews' => $reviews,
            'averageRating' => $ratingData['average'],
            'reviewCount' => $ratingData['count'],
            'ratingPercentages' => $ratingData['percentages'],
            'unavailableDates' => $unavailableDates
        ]);
       
    }



    private function generateDisabledDates(Listing $listing): array
    {
        $disabledRanges = [];
        $now = Carbon::today();
        $startDate = $listing->start_date;
        $endDate = $listing->end_date;  


         if ($startDate && $startDate->isFuture()) {
             $disabledRanges[] = [
                 'from' => $now->format('Y-m-d'), 
                 'to' => $startDate->copy()->subDay()->format('Y-m-d')
             ];
         } else {
             $disabledRanges[] = [
                 'from' => '1970-01-01',
                 'to' => $now->copy()->subDay()->format('Y-m-d')
             ];
         }



        if ($endDate) {
            $disabledRanges[] = [
                'from' => $endDate->copy()->addDay()->format('Y-m-d'),
                'to' => '2038-01-19'
            ];
        }


   
        $reservations = $listing->reservations()
            ->confirmedOrOngoing()
            ->get(['start_date', 'end_date']);


        foreach ($reservations as $reservation) {
            if ($reservation->start_date && $reservation->end_date) {
                $disabledRanges[] = [
                    'from' => $reservation->start_date->format('Y-m-d'),
                    'to' => $reservation->end_date->format('Y-m-d')
                ];
            }
        }


        return $disabledRanges;
    }




    public function getReservedDates(Listing $listing)
    {
        try {
            $disabledRanges = $this->generateDisabledDates($listing);
            return response()->json($disabledRanges);


        } catch (\Exception $e) {
            Log::error('Erreur de récupération des dates réservées pour listing ' . $listing->id . ': ' . $e->getMessage());
            return response()->json(['error' => 'Impossible de récupérer les dates de réservation.'], 500);
        }
    }
}

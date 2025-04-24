<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartenaireModel extends Model
{
    public static function getMonthlyPaymentsSumPartenaire($email)
    {
        return DB::table('payments')
            ->where('partner_id', $email)
            ->whereMonth('payment_date', Carbon::now()->month)
            ->whereYear('payment_date', Carbon::now()->year)
            ->sum('amount');
    }
    public static function getNumberReservation($email){
        return DB::table('users as U')
            ->join('reservations as R', 'R.partner_id', '=', 'U.id')
            ->where('U.email', $email)
            ->count('R.id');
    }
    Public static function getAverageRating($email){

        return DB::table('users')
            ->where('email', $email)
            ->value('avg_rating');

    }
    Public static function getNumberRating($email){
        
        return DB::table('users')
            ->where('email', $email)
            ->value('review_count');
    }
    public static function countListingsByEmail($email)
    {
        return DB::table('users as U')
            ->join('listings as L', 'L.partner_id', '=', 'U.id')
            ->where('U.email', $email)
            ->count('L.id');
    }
    public static function countActiveListingsByEmail($email)
    {
        return DB::table('users as U')
            ->join('listings as L', 'L.partner_id', '=', 'U.id')
            ->where('U.email', $email)
            ->where('L.status', 'active')
            ->count('L.id');
    }

    public static function getNumberOfPendingReservation($email){
        return DB::table('users as U')
        ->join('reservations as R', 'R.partner_id', '=', 'U.id')
        ->where('U.email', $email)
        ->where('R.status', 'pending')
        ->count('R.id');
    }

    public static function getNumberOfPartenaireEquipement($email){
        return DB::table('users as U')
        ->join('Listings as L', 'L.partner_id', '=', 'U.id')
        ->where('U.email', $email)
        ->count('L.id');
    }

    public static function getPendingReservationsWithMontantTotal($email)
    {
        return DB::table('users as U')
            ->join('reservations as R', 'R.partner_id', '=', 'U.id')
            ->join('listings as L', 'L.id', '=', 'R.listing_id')
            ->join('users as C', 'C.id', '=', 'R.client_id')
            ->select(
                'C.username',
                'L.title',
                'R.start_date',
                'R.end_date',
                'R.created_at',
                'R.id',
                DB::raw('DATEDIFF(R.end_date, R.start_date) * L.price_per_day AS montant_total'),
                DB::raw('DATEDIFF(R.end_date, R.start_date)  AS number_days')

            )
            ->where('U.email', $email)
            ->where('R.status', 'pending')
            ->orderby('R.created_at', 'desc')
            ->limit(3)
            ->get();
    }
    public static function getListingsByEmail($email)
    {
        return DB::table('users as U')
            ->join('reservations as R', 'R.partner_id', '=', 'U.id')
            ->join('listings as L', 'L.id', '=', 'R.listing_id')
            ->join('users as C', 'C.id', '=', 'R.client_id')
            ->select(
                'C.username',
                'L.title',
                'R.start_date',
                'R.end_date',
                'R.created_at',
                DB::raw('DATEDIFF(R.end_date, R.start_date) * L.price_per_day AS montant_total')
            )
            ->where('U.email', $email)
            ->where('R.status', 'pending')
            ->get();
    }
    public static function getRecentPartnerListingsWithImagesByEmail($email)
    {
        return DB::table('users as U')
            ->join('listings as L', 'L.partner_id', '=', 'U.id')
            ->leftJoin('images as i', 'i.listing_id', '=', 'L.id')
            ->join('categories as c','c.id','L.category_id')
            ->where('U.email', $email)
            ->select('L.title', 'L.description', 'L.price_per_day', 'i.url', 'L.status','c.name')
            ->orderBy('L.created_at', 'desc')
            ->limit(4)
            ->get();
    }

    public static function getPartenerDemandeReservation($email){
        return DB::table('users as U')
            ->join('reservations as R', 'R.partner_id', '=', 'U.id')
            ->join('listings as L', 'L.id', '=', 'R.listing_id')
            ->join('users as C', 'C.id', '=', 'R.client_id')
            ->select(
                'C.username',
                'L.title',
                'R.start_date',
                'R.end_date',
                'C.avatar_url',
                'R.created_at',
                'R.status',
                'L.price_per_day',
                DB::raw('DATEDIFF(R.end_date, R.start_date) * L.price_per_day AS montant_total'),

                DB::raw('DATEDIFF(R.end_date, R.start_date) AS number_days')

            )
            ->where('U.email', $email)
            ->paginate(5);

    }
    public static function getPartenerEquipement($email)
    {
        return DB::table('users as U')
            ->join('listings as L', 'L.partner_id', '=', 'U.id')
            ->join('categories as C', 'C.id', '=', 'L.category_id')
            ->select(
                'L.title',
                'L.description',
                'L.status',
                'L.price_per_day',
                'C.*'
            )
            ->where('U.email', $email)
            ->get(); 
    }
    public static function getLocationsEncours($email)
    {
        return DB::table('users as U')
        ->join('reservations as R', 'R.partner_id', '=', 'U.id')
        ->join('listings as L', 'L.id', '=', 'R.listing_id')
        ->join('users as C', 'C.id', '=', 'R.client_id')
        ->select(
            'C.username',
            'L.title',
            'R.start_date',
            'R.end_date',
            'C.avatar_url',
            'R.created_at',
            'L.price_per_day',
            DB::raw('DATEDIFF(R.end_date, R.start_date) * L.price_per_day AS montant_total'),

            DB::raw('DATEDIFF(R.end_date, R.start_date) AS number_days')

        )
        ->where('U.email', $email)
        ->where ('R.status','ongoing')
        ->get();
    }
    public static function getNumberLocationsEncours($email)
    {
        return DB::table('users as U')
        ->join('reservations as R', 'R.partner_id', '=', 'U.id')
        ->join('listings as L', 'L.id', '=', 'R.listing_id')
        ->join('users as C', 'C.id', '=', 'R.client_id')
        ->where('U.email', $email)
        ->where ('R.status','ongoing')
        ->count('R.id');
    }


}

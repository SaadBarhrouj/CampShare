<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PartenaireModel extends Model
{
    public static function sumPaymentThisMonth($email)
    {
        return DB::table('payments as p')
            ->join('Users as U', 'U.id', '=', 'p.partner_id')
            ->where('U.email', $email)
            ->whereMonth('p.payment_date', Carbon::now()->month)
            ->whereYear('p.payment_date', Carbon::now()->year)
            ->sum('p.amount');
    }
    
        public static function sumPayment($email)
        {
            return DB::table('payments as p')
                ->join('Users as U', 'U.id', '=', 'p.partner_id')
                ->where('U.email', $email)
                ->sum('p.amount');
        }
    public static function getNumberCompletedReservation($email){
        return DB::table('users as U')
            ->join('reservations as R', 'R.partner_id', '=', 'U.id')
            ->where('U.email', $email)
            ->where('R.status', 'completed')
            ->count('R.id');
    }
    public static function getAverageRatingPartner($email)
    {
        $avgRating = DB::table('users as U')
        ->join('reviews as R', 'R.reviewee_id', '=', 'U.id')
        ->where('U.email', $email)
        ->where('R.type', 'forPartner')
        ->select(DB::raw('AVG(R.rating) as avg_rating'))
        ->value('avg_rating');

        return $avgRating ?? 5;
    }
    Public static function getCountRatingPartner($email){
        return DB::table('users as U')
            ->join('reviews as R', 'R.reviewee_id', '=', 'U.id')
            ->where('U.email', $email)
            ->where('R.type', 'forPartner')
            ->select(DB::raw('Count(R.rating) as review_count'))
            ->value('review_count');
        
    }
    public static function countListingsByEmail($email)
    {
        return DB::table('users as U')
            ->join('items as i','i.partner_id','=','U.id')
            ->join('listings as L', 'L.item_id', '=', 'i.id')
            ->where('U.email', $email)
            ->count('L.id');
    }
    public static function countActiveListingsByEmail($email)
    {
        return DB::table('users as U')
            ->join('items as i','i.partner_id','=','U.id')
            ->join('listings as L', 'L.item_id', '=', 'i.id')
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
        ->join('items as i','i.partner_id','=','U.id')
        ->where('U.email',$email)
        ->count('i.id');
    }

    public static function getPendingReservationsWithMontantTotal($email)
    {
        return DB::table('users as U')
            ->join('reservations as R', 'R.partner_id', '=', 'U.id')
            ->join('listings as L', 'L.id', '=', 'R.listing_id')
            ->join('items as i','i.id','=','L.item_id')
            ->join('users as C', 'C.id', '=', 'R.client_id')
            ->select(
                'C.username',
                'i.title',
                'R.start_date',
                'R.end_date',
                'R.created_at',
                'R.id',
                DB::raw('DATEDIFF(R.end_date, R.start_date) * i.price_per_day AS montant_total'),
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
            ->join('items as i','i.id','=','L.item_id')
            ->join('users as C', 'C.id', '=', 'R.client_id')
            ->select(
                'C.username',
                'i.title',
                'R.start_date',
                'R.end_date',
                'R.created_at',
                DB::raw('DATEDIFF(R.end_date, R.start_date) * i.price_per_day AS montant_total')
            )
            ->where('U.email', $email)
            ->where('R.status', 'pending')
            ->get();
    }
    public static function getRecentPartnerListingsWithImagesByEmail($email)
    {
        return DB::table('users as U')
            ->join('items as m', 'm.partner_id', '=', 'U.id')
            ->join('listings as L', 'L.item_id', '=', 'm.id')
            ->leftJoin('images as i', 'i.item_id', '=', 'm.id')
            ->join('categories as c','c.id','m.category_id')
            ->where('U.email', $email)
            ->select('m.title', 'm.description', 'm.price_per_day', 'i.url', 'L.status','c.name')
            ->orderBy('L.created_at', 'desc')
            ->limit(3)
            ->get();
    }

    public static function getPartenerDemandeReservation($email){
        return DB::table('users as U')
            ->join('reservations as R', 'R.partner_id', '=', 'U.id')
            ->join('listings as L', 'L.id', '=', 'R.listing_id')
            ->join('items as i','i.id','=','L.item_id')
            ->join('users as C', 'C.id', '=', 'R.client_id')
            ->select(
                'R.id',
                'C.username',
                'i.title',
                'R.start_date',
                'R.end_date',
                'C.avatar_url',
                'R.created_at',
                'R.status',
                'i.price_per_day',
                DB::raw('DATEDIFF(R.end_date, R.start_date) * i.price_per_day AS montant_total'),
                DB::raw('DATEDIFF(R.end_date, R.start_date) AS number_days')

            )
            ->where('U.email', $email)
            ->paginate(5);

    }
    public static function getPartenerEquipement($email)
    {
        $items = DB::table('users as U')
            ->join('items as i','i.partner_id','=','U.id')
            ->join('categories as C', 'C.id', '=', 'i.category_id')
            ->leftJoin('images as img', 'img.item_id', '=', 'i.id')
            ->leftJoin('reviews as R', function($join) {
                $join->on('R.reviewee_id', '=', 'i.id')
                    ->where('R.type', '=', 'forObject')
                    ->where('R.is_visible', '=', true);
            })
            ->select(
                'i.id',
                'i.title',
                'i.description',
                'i.price_per_day',
                'i.category_id',
                'C.name as category_name',
                DB::raw('GROUP_CONCAT(DISTINCT img.url) as image_urls'),
                DB::raw('AVG(R.rating) as avg_rating'),
                DB::raw('COUNT(DISTINCT R.id) as review_count')
            )
            ->where('U.email', $email)
            ->groupBy('i.id', 'i.title', 'i.description', 'i.price_per_day', 'i.category_id', 'C.name')
            ->get();

        return $items->map(function($item) {
            $imageUrls = $item->image_urls ? explode(',', $item->image_urls) : [];
            $item->images = collect($imageUrls)->map(function($url) {
                return (object)['url' => $url];
            });
            $item->avg_rating = $item->avg_rating ?? 0;
            $item->review_count = $item->review_count ?? 0;
            return $item;
        });
    }
    public static function getLocationsEncours($email)
    {
        return DB::table('users as U')
        ->join('reservations as R', 'R.partner_id', '=', 'U.id')
        ->join('listings as L', 'L.id', '=', 'R.listing_id')
        ->join('items as i','i.id','=','L.item_id')
        ->join('users as C', 'C.id', '=', 'R.client_id')
        ->select(
            'C.username',
            'i.title',
            'R.start_date',
            'R.end_date',
            'C.avatar_url',
            'R.created_at',
            'i.price_per_day',
            DB::raw('DATEDIFF(R.end_date, R.start_date) * i.price_per_day AS montant_total'),
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

    /////////////////////////////////////////les avis
    public static function getAvis($email) {
        return DB::table('reviews as r')
            ->join('users as u', 'u.id', '=', 'r.reviewee_id')
            ->join('users as c', 'c.id', '=', 'r.reviewer_id')
            ->where('u.email', $email)
            ->whereIn('r.type', ['forObject', 'forPartner'])
            ->leftJoin('items as i', function($join) {
                $join->on('i.id', '=', 'r.reviewee_id')
                     ->where('r.type', '=', 'forObject');  
            })
            
            ->select('r.rating','r.comment','c.username' ,'c.avatar_url',
                    DB::raw('DATE(r.created_at) as created_at'),
                     DB::raw('CASE WHEN r.type = "forObject" THEN i.title ELSE NULL END as object_title'))  // Conditional logic to fetch title
            ->get();
    }

    public static function getLastAvisPartnerForObject($email){
        return DB::table('reviews as r')
        ->join('users as u', 'u.id', '=', 'r.reviewee_id')
        ->join('users as c', 'c.id', '=', 'r.reviewer_id')
        ->where('u.email', $email)
        ->where('r.type','forObject')
        ->leftJoin('items as i', function($join) {
            $join->on('i.id', '=', 'r.reviewee_id')
                 ->where('r.type', '=', 'forObject');  
        })
        
        ->select('r.rating','r.comment','c.username' ,'c.avatar_url',
                DB::raw('DATE(r.created_at) as created_at'),
                 DB::raw('CASE WHEN r.type = "forObject" THEN i.title ELSE NULL END as object_title'))
        ->orderby('created_at', 'desc')
        ->limit(3)       
        ->get();
    }
    public static function getCities(){
        return DB::table('cities as c')
        ->select('c.name','c.id')  
        ->get();
    }

    public static function getPartenaireProfile($email)
    {
        return DB::table('users as u')
            ->join('reviews as r', 'r.reviewee_id', '=', 'u.id')
            ->join('cities as c','c.id','=','u.city_id')
            ->where('u.email', $email)
            ->select(
                'u.first_name',
                'u.last_name',
                'u.username',
                'u.email',
                'u.phone_number',
                'u.address',
                'u.avatar_url',
                'u.created_at',
                'c.name as city_name',
                DB::raw("COALESCE(SUM(CASE WHEN r.type = 'forPartner' THEN 1 ELSE 0 END), 0) as review_count"),
                DB::raw("
                COALESCE(NULLIF(AVG(CASE WHEN r.type = 'forPartner' THEN r.rating ELSE NULL END), 0), 5)
                as avg_rating
            ") 
            )
            ->groupBy(
                'u.id',
                'u.first_name',
                'u.last_name',
                'u.username',
                'u.email',
                'u.phone_number',
                'u.address',
                'u.avatar_url',
                'u.created_at',
                'c.name',
            )
            ->first();
    }

    public static function updaterole($email)
    {
        return DB::table('users')
        ->where('email', $email)
        ->update(['role' => 'partner']);
    }


}

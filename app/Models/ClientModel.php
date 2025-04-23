<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ClientModel extends Model
{

    public static function totalReservationsByEmail($email)
    {
        return DB::table('users')
            ->leftJoin('reservations', 'users.id', '=', 'reservations.client_id')
            ->where('users.email', $email)
            ->selectRaw('COUNT(reservations.id) as total_reservations')
            ->groupBy('users.id', 'users.username')
            ->value('total_reservations');
    }


    public static function totalDepenseByEmail($email)
    {
        return DB::table('users')
            ->leftJoin('reservations', 'users.id', '=', 'reservations.client_id')
            ->leftJoin('listings', 'reservations.listing_id', '=', 'listings.id')
            ->leftJoin('payments', 'payments.listing_id', '=', 'listings.id')
            ->where('users.email', $email)
            ->where('payments.status', 'completed')
            ->select( DB::raw('COALESCE(SUM(payments.amount), 0) AS total_depense'))
            ->value('total_depense'); 
    }

    public  static function  noteMoyenneByEmail($email)
    {
        return DB::table('users')
            ->leftJoin('reservations', 'users.id', '=', 'reservations.client_id')
            ->leftJoin('reviews', 'reservations.id', '=', 'reviews.reservation_id')
            ->where('users.email', $email)
            ->select(DB::raw('ROUND(AVG(reviews.rating), 2) AS note_moyenne'))
            ->value('note_moyenne'); 
    }

    public static function getReservationDetailsByEmail($email)
    {
        return DB::table('users')
            ->leftJoin('reservations', 'users.id', '=', 'reservations.client_id')
            ->leftJoin('listings', 'reservations.listing_id', '=', 'listings.id')
            ->leftJoin('payments', function($join) {
                $join->on('payments.listing_id', '=', 'listings.id')
                     ->where('payments.status', '=', 'completed');
            })
            ->leftJoin('users as partener', 'listings.partner_id', '=', 'partener.id')
            ->leftJoin('images', 'listings.id', '=', 'images.listing_id')
    
            ->where('users.email', $email)
            ->limit(2)
            ->select(
                'partener.username AS partener_username',
                'partener.avatar_url AS partener_img',
                'partener.avg_rating as partener_avg_rating',
                DB::raw('MIN(images.url) AS image_url'),
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'listings.title AS listing_title',
                DB::raw('COALESCE(SUM(payments.amount), 0) AS montant_paye'),
                'listings.description'
            )
            ->groupBy(
                'users.id',
                'users.username',
                'users.email',
                'reservations.id',
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'listings.id',
                'listings.title',
                'listings.description',
                'partener.username',
                'partener.avg_rating',
                'partener_img'
            )
            ->orderBy('users.id')
            ->orderBy('reservations.start_date')
            ->get();
    }
    
    public static function getAllReservationDetailsByEmail($email)
    {
        return DB::table('users')
            ->leftJoin('reservations', 'users.id', '=', 'reservations.client_id')
            ->leftJoin('listings', 'reservations.listing_id', '=', 'listings.id')
            ->leftJoin('payments', function($join) {
                $join->on('payments.listing_id', '=', 'listings.id')
                     ->where('payments.status', '=', 'completed');
            })
            ->leftJoin('users as partener', 'listings.partner_id', '=', 'partener.id')
            ->leftJoin('images', 'listings.id', '=', 'images.listing_id')
    
            ->where('users.email', $email)
            ->select(
                'partener.username AS partener_username',
                'partener.avatar_url AS partener_img',
                'partener.avg_rating as partener_avg_rating',
                DB::raw('MIN(images.url) AS image_url'),
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'listings.title AS listing_title',
                DB::raw('COALESCE(SUM(payments.amount), 0) AS montant_paye'),
                'listings.description'
            )
            ->groupBy(
                'users.id',
                'users.username',
                'users.email',
                'reservations.id',
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'listings.id',
                'listings.title',
                'listings.description',
                'partener.username',
                'partener.avg_rating',
                'partener_img'
            )
            ->orderBy('users.id')
            ->orderBy('reservations.start_date')
            ->get();
    }
    
    public static function getClientReviewsWithTargets($email)
    {
        return DB::table('users as u')
            ->join('reservations as r', 'u.id', '=', 'r.client_id')
            ->join('reviews as rv', 'rv.reservation_id', '=', 'r.id')
            ->join('listings as l', 'r.listing_id', '=', 'l.id')
            ->leftJoin('users as p', 'l.partner_id', '=', 'p.id')
            ->leftJoin(DB::raw('(
                SELECT listing_id, MIN(url) as image_url
                FROM images
                GROUP BY listing_id
            ) as img'), 'l.id', '=', 'img.listing_id')
            ->where('u.email', $email)
            ->where('rv.type', '!=', 'forClient') 

            ->orderByDesc('rv.created_at')
            ->select(
                'rv.comment',
                'rv.rating',
                'rv.created_at',
                'rv.type',
                DB::raw("CASE 
                            WHEN rv.type = 'forObject' THEN l.title 
                            WHEN rv.type = 'forPartner' THEN p.username 
                            ELSE NULL 
                        END AS cible_commentaire"),
                DB::raw("CASE 
                            WHEN rv.type = 'forObject' THEN img.image_url
                            WHEN rv.type = 'forPartner' THEN p.avatar_url 
                            ELSE NULL 
                        END AS image_cible")
            )
            
            ->get();
    }
    
    
    

    public static function getSimilarListingsByCategory($email)
    {
        return DB::table('users as u')
            ->join('reservations as r', 'u.id', '=', 'r.client_id')
            ->join('listings as l', 'r.listing_id', '=', 'l.id')
            ->join('cities as i', 'l.city_id', '=', 'i.id')
            ->join('categories as c', 'l.category_id', '=', 'c.id')
            ->join('listings as ls', function ($join) {
                $join->on('ls.category_id', '=', 'c.id')
                    ->whereRaw('ls.id != l.id');
            })
            ->leftJoin('images', 'ls.id', '=', 'images.listing_id') // fixed alias
    
            ->where('u.email', $email)
            ->limit(3)
            ->select(
                DB::raw('MIN(images.url) AS image_url'),
                'ls.price_per_day',
                'c.name as category_name',
                'ls.title as listing_title',
                'i.name as city_name'
            )
            ->groupBy('ls.id', 'ls.price_per_day', 'c.name', 'ls.title', 'i.name')
            ->get();
    }
    
    public static function getAllSimilarListingsByCategory($email)
    {
        return DB::table('users as u')
            ->join('reservations as r', 'u.id', '=', 'r.client_id')
            ->join('listings as l', 'r.listing_id', '=', 'l.id')
            ->join('cities as i', 'l.city_id', '=', 'i.id')
            ->join('categories as c', 'l.category_id', '=', 'c.id')
            ->join('listings as ls', function ($join) {
                $join->on('ls.category_id', '=', 'c.id')
                    ->whereRaw('ls.id != l.id');
            })
            ->leftJoin('images', 'ls.id', '=', 'images.listing_id') // fixed alias
    
            ->where('u.email', $email)
            ->select(
                DB::raw('MIN(images.url) AS image_url'),
                'ls.price_per_day',
                'c.name as category_name',
                'ls.title as listing_title',
                'i.name as city_name'
            )
            ->groupBy('ls.id', 'ls.price_per_day', 'c.name', 'ls.title', 'i.name')
            ->get();
    }

    public static function getClientProfile($email)
    {
        return DB::table('users')
            ->where('email', $email)
            ->where('role', 'client')
            ->select(
                'username',
                'email',
                'phone_number',
                'address',
                'avatar_url',
                'avg_rating',
                'review_count',
                'created_at'
            )
            ->first();
    }



}

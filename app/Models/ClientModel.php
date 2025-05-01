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
            ->leftJoin('items', 'listings.item_id', '=', 'items.id') 
            ->leftJoin('payments', function($join) {
                $join->on('payments.listing_id', '=', 'listings.id')
                     ->where('payments.status', '=', 'completed');
            })
            ->leftJoin('users as partner', 'items.partner_id', '=', 'partner.id')
            ->leftJoin('images', 'items.id', '=', 'images.item_id') 
            
            ->where('users.email', $email)
            ->limit(2)
            ->select(
                'reservations.id',
                'partner.username AS partner_username',
                'partner.avatar_url AS partner_img',
                'partner.avg_rating as partner_avg_rating',
                DB::raw('MIN(images.url) AS image_url'),
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'items.title AS listing_title', 
                DB::raw('COALESCE(SUM(payments.amount), 0) AS montant_paye'),
                'items.description' 
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
                'items.id', 
                'items.title',
                'items.description',
                'partner.username',
                'partner.avg_rating',
                'partner_img'
            )
            ->orderBy('users.id')
            ->orderBy('reservations.start_date')
            ->get();
    }
   
    public static function getAllReservationDetailsByEmail($email, $status = null)
    {
        $query = DB::table('users')
            ->leftJoin('reservations', 'users.id', '=', 'reservations.client_id')
            ->leftJoin('listings', 'reservations.listing_id', '=', 'listings.id')
            ->leftJoin('items', 'listings.item_id', '=', 'items.id')
            ->leftJoin('payments', function($join) {
                $join->on('payments.listing_id', '=', 'listings.id')
                    ->where('payments.status', '=', 'completed');
            })
            ->leftJoin('users as partner', 'items.partner_id', '=', 'partner.id')
            ->leftJoin('images', 'items.id', '=', 'images.item_id')
            ->where('users.email', $email);

        if ($status && $status !== 'all') {
            $query->where('reservations.status', $status);
        }

        return $query->select(
                'reservations.id',
                'partner.username AS partner_username',
                'partner.avatar_url AS partner_img',
                'partner.avg_rating as partner_avg_rating',
                DB::raw('MIN(images.url) AS image_url'),
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'items.title AS listing_title',
                DB::raw('COALESCE(SUM(payments.amount), 0) AS montant_paye'),
                'items.description'
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
                'items.id', 
                'items.title',
                'items.description',
                'partner.username',
                'partner.avg_rating',
                'partner_img'        )
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
            ->join('items as i', 'l.item_id', '=', 'i.id') 
            ->leftJoin('users as p', 'i.partner_id', '=', 'p.id') 
            ->leftJoin(DB::raw('(
                SELECT item_id, MIN(url) as image_url
                FROM images
                GROUP BY item_id
            ) as img'), 'i.id', '=', 'img.item_id') 
            ->where('u.email', $email)
            ->where('rv.type', '!=', 'forClient')
            ->orderByDesc('rv.created_at')
            ->select(
                'rv.comment',
                'rv.rating',
                'rv.created_at',
                'rv.type',
                DB::raw("CASE 
                            WHEN rv.type = 'forObject' THEN i.title 
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
            ->join('items as li', 'l.item_id', '=', 'li.id') 
            ->join('cities as i', 'l.city_id', '=', 'i.id')
            ->join('categories as c', 'li.category_id', '=', 'c.id') 
            ->join('items as similar_items', function($join) {
                $join->on('similar_items.category_id', '=', 'c.id')
                    ->whereRaw('similar_items.id != li.id'); 
            })
            ->join('listings as ls', 'similar_items.id', '=', 'ls.item_id') 
            ->leftJoin('images', 'similar_items.id', '=', 'images.item_id') 
            
            ->where('u.email', $email)
            ->where('ls.status', 'active') 
            ->limit(3)
            ->select(
                DB::raw('MIN(images.url) AS image_url'),
                'similar_items.price_per_day', 
                'c.name as category_name',
                'similar_items.title as listing_title',
                'i.name as city_name'
            )
            ->groupBy(
                'ls.id', 
                'similar_items.price_per_day', 
                'c.name', 
                'similar_items.title', 
                'i.name'
            )
            ->get();
    }
    
    public static function getAllSimilarListingsByCategory($email)
    {
        return DB::table('users as u')
            ->join('reservations as r', 'u.id', '=', 'r.client_id')
            ->join('listings as l', 'r.listing_id', '=', 'l.id')
            ->join('items as li', 'l.item_id', '=', 'li.id')
            ->join('cities as i', 'l.city_id', '=', 'i.id')
            ->join('categories as c', 'li.category_id', '=', 'c.id') 
            ->join('items as similar_items', function($join) {
                $join->on('similar_items.category_id', '=', 'c.id')
                    ->whereRaw('similar_items.id != li.id'); 
            })
            ->join('listings as ls', 'similar_items.id', '=', 'ls.item_id') 
            ->leftJoin('images', 'similar_items.id', '=', 'images.item_id') 
            
            ->where('u.email', $email)
            ->where('ls.status', 'active') 
            ->select(
                DB::raw('MIN(images.url) AS image_url'),
                'similar_items.price_per_day', 
                'c.name as category_name',
                'similar_items.title as listing_title', 
                'i.name as city_name'
            )
            ->groupBy(
                'ls.id', 
                'similar_items.price_per_day', 
                'c.name', 
                'similar_items.title', 
                'i.name'
            )
            ->get();
    }

    public static function getClientProfile($email)
    {
       
        return DB::table('users as u')
        ->leftJoin('reviews as r', function($join) {
            $join->on('r.reviewee_id', '=', 'u.id')
                ->where('r.type', 'forClient');
        })
        ->where('u.email', $email)
        ->where('u.role', 'client')
        ->select(
            'u.first_name',
            'u.last_name',
            'u.username',
            'u.email',
            'u.phone_number',
            'u.address',
            'u.avatar_url',
            'u.avg_rating',
            'u.created_at',
            DB::raw('COUNT(r.id) as review_count')
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
            'u.avg_rating',
            'u.created_at'
        )
        ->first();
    }



}

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
        return DB::table('users as u')
            ->leftJoin('reviews as r', 'r.reviewee_id', '=', 'u.id')
            ->where('u.email', $email)
            ->where('r.type', 'forClient')
            ->select(DB::raw('ROUND(AVG(r.rating), 2) AS note_moyenne'))
            ->value('note_moyenne'); 
    }

    public static function getReservationDetailsByEmail($email, $status = null)
    {
        $query = DB::table('users')
            ->join('reservations', 'users.id', '=', 'reservations.client_id')
            ->leftJoin('listings', 'reservations.listing_id', '=', 'listings.id')
            ->leftJoin('items', 'listings.item_id', '=', 'items.id')
            ->leftJoin('payments', function($join) {
                $join->on('payments.listing_id', '=', 'listings.id')
                    ->where('payments.status', '=', 'completed');
            })
            ->leftJoin('users as partner', 'items.partner_id', '=', 'partner.id')
            ->leftJoin('images', 'items.id', '=', 'images.item_id')
            ->leftJoin('reviews as partner_reviews', function($join) {
                $join->on('partner_reviews.reviewee_id', '=', 'partner.id')
                    ->where('partner_reviews.type', '=', 'forPartner');
            })
            ->where('users.email', $email)
            ->limit(2);

        if ($status && $status !== 'all') {
            $query->where('reservations.status', $status);
        }
    
        return $query->select(
                'reservations.id',
                'partner.username AS partner_username',
                'partner.avatar_url AS partner_img',
                DB::raw("ROUND(AVG(partner_reviews.rating), 1) as partner_avg_rating"), // Rounded to 1 decimal
                DB::raw('MIN(images.url) AS image_url'),
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'items.title AS listing_title',
                DB::raw('COALESCE(SUM(payments.amount), 0) AS montant_paye'),
                'items.description'
            )
            ->groupBy(
                'reservations.id',
                'partner.username',
                'partner.avatar_url',
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'items.title',
                'items.description'
            )
            ->orderBy('reservations.start_date', 'desc')
            ->get();
    }
   
    public static function getAllReservationDetailsByEmail($email, $status = null)
    {
        $query = DB::table('users')
            ->join('reservations', 'users.id', '=', 'reservations.client_id')
            ->leftJoin('listings', 'reservations.listing_id', '=', 'listings.id')
            ->leftJoin('items', 'listings.item_id', '=', 'items.id')
            ->leftJoin('payments', function($join) {
                $join->on('payments.listing_id', '=', 'listings.id')
                    ->where('payments.status', '=', 'completed');
            })
            ->leftJoin('users as partner', 'items.partner_id', '=', 'partner.id')
            ->leftJoin('images', 'items.id', '=', 'images.item_id')
            // Join reviews for partner ratings
            ->leftJoin('reviews as partner_reviews', function($join) {
                $join->on('partner_reviews.reviewee_id', '=', 'partner.id')
                    ->where('partner_reviews.type', '=', 'forPartner');
            })
            ->where('users.email', $email);
    
        if ($status && $status !== 'all') {
            $query->where('reservations.status', $status);
        }
    
        return $query->select(
                'reservations.id',
                'partner.username AS partner_username',
                'partner.avatar_url AS partner_img',
                DB::raw("ROUND(AVG(partner_reviews.rating), 1) as partner_avg_rating"), // Rounded to 1 decimal
                DB::raw('MIN(images.url) AS image_url'),
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'items.title AS listing_title',
                DB::raw('COALESCE(SUM(payments.amount), 0) AS montant_paye'),
                'items.description'
            )
            ->groupBy(
                'reservations.id',
                'partner.username',
                'partner.avatar_url',
                'reservations.start_date',
                'reservations.end_date',
                'reservations.status',
                'items.title',
                'items.description'
            )
            ->orderBy('reservations.start_date', 'desc')
            ->get();
    }



    public static function getReviewsAboutMe($email)
    {
        return DB::table('users as reviewee') // The user being reviewed (you)
            ->join('reviews as rv', 'reviewee.id', '=', 'rv.reviewee_id')
            ->join('reservations as r', 'rv.reservation_id', '=', 'r.id')
            ->join('users as reviewer', 'rv.reviewer_id', '=', 'reviewer.id') // The user who wrote the review
            ->leftJoin('listings as l', 'r.listing_id', '=', 'l.id')
            ->leftJoin('items as i', 'l.item_id', '=', 'i.id')
            ->leftJoin(DB::raw('(
                SELECT item_id, MIN(url) as image_url
                FROM images
                GROUP BY item_id
            ) as img'), 'i.id', '=', 'img.item_id')
            ->where('reviewee.email', $email) // Filter for reviews about you
            ->where('rv.type', 'forClient') 
            ->orderByDesc('rv.created_at')
            ->select(
                'rv.comment',
                'rv.rating',
                'rv.created_at',
                'rv.type',
                'reviewer.username as reviewer_name', // The person who wrote the review
                'reviewer.id as reviewer_id',
                'reviewer.avatar_url as reviewer_avatar', // Their avatar
                'reviewee.username as reviewee_name', // You (for reference if needed)
                DB::raw("CASE 
                            WHEN rv.type = 'forClient' THEN i.title 
                            ELSE NULL 
                        END AS item_title"),
                DB::raw("CASE 
                            WHEN rv.type = 'forClient' THEN img.image_url
                            ELSE NULL 
                        END AS item_image")
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
            ->leftJoin('reviews as item_reviews', function($join) {
                $join->on('item_reviews.item_id', '=', 'similar_items.id')
                    ->where('item_reviews.type', 'forObject');
            })
            ->where('u.email', $email)
            ->where('ls.status', 'active')
            ->limit(3)
            ->select(
                DB::raw('MIN(images.url) AS image_url'),
                'similar_items.price_per_day',
                'c.name as category_name',
                'similar_items.title as listing_title',
                'i.name as city_name',
                'ls.start_date',
                'ls.end_date',
                'ls.is_premium',  // Add this to identify premium listings
                DB::raw('ROUND(AVG(item_reviews.rating), 1) as avg_rating'),
                DB::raw('COUNT(item_reviews.id) as review_count')
            )
            ->groupBy(
                'ls.id',
                'similar_items.price_per_day',
                'c.name',
                'similar_items.title',
                'i.name',
                'ls.start_date',
                'ls.end_date',
                'ls.is_premium'
            )
            ->orderBy('ls.is_premium', 'desc')  // Premium listings first
            ->orderBy('avg_rating', 'desc')     // Then by highest rating
            ->orderBy('ls.start_date', 'asc')    // Then by availability
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
            ->leftJoin(DB::raw('(
                SELECT item_id, url 
                FROM images 
                WHERE id IN (
                    SELECT MIN(id) 
                    FROM images 
                    GROUP BY item_id
                )
            ) as images'), 'similar_items.id', '=', 'images.item_id')
            ->leftJoin('reviews as item_reviews', function($join) {
                $join->on('item_reviews.item_id', '=', 'similar_items.id')
                    ->where('item_reviews.type', 'forObject');
            })
            ->where('u.email', $email)
            ->where('ls.status', 'active')
            ->select(
                'images.url AS image_url',
                'similar_items.price_per_day',
                'c.name as category_name',
                'similar_items.title as listing_title',
                'i.name as city_name',
                'ls.start_date',
                'ls.id as lis_id',
                'ls.end_date',
                'ls.is_premium',  // Add this to identify premium listings
                DB::raw('ROUND(AVG(item_reviews.rating), 1) as avg_rating'),
                DB::raw('COUNT(item_reviews.id) as review_count')
            )
            ->groupBy(
                'ls.id',
                'similar_items.price_per_day',
                'c.name',
                'similar_items.title',
                'i.name',
                'ls.start_date',
                'ls.end_date',
                'ls.is_premium',
                'images.url'
            )
            ->orderBy('ls.is_premium', 'desc')  // Premium listings first
            ->orderBy('avg_rating', 'desc')     // Then by highest rating
            ->orderBy('ls.start_date', 'asc')    // Then by availability
            ->take(41)
            ->get();
    }

    public static function getClientProfile($email)
    {
       
        return DB::table('users as u')
        ->leftJoin('reviews as r', function($join) {
            $join->on('r.reviewee_id', '=', 'u.id')
                ->where('r.type', 'forClient');
        })
        ->join('cities as c','c.id','=','u.city_id')
        ->where('u.email', $email)
        ->select(
            'u.first_name',
            'u.last_name',
            'u.username',
            'u.email',
            'u.phone_number',
            'u.password',
            'u.address',
            'u.avatar_url',
            'u.is_subscriber',
            'c.name as city_name',
            DB::raw('AVG(r.rating) as avg_rating'),
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
            'u.created_at',
            'u.password',
            'u.is_subscriber',
            'city_name'
        )
        ->first();
    }



}

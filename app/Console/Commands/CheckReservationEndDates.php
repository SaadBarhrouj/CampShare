<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Models\Notification;

class CheckReservationEndDates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reservations:check-end-dates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create notifications for reservations that have reached their end date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = now()->format('Y-m-d');
        
        $reservations = Reservation::whereDate('end_date', $today)
            ->get();
        
        foreach ($reservations as $reservation) {
            Notification::create([
                'type' => 'review_client',
                'user_id' => $reservation->partner_id,
                'message' => "Reservation #{$reservation->id} has ended. Please return equipment.",
                'is_read' => 0
            ]);
            Notification::create([
                'type' => 'review_partner',
                'user_id' => $reservation->client_id,
                'message' => "Reservation #{$reservation->id} has ended. Please return equipment.",
                'is_read' => 0
            ]);
        }
        
        $this->info("Created notifications for " . count($reservations) . " reservations.");
    }
        
}


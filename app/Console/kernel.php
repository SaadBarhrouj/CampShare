<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\ReviewNotification;
use App\Console\Commands\UpdateReviewVisibility;
use App\Console\Commands\UpdatePremiumStatus;
use App\Console\Commands\UpdateReservationStatus;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ReviewNotification::class,
        UpdateReviewVisibility::class,
        UpdatePremiumStatus::class,
        UpdateReservationStatus::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        $schedule->command(UpdateReservationStatus::class)
                 ->dailyAt('01:00')
                 ->timezone('Africa/Casablanca')
                 ->withoutOverlapping(10)
                 ->onSuccess(fn() => Log::info('Scheduled task UpdateReservationStatus completed successfully.'))
                 ->onFailure(fn() => Log::error('Scheduled task UpdateReservationStatus failed.'));

        $schedule->command(ReviewNotification::class)
                 ->daily()
                 ->at('02:00')
                 ->timezone('Africa/Casablanca')
                 ->withoutOverlapping(10)
                 ->onSuccess(fn() => Log::info('Scheduled task ReviewNotification completed successfully.'))
                 ->onFailure(fn() => Log::error('Scheduled task ReviewNotification failed.'));

        $schedule->command(UpdateReviewVisibility::class)
                 ->daily()
                 ->at('03:00')
                 ->timezone('Africa/Casablanca')
                 ->withoutOverlapping(10)
                 ->onSuccess(fn() => Log::info('Scheduled task UpdateReviewVisibility completed successfully.'))
                 ->onFailure(fn() => Log::error('Scheduled task UpdateReviewVisibility failed.'));

        $schedule->command(UpdatePremiumStatus::class)
                 ->dailyAt('00:30')
                 ->timezone('Africa/Casablanca')
                 ->withoutOverlapping(10)
                 ->onSuccess(fn() => Log::info('Scheduled task UpdatePremiumStatus completed successfully.'))
                 ->onFailure(fn() => Log::error('Scheduled task UpdatePremiumStatus failed.'));
    }

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
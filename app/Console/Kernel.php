<?php

namespace App\Console;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {

            $now = Carbon::now();
            $products = Product::all();

            foreach ($products as $product) {
                $item = Product::find($product->id);
                $timeDiff = $now->diffInSeconds($item->created_at);
                if ($timeDiff > 30 && $timeDiff < 60) {
                    $item->status = 'Drilling';
                } elseif ($timeDiff > 61 && $timeDiff < 120) {
                    $item->status = 'Cutting';
                } elseif ($timeDiff > 121) {
                    $item->status = 'Storage';
                }

                $item->save();
            }
        })->everySecond();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

<?php

namespace App\Jobs;

use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RemoveExpiredCarts implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Define the time threshold (24 hours ago)
        $threshold = Carbon::now()->subHours(24);

        // Find and delete carts with pending status created more than 24 hours ago
        Cart::where('status', Cart::STATUS['pending'])
            ->where('created_at', '<', $threshold)
            ->delete();
    }
}

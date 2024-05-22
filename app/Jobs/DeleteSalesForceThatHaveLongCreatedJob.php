<?php

namespace App\Jobs;

use App\Models\SalesPeople;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteSalesForceThatHaveLongCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fourHoursAgo = now()->subHours(1);
        SalesPeople::whereIsBusy(false)
            ->whereHired(false)
            ->where('created_at', '>=', $fourHoursAgo)
            ->delete();
    }
}

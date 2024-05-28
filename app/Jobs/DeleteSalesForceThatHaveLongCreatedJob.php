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
        $tenMinutesAgo = now()->subMinutes(5);
        $salesforce = SalesPeople::whereIsBusy(false)
        ->whereHired(false)
        ->where('created_at', '<=', $tenMinutesAgo)
        ->get();
        $salesforce->each(function($vendor) {
            $vendor->games()->detach();
        });
        $salesforce->each->delete();
    }
}

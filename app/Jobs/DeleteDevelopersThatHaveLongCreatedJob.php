<?php

namespace App\Jobs;

use App\Models\Developer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteDevelopersThatHaveLongCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fourHoursAgo = now()->subHours(1);
        Developer::whereIsBusy(false)
            ->whereHired(false)
            ->where('created_at', '>=', $fourHoursAgo)
            ->delete();
    }
}

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
        $tenMinutesAgo = now()->subMinutes(5);
        $developers = Developer::whereIsBusy(false)
        ->whereHired(false)
        ->where('created_at', '<=', $tenMinutesAgo)
        ->get();
        $developers->each(function($developer) {
            $developer->games()->detach();
        });
        $developers->each->delete();
    }
}

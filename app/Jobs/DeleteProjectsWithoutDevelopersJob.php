<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteProjectsWithoutDevelopersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $oneHourFromEndTime = now()->subHours(1);

        Project::whereNull('developer_id')
            ->whereNull('sales_people_id')
            ->where('end_date', '>=', $oneHourFromEndTime)
            ->delete();
    }
}

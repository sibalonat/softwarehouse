<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StreamlineFinancialInfoBetweenPartiesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Fetch all projects that have both sales_people_id and developer_id
        $projects = Project::whereNotNull(['sales_people_id', 'developer_id'])->get();

        foreach ($projects as $project) {
            // Decrement the run count
            $project->run_count--;

            // On the last run, mark the project as finished
            if ($project->run_count === 0 || $project->run_count < 0) {
                $project->game->balance += $project->value;
                $project->game->save();

                $project->is_completed = true;
                $project->end_date = now();
                $project->sales_people_id = null;
                $project->developer_id = null;
            }

            // Save the project
            $project->save();
        }
    }
}

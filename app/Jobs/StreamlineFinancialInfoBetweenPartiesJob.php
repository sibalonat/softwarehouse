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
            // Determine the percentage based on the run count
            $percentage = $this->getPercentage($project->run_count);

            // Add the percentage of the project's value to the game's balance
            $project->game->balance += $project->value * $percentage;

            $project->game->save();

            // Deduct the appropriate costs from the developer and sales person
            $project->game->balance -= $project->developer->cost;
            $project->game->balance -= $project->salesperson->cost;

            // Increment the run count
            $project->run_count++;

            // On the third run, mark the project as finished
            if ($project->run_count === 3) {
                $project->is_completed = true;
                $project->sales_people_id = null;
                $project->developer_id = null;
            }

            // Save the project
            $project->save();
        }
    }

    /**
     * Get the percentage based on the run count.
     *
     * @param  int  $runCount
     * @return float
     */
    protected function getPercentage(int $runCount): float
    {
        switch ($runCount) {
            case 0:
                return 0.3;  // 30%
            case 1:
                return 0.4;  // 40%
            case 2:
                return 0.3;  // 30%
            default:
                return 0;
        }
    }
}

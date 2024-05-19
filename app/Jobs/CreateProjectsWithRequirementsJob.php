<?php

namespace App\Jobs;

use App\Models\Game;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\ProjectComplexityAttribute;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class CreateProjectsWithRequirementsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::all(); // or any query to get the users you want

        foreach ($users as $user) {
            $game = $user->game;

            Log::info('Creating projects for game ' . $game->id);

            $randomSeconds = random_int(60, 4 * 60 * 60);

            // Get the current second of the hour
            $currentSecond = Carbon::now()->second + Carbon::now()->minute * 60;

            // Only run the job if the current second matches the random second
            if ($currentSecond % $randomSeconds !== 0) {
                continue;
            }

            $complexities = [
                'Low' => ['value' => 5000, 'minutes' => 8],
                'Medium' => ['value' => 8000, 'minutes' => 21],
                'High' => ['value' => 15000, 'minutes' => 55],
            ];

            $complexity = array_rand($complexities);
            $value = $complexities[$complexity]['value'];
            $minutes = $complexities[$complexity]['minutes'];

            $project = new Project([
                'name' => 'Project ' . Str::random(10),
                'description' => 'Description ' . Str::random(20),
                'end_date' => Carbon::now()->addMinutes($minutes),
                'game_id' => $game->id,
                'complexity' => $complexity,
                'value' => $value,
                'is_completed' => false,
            ]);

            $project->save();

            // Update the project as completed after the end_date
            if (Carbon::now()->greaterThanOrEqualTo($project->end_date)) {
                $project->is_completed = true;
                $project->save();
            }
        }
    }
}

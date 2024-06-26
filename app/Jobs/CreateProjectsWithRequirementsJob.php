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
use Faker\Factory as Faker;

class CreateProjectsWithRequirementsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // generate project name and description
        $faker = Faker::create();

        $users = User::all(); // or any query to get the users you want
        foreach ($users as $user) {
            $game = $user->game;

            $randomSeconds = random_int(1, 60);

            // Get the current second of the hour
            $currentSecond = Carbon::now()->second + Carbon::now()->minute * 60;

            // Only run the job if the current second matches the random second
            if ($currentSecond % $randomSeconds !== 0) {
                continue;
            }

            $complexities = [
                ProjectComplexityAttribute::Low,
                ProjectComplexityAttribute::Medium,
                ProjectComplexityAttribute::High,
            ];

            $complexity = $complexities[array_rand($complexities)];

            $value = $complexity->ProjectValue();
            $times_until_complition = $complexity->TimesToCompleteProject();

            $projectName = implode(' ', $faker->words(2));
            $projectDescription = implode(' ', $faker->words(3));

            $project = new Project([
                'name' => Str::ucfirst($projectName),
                'description' => Str::ucfirst($projectDescription),
                'run_count' => $times_until_complition,
                'end_date' => Carbon::now()->addMinutes(20),
                'game_id' => $game->id,
                'complexity' => $complexity->value,
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

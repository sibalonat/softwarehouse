<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Developer;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Enums\DeveloperSeniorityAttribute;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateDeveloperWithRequirementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $users = User::all(); // or any query to get the users you want

        foreach ($users as $user) {

            $randomSeconds = random_int(1, 60);

            // Get the current second of the hour
            $currentSecond = Carbon::now()->second + Carbon::now()->minute * 60;

            // Only run the job if the current second matches the random second
            if ($currentSecond % $randomSeconds !== 0) {
                continue;
            }

            $experiences = [
                DeveloperSeniorityAttribute::Junior->value => ['cost' => 800],
                DeveloperSeniorityAttribute::Middle->value => ['cost' => 1500],
                DeveloperSeniorityAttribute::Senior->value => ['cost' => 3000],
            ];

            $experience = array_rand($experiences);
            $value = $experiences[$experience]['cost'];

            $developer = new Developer([
                'name' => 'first_name ' . Str::random(10),
                'last_name' => 'last_name ' . Str::random(10),
                'seniority' => $experience,
                'cost' => $value,
            ]);

            $developer->save();
        }
    }
}
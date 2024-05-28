<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\SalesPeople;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Enums\SalesPersonExperienceAttribute;
use Faker\Factory as Faker;

class CreateSalesPeopleWithRequirementJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $faker = Faker::create();

        $users = User::all(); // or any query to get the users you want

        foreach ($users as $user) {

            $game = $user->load('game')->game;

            $randomSeconds = random_int(1, 60);

            // Get the current second of the hour
            $currentSecond = Carbon::now()->second + Carbon::now()->minute * 60;

            // Only run the job if the current second matches the random second
            if ($currentSecond % $randomSeconds !== 0) {
                continue;
            }

            $experiences = [
                SalesPersonExperienceAttribute::Beginner,
                SalesPersonExperienceAttribute::Intermediate,
                SalesPersonExperienceAttribute::Advanced,
            ];

            $experience = $experiences[array_rand($experiences)];
            $value = $experience->PersonelCost();

            $salesperson = new SalesPeople([
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'experience' => $experience->value,
                'cost' => $value,
            ]);

            $salesperson->save();

            $game->salespeople()->attach($salesperson->id);
        }
    }
}

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

            $randomSeconds = random_int(1, 60);

            // Get the current second of the hour
            $currentSecond = Carbon::now()->second + Carbon::now()->minute * 60;

            // Only run the job if the current second matches the random second
            if ($currentSecond % $randomSeconds !== 0) {
                continue;
            }

            $experiences = [
                SalesPersonExperienceAttribute::Beginner->value => ['cost' => 400],
                SalesPersonExperienceAttribute::Intermediate->value => ['cost' => 800],
                SalesPersonExperienceAttribute::Advanced->value => ['cost' => 1400],
            ];

            $experience = array_rand($experiences);
            $value = $experiences[$experience]['cost'];

            $salesperson = new SalesPeople([
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'experience' => $experience,
                'cost' => $value,
            ]);

            $salesperson->save();
        }
    }
}

<?php

namespace App;
use Faker\Factory as Faker;
use App\Enums\DeveloperSeniorityAttribute;
use App\Enums\SalesPersonExperienceAttribute;

trait CreatesInitialPersonnel
{
    // Create the first sales person for the user
    public function createFirstSalesPerson()
    {
        $faker = Faker::create();
        $experience = SalesPersonExperienceAttribute::Intermediate;
        $value = $experience->PersonelCost();
        $salesperson = [
            'name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'hired' => true,
            'experience' => $experience->value,
            'cost' => $value,
        ];

        return $salesperson;
    }

    // Create the first developer for the user
    public function createFirstDeveloper()
    {
        $faker = Faker::create();
        $experience = DeveloperSeniorityAttribute::Middle;
        $value = $experience->PersonelCost();

        $developer = [
            'name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'seniority' => $experience->value,
            'hired' => true,
            'cost' => $value,
        ];

        return $developer;
    }
}

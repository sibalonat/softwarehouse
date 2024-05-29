<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Developer;
use App\Models\SalesPeople;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use Illuminate\Support\Carbon;
use App\CreatesInitialPersonnel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Enums\ProjectComplexityAttribute;

class AuthEventIntervalController extends Controller
{
    use CreatesInitialPersonnel;
    public function getDataForUser(User $user)
    {
        $user->load('game');
        return response()->json([
            'game' => $user->game->only('id', 'name', 'user_id', 'balance'),
        ]);
    }

    public function gameOverFlash(User $user)
    {
        $game = $user->load('game')->game;
        if ($game->balance == 0 || $game->balance < 0) {
            return response()->json([
                'message' => 'You reached the balance 0. Game over!',
            ]);
        }
    }


    public function restartGame() : RedirectResponse
    {
        // delete previous resources
        $developers = Developer::get();
        $developers->each(function($developer) {
            $developer->games()->detach();
        });

        Project::query()->delete();

        $salesforce = SalesPeople::get();
        $salesforce->each(function($vendor) {
            $vendor->games()->detach();
        });
        $salesforce->each->delete();

        $developers->each->delete();
        $faker = Faker::create();
        $user = auth()->user();
        $game = $user->load('game')->game;
        $game->update([
            'balance' => 5000,
        ]);

        // create developer and sales person
        $salesperson = SalesPeople::create($user->createFirstSalesPerson());
        $developer = Developer::create($user->createFirstDeveloper());

        // pivot tables
        $game->salespeople()->attach($salesperson->id);
        $game->developers()->attach($developer->id);

        // create project
        $projectName = implode(' ', $faker->words(2));
        $projectDescription = implode(' ', $faker->words(3));

        Project::create([
            'value' => ProjectComplexityAttribute::Medium->ProjectValue(),
            'run_count' => ProjectComplexityAttribute::Medium->TimesToCompleteProject(),
            'complexity' => ProjectComplexityAttribute::Medium->value,
            'game_id' => $game->id,
            'sales_people_id' => $salesperson->id,
            'developer_id' => $developer->id,
            'end_date' => Carbon::now()->addMinutes(20),
            'is_completed' => false,
            'name' => Str::ucfirst($projectName),
            'description' => Str::ucfirst($projectDescription),
        ]);
        // Developer::create($user->createFirstDeveloper());
        return Redirect::route('dashboard');
    }
}

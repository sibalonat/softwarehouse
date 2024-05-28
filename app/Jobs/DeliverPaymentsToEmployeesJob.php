<?php

namespace App\Jobs;

use App\Models\Game;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeliverPaymentsToEmployeesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $games = Game::with('developers', 'salespeople')->get();

        ds($games);

        foreach ($games as $game) {
            ds($game->balance);
            $developerCost = $game->developers->sum(function ($developer) {
                return $developer->hired ? $developer->cost : 0;
            });

            $salespersonCost = $game->salespeople->sum(function ($salesperson) {
                return $salesperson->hired ? $salesperson->cost : 0;
            });

            $totalCost = $developerCost + $salespersonCost;

            $game->balance -= $totalCost;
            $game->save();
        }
    }
}

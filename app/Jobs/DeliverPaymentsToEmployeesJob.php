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

        foreach ($games as $game) {
            ds($game);

            if ($game->balance > 0) {
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
                ds($game->balance);
            } else if($game->balance < 0 || $game->balance == 0) {
                $game->developers->each(function ($developer) use ($game) {
                    $developer->hired = false;
                    $developer->save();
                    $developer->games()->detach($game->id);
                });

                $game->salespeople->each(function ($salesperson) use ($game) {
                    $salesperson->hired = false;
                    $salesperson->save();
                    $salesperson->games()->detach($game->id);
                });
            }
        }
    }
}

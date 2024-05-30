<?php

namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $game = $user->load('game')->game;
        $game->load('developers', 'salespeople');

        $developersCost = $game->developers
        ->where('hired', true)
        ->where('hired_at', '>=', now()->subMinutes(3))
        ->sum('cost');

        $salesforceCost = $game->salespeople
        ->where('hired', true)
        ->where('hired_at', '>=', now()->subMinutes(3))
        ->sum('cost');

        $totalCost = $developersCost + $salesforceCost;

        // projects section
        $game->load('projects');

        $now = now();
        $threeMinutesAgo = $now->subMinutes(3);

        $projectsWithDevAndSales = $game->projects
            ->whereNotNull('developer_id')
            ->whereNotNull('sales_people_id')
            ->count();

        $projectsWithoutDevAndSales = $game->projects
            ->whereBetween('end_date', [$threeMinutesAgo, $now])
            ->whereNull('developer_id')
            ->whereNull('sales_people_id')
            ->count();

        $projectsWithoutEndDate = $game->projects
            ->whereNull('end_date')
            ->count();

        return inertia('Dashboard', [
            'cost' => $totalCost,
            'balance' => $game->balance,
            'update' => now()->subMinutes(3)->format('Y-m-d H:i:s'),
            'projectsWithDevAndSales' => $projectsWithDevAndSales,
            'projectsWithoutDevAndSales' => $projectsWithoutDevAndSales,
            'projectsWithoutEndDate' => $projectsWithoutEndDate,
        ]);
    }
}

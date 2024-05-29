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

        return inertia('Dashboard', [
            'cost' => $totalCost,
            'balance' => $game->balance,
            'update' => now()->subMinutes(3)->format('Y-m-d H:i:s'),
        ]);
    }
}

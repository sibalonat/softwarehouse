<?php

namespace App\Http\Controllers;

use App\Models\User;

class AuthEventIntervalController extends Controller
{
    public function getDataForUser(User $user)
    {
        $user->load('game');
        return response()->json([
            'game' => $user->game->only('id', 'name', 'user_id', 'balance'),
        ]);
    }

    public function gameOverFlash(User $user)
    {
        ds($user);
        $game = $user->load('game')->game;
        if ($game->balance == 0 || $game->balance < 0) {
            ds($game->balance);
            return session()->flash('alert', [
                'message' => 'You reached the balance 0. Game over!',
            ]);
        }
    }
}

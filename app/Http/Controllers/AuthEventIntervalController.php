<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthEventIntervalController extends Controller
{
    public function getDataForUser(User $user)
    {
        $user->load('game');
        return response()->json([
            'game' => $user->game->only('id', 'name', 'user_id', 'balance'),
        ]);
    }

    public function gameOverFlass()
    {
        session()->flash('alert', [
            'message' => 'You reached the balance 0. Game over!',
        ]);
    }
}

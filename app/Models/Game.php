<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'balance',
        'user_id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'updated_at' => 'datetime:Y-m-d H:i',
        ];
    }

    /**
     * Get the sales relation for the project.
     *
     */
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the project relation for the game.
     *
     */
    public function projects() : HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Get the developer relation for the game.
     *
     */
    public function developers() : BelongsToMany
    {
        return $this->belongsToMany(Developer::class);
    }

    /**
     * Get the developer relation for the game.
     *
     */
    public function salespeople() : BelongsToMany
    {
        return $this->belongsToMany(SalesPeople::class, 'sales_people_game', 'game_id', 'sales_people_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\SalesPersonExperienceAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SalesPeople extends Model
{
    use HasFactory;

    protected $fillable = [
        'cost',
        'hired',
        'name',
        'is_busy',
        'last_name',
        'experience',
        'hired_at'
    ];

    /**
     * Get the user's first name.
     */
    protected function firstLastName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => ucfirst($attributes['name'])  . ' ' . ucfirst($attributes['last_name']),
        );
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_busy' => 'boolean',
            'hired_at' => 'datetime:Y-m-d H:i',
            'experience' => SalesPersonExperienceAttribute::class,
        ];
    }

    /**
     * Get the salesforce relation for the game.
     *
     */
    public function games() : BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'sales_people_game', 'sales_people_id', 'game_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\DeveloperSeniorityAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Developer extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'last_name',
        'cost',
        'hired',
        'seniority',
        'is_busy',
    ];

    /**
     * Get the developer's first and last name.
     */
    public function firstLastName(): Attribute
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
            'seniority' => DeveloperSeniorityAttribute::class,
        ];
    }

    /**
     * Get the user associated with the Developer
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function project(): HasOne
    {
        return $this->hasOne(Project::class);
    }

    /**
     * Get the developers relation for the game.
     *
     */
    public function games() : BelongsToMany
    {
        return $this->belongsToMany(Game::class);
    }

}

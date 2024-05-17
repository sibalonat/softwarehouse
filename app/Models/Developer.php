<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\DeveloperSeniorityAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Developer extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'last_name',
        'cost',
        'seniority',
        'is_busy',
    ];

    /**
     * Get the developer's first and last name.
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
            'seniority' => DeveloperSeniorityAttribute::class,
        ];
    }

    /**
     * Get the comments for the blog post.
     */
    public function projects() : HasMany
    {
        return $this->hasMany(Project::class);
    }
}

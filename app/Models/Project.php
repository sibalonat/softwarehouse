<?php

namespace App\Models;

use App\Enums\ProjectComplexityAttribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'end_date',
        'developer_id',
        'salesperson_id',
        'game_id',
        'complexity',
        'is_completed',
        'value',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_completed' => 'boolean',
            'end_date' => 'datetime:Y-m-d',
            'complexity' => ProjectComplexityAttribute::class,
        ];
    }

    /**
     * Get the developer relation for the project.
     *
     */
    public function developer() : BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    /**
     * Get the sales relation for the project.
     *
     */

     public function salesperson() : BelongsTo
     {
        return $this->belongsTo(SalesPerson::class);
     }

    /**
     * Get the game relation for the project.
     *
     */

     public function game() : BelongsTo
     {
         return $this->belongsTo(Game::class);
     }
}

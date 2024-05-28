<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Notifications\Notifiable;
use App\Enums\ProjectComplexityAttribute;
use App\Enums\DeveloperSeniorityAttribute;
use App\Enums\SalesPersonExperienceAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'last_gameplay',
        'current_gameplay'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'last_gameplay' => 'datetime:Y-m-d H:i',
            'current_gameplay' => 'datetime:Y-m-d H:i',
        ];
    }

    public static function booted()
    {
        static::created(function ($model) {

            $faker = Faker::create();
            $game = Game::create([
                'name' => ' ',
                'user_id' => $model->id,
            ]);

            // create developer and sales person
            $salesperson = $model->createFirstSalesPerson();
            $developer = $model->createFirstDeveloper();

            // pivot tables
            $game->salespeople()->attach($salesperson->id);
            $game->developers()->attach($developer->id);

            // create project
            $projectName = implode(' ', $faker->words(2));
            $projectDescription = implode(' ', $faker->words(3));

            Project::create([
                'value' => ProjectComplexityAttribute::Medium->ProjectValue(),
                'run_count' => ProjectComplexityAttribute::Medium->TimesToCompleteProject(),
                'complexity' => ProjectComplexityAttribute::Medium->value,
                'game_id' => $game->id,
                'sales_people_id' => $salesperson->id,
                'developer_id' => $developer->id,
                'end_date' => Carbon::now()->addMinutes(20),
                'is_completed' => false,
                'name' => Str::ucfirst($projectName),
                'description' => Str::ucfirst($projectDescription),
            ]);
        });
    }


    /**
     * Get the game relation for the user.
     *
     */

     public function game() : HasOne
     {
        return $this->hasOne(Game::class);
     }

     // Create the first sales person for the user
     public function createFirstSalesPerson()
     {
        $faker = Faker::create();
        $experience = SalesPersonExperienceAttribute::Intermediate;
        $value = $experience->PersonelCost();
        $salesperson = new SalesPeople([
            'name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'hired' => true,
            'experience' => $experience->value,
            'cost' => $value,
        ]);

        $salesperson->save();
        return $salesperson;
     }

     // Create the first developer for the user
     public function createFirstDeveloper()
     {
        $faker = Faker::create();
        $experience = DeveloperSeniorityAttribute::Middle;
        $value = $experience->PersonelCost();

        $developer = new Developer([
            'name' => $faker->firstName,
            'last_name' => $faker->lastName,
            'seniority' => $experience->value,
            'hired' => true,
            'cost' => $value,
        ]);
        $developer->save();
        return $developer;
    }
}

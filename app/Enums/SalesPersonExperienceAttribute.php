<?php

namespace App\Enums;

use App\AttributableEnum;
use App\Attributes\PersonelCost;

enum SalesPersonExperienceAttribute : string
{
    use AttributableEnum;

    #[PersonelCost(400)]
    case Beginner = 'beginner';
    #[PersonelCost(800)]
    case Intermediate = 'intermediate';
    #[PersonelCost(1400)]
    case Advanced = 'advanced';
}

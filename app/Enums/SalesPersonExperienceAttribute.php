<?php

namespace App\Enums;

use App\AttributableEnum;
use App\Attributes\PersonelCost;

enum SalesPersonExperienceAttribute : string
{
    use AttributableEnum;

    #[PersonelCost(100)]
    case Beginner = 'beginner';
    #[PersonelCost(500)]
    case Intermediate = 'intermediate';
    #[PersonelCost(1100)]
    case Advanced = 'advanced';
}

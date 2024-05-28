<?php

namespace App\Enums;

use App\AttributableEnum;
use App\Attributes\PersonelCost;

enum DeveloperSeniorityAttribute : string
{
    use AttributableEnum;

    #[PersonelCost(800)]
    case Junior = 'junior';
    #[PersonelCost(1500)]
    case Middle = 'middle';
    #[PersonelCost(3000)]
    case Senior = 'senior';
}

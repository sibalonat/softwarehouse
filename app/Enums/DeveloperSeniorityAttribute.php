<?php

namespace App\Enums;

use App\AttributableEnum;
use App\Attributes\PersonelCost;

enum DeveloperSeniorityAttribute : string
{
    use AttributableEnum;

    #[PersonelCost(300)]
    case Junior = 'junior';
    #[PersonelCost(1000)]
    case Middle = 'middle';
    #[PersonelCost(2500)]
    case Senior = 'senior';
}

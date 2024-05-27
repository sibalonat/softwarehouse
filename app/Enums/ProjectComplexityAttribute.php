<?php

namespace App\Enums;

use App\AttributableEnum;
use App\Attributes\ProjectValue;
use App\Attributes\TimesToCompleteProject;

enum ProjectComplexityAttribute : string
{
    use AttributableEnum;

    #[ProjectValue(10000)]
    #[TimesToCompleteProject(60*5)]
    case Low = 'low';
    #[ProjectValue(13000)]
    #[TimesToCompleteProject(60*10)]
    case Medium = 'medium';
    #[ProjectValue(20000)]
    #[TimesToCompleteProject(60*15)]
    case High = 'high';
}

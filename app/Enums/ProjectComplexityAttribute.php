<?php

namespace App\Enums;

use App\AttributableEnum;
use App\Attributes\ProjectValue;
use App\Attributes\TimesToCompleteProject;

enum ProjectComplexityAttribute : string
{
    use AttributableEnum;

    #[ProjectValue(10000)]
    #[TimesToCompleteProject(10*1)]
    case Low = 'low';
    #[ProjectValue(13000)]
    #[TimesToCompleteProject(10*2)]
    case Medium = 'medium';
    #[ProjectValue(20000)]
    #[TimesToCompleteProject(10*3)]
    case High = 'high';
}

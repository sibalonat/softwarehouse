<?php

namespace App\Enums;

use ReflectionClass;
use App\AttributableEnum;
use InvalidArgumentException;
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

    // public static function fromValue($value) {
    //     $class = new ReflectionClass(__CLASS__);
    //     $constants = $class->getConstants();

    //     foreach ($constants as $key => $constant) {
    //         if ($constant == $value) {
    //             return $key;
    //         }
    //     }

    //     throw new InvalidArgumentException("Value not found in enum");
    // }
}

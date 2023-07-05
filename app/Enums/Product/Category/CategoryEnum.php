<?php

namespace App\Enums\Product\Category;

use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Names;
use ArchTech\Enums\Values;

enum CategoryEnum: string
{
    use InvokableCases, Values, Names;

    case BOOTS = 'boots';
    case SANDALS = 'sandals';
    case SNEAKERS = 'sneakers';
}

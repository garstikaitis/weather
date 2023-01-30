<?php

namespace App\Data\Casts;

use Spatie\LaravelData\Casts\Cast;
use App\Formatters\KelvinToCelsiusConverter;
use Spatie\LaravelData\Support\DataProperty;

class KelvinToCelsiusCast implements Cast
{
    /**
     * Converts temperature from Kelvin to Celsius
     */
    public function cast(
        DataProperty $property,
        mixed $value,
        array $context
    ): int {
        return KelvinToCelsiusConverter::convert($value);
    }
}

<?php

namespace App\Data\Casts;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Casts\Cast;
use Spatie\LaravelData\Support\DataProperty;

class WeatherTimestampToCarbonCast implements Cast
{
    public function cast(
        DataProperty $property,
        mixed $value,
        array $context
    ): CarbonImmutable {
        return CarbonImmutable::createFromTimestamp($value);
    }
}

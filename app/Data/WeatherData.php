<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use App\Data\Casts\KelvinToCelsiusCast;
use Spatie\LaravelData\Attributes\WithCast;
use App\Data\Casts\WeatherTimestampToCarbonCast;

class WeatherData extends Data
{
    /**
     * Builds a data structure that eventually will be sent to Whatagraph API.
     */
    public function __construct(
        public string $city,
        #[WithCast(WeatherTimestampToCarbonCast::class)] public string $date,
        #[WithCast(KelvinToCelsiusCast::class)] public int $minTemp,
        #[WithCast(KelvinToCelsiusCast::class)] public int $maxTemp,
        public int $averageTemp
    ) {
    }

    public function toResponse($request)
    {
    }
}

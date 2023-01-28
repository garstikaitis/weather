<?php

namespace App\Formatters;

class KelvinToCelsiusConverter
{
    const KELVIN_COEF = 273.15;
    public static function convert(float $value): float
    {
        return $value - self::KELVIN_COEF;
    }
}

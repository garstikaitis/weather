<?php

namespace App\Formatters;

class KelvinToCelsiusConverter
{
    const KELVIN_COEF = 273.15;
    /**
     * Converts temperature from Kelvin to Celsius
     * @param float $value
     * @return float
     */
    public static function convert(float $value): float
    {
        return $value - self::KELVIN_COEF;
    }
}

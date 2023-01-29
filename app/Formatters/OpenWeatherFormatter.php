<?php

namespace App\Formatters;

use App\Data\WeatherData;
use Spatie\LaravelData\DataCollection;
use App\Formatters\KelvinToCelsiusConverter;
use ErrorException;

class OpenWeatherFormatter
{
    public static function format(mixed $data): DataCollection
    {
        if (!$data) {
            return WeatherData::collection([]);
        }
        $weather = array_map(function ($day) use ($data) {
            $minTemp = $day["temp"]["min"];
            $maxTemp = $day["temp"]["max"];
            return [
                "city" => $data["city"]["name"],
                "date" => $day["dt"],
                "minTemp" => $minTemp,
                "maxTemp" => $maxTemp,
                "averageTemp" => KelvinToCelsiusConverter::convert(
                    ($minTemp + $maxTemp) / 2
                ),
            ];
        }, $data["list"]);

        /** @var DataCollection<WeatherData> */
        return WeatherData::collection($weather);
    }
}

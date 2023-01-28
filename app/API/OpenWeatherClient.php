<?php

namespace App\API;

use Illuminate\Support\Facades\Http;

class OpenWeatherClient
{
    public function getHistoricalWeatherForecast(
        float|string $latitude = 54.898521,
        string|float $longtitude = 23.903597,
        int $daysCount = 10
    ): mixed {
        $openWeatherApiKey = config(
            "integrations.providers.open_weather.api_key"
        );
        $response = Http::get(
            "api.openweathermap.org/data/2.5/forecast/daily?lat={$latitude}&lon={$longtitude}&cnt={$daysCount}&appid={$openWeatherApiKey}"
        )->json();
        return $response;
    }
}

<?php

namespace App\API;

use Throwable;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class OpenWeatherClient
{
    public function getHistoricalWeatherForecast(
        float|string $latitude = 54.898521, // Kaunas latitude
        string|float $longtitude = 23.903597, // Kaunas longtitude
        int $daysCount = 10
    ): mixed {
        $openWeatherApiKey = config(
            "integrations.providers.open_weather.api_key"
        );
        $response = Http::get(
            "api.openweathermap.org/data/2.5/forecast/daily?lat={$latitude}&lon={$longtitude}&cnt={$daysCount}&appid={$openWeatherApiKey}"
        );
        if ($response->status() !== 200) {
            $json = json_encode($response->json());
            throw new HttpException(
                $response->status(),
                "Something went wrong with OpenWeather API. Data from API: {$json}"
            );
        }
        return $response->json();
    }
}

<?php

namespace App\Services;

use App\API\OpenWeatherClient;
use App\Formatters\OpenWeatherFormatter;

class OpenWeatherService
{
    public function __construct(private OpenWeatherClient $client)
    {
    }
    public function getWeatherForecast()
    {
        $data = $this->client->getHistoricalWeatherForecast();
        return OpenWeatherFormatter::format($data);
    }
}

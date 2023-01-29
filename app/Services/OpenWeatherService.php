<?php

namespace App\Services;

use ErrorException;
use App\API\OpenWeatherClient;
use Spatie\LaravelData\DataCollection;
use App\Formatters\OpenWeatherFormatter;

class OpenWeatherService
{
    public function __construct(private OpenWeatherClient $client)
    {
    }

    public function getWeatherForecast(): DataCollection
    {
        $data = $this->client->getHistoricalWeatherForecast();
        if (!$data && !count($data)) {
            throw new ErrorException("Misformatted data.", 500);
        }
        return OpenWeatherFormatter::format($data);
    }
}

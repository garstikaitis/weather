<?php

namespace App\Actions;

use App\API\WhatagraphClient;
use App\Services\OpenWeatherService;
use Spatie\LaravelData\DataCollection;

class PushOpenWeatherDataToWhatagraph
{
    /** @var WeatherData[] */
    public DataCollection $weatherData;

    public function __construct(
        private readonly OpenWeatherService $openWeatherService,
        private readonly WhatagraphClient $whatagraphClient
    ) {
    }

    public function handle()
    {
        $this->getWeatherData();
        $this->pushWeatherDataToIntegrator();
        return true;
    }

    private function getWeatherData()
    {
        $this->weatherData = $this->openWeatherService->getWeatherForecast();
    }
    private function pushWeatherDataToIntegrator()
    {
        $this->whatagraphClient->createIntegrationSourceData(
            $this->weatherData
        );
    }
}

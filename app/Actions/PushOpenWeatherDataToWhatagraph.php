<?php

namespace App\Actions;

use App\API\WhatagraphClient;
use App\Services\OpenWeatherService;
use Spatie\LaravelData\DataCollection;

class PushOpenWeatherDataToWhatagraph
{
    /** @var DataCollection<WeatherData> */
    public DataCollection $weatherData;

    public function __construct(
        private readonly OpenWeatherService $openWeatherService,
        private readonly WhatagraphClient $whatagraphClient
    ) {
    }

    public function handle(): bool
    {
        $this->setWeatherData();
        dd($this->weatherData);
        if (!$this->weatherData->count()) {
            return false;
        }
        $this->pushWeatherDataToIntegrator();
        return true;
    }

    private function setWeatherData(): void
    {
        $this->weatherData = $this->openWeatherService->getWeatherForecast();
    }

    private function pushWeatherDataToIntegrator(): void
    {
        $this->whatagraphClient->createIntegrationSourceData(
            $this->weatherData
        );
    }
}

<?php

namespace Tests\Unit\Services;

use App\API\OpenWeatherClient;
use App\Services\OpenWeatherService;
use Spatie\LaravelData\DataCollection;
use Tests\TestCase;

class OpenWeatherServiceUnitTest extends TestCase
{
    private OpenWeatherService $service;
    public function setUp(): void
    {
        parent::setUp();
        $openWeatherStub = base_path() . "/tests/stubs/open_weather.json";
        $mock = $this->mock(OpenWeatherClient::class)
            ->shouldReceive("getHistoricalWeatherForecast")
            ->andReturn(
                json_decode(
                    file_get_contents($openWeatherStub),
                    associative: true
                )
            )
            ->getMock();

        app()->instance(OpenWeatherClient::class, $mock);
        $this->service = app()->make(OpenWeatherService::class);
    }

    public function tests_returns_correctly_formatted_data()
    {
        $response = $this->service->getWeatherForecast();
        $this->assertTrue(get_class($response) === DataCollection::class);
        $this->assertCount(7, $response);
        $temperatureData = $response->first();
        $this->assertObjectHasAttribute("city", $temperatureData);
        $this->assertObjectHasAttribute("minTemp", $temperatureData);
        $this->assertObjectHasAttribute("maxTemp", $temperatureData);
        $this->assertObjectHasAttribute("date", $temperatureData);
        $this->assertObjectHasAttribute("averageTemp", $temperatureData);
    }
}

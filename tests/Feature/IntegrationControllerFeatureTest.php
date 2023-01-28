<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use App\API\OpenWeatherClient;
use Illuminate\Support\Facades\Http;
use App\Formatters\OpenWeatherFormatter;
use App\Actions\PushOpenWeatherDataToWhatagraph;

class IntegrationControllerFeatureTest extends TestCase
{
    private OpenWeatherClient $apiClient;
    public function setUp(): void
    {
        parent::setUp();
        $openWeatherStub = base_path() . "/tests/stubs/open_weather.json";
        $openWeatherData = json_decode(
            file_get_contents($openWeatherStub),
            associative: true
        );
        $openWeatherClientMock = $this->mock(OpenWeatherClient::class)
            ->shouldReceive("getHistoricalWeatherForecast")
            ->andReturn($openWeatherData)
            ->getMock();
        $openWeatherServiceMock = $this->mock(OpenWeatherService::class)
            ->shouldReceive("getWeatherForecast")
            ->andReturn(OpenWeatherFormatter::format($openWeatherData))
            ->getMock();
        $whatagraphClientMock = $this->mock(WhatagraphClient::class)
            ->shouldReceive("createIntegrationSourceData")
            ->andReturnTrue()
            ->getMock();

        app()->instance(OpenWeatherClient::class, $openWeatherClientMock);
        app()->instance(OpenWeatherService::class, $openWeatherServiceMock);
        app()->instance(WhatagraphClient::class, $whatagraphClientMock);
        app()->make(PushOpenWeatherDataToWhatagraph::class);
    }

    public function test_returns_correct_data()
    {
        $response = $this->get(route("integrations.index"));
        $json = $response->json();
        $this->assertTrue($json["success"]);
        $this->assertTrue($json["data"]);
    }
}

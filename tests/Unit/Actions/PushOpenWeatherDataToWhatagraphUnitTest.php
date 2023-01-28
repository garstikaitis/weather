<?php

namespace Tests\Unit\Actions;
use Tests\TestCase;
use App\API\OpenWeatherClient;
use App\Services\OpenWeatherService;
use Spatie\LaravelData\DataCollection;
use App\Formatters\OpenWeatherFormatter;
use App\Actions\PushOpenWeatherDataToWhatagraph;
use App\API\WhatagraphClient;

class PushOpenWeatherDataToWhatagraphUnitTest extends TestCase
{
    private PushOpenWeatherDataToWhatagraph $action;

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
        $this->action = app()->make(PushOpenWeatherDataToWhatagraph::class);
    }

    public function test_returns_true_when_passing_correct_data()
    {
        $response = $this->action->handle();
        $this->assertTrue($response);
    }
}

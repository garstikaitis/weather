<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use App\API\OpenWeatherClient;
use Illuminate\Support\Facades\Http;

class OpenWeatherClientUnitTest extends TestCase
{
    private OpenWeatherClient $apiClient;
    public function setUp(): void
    {
        parent::setUp();
        $this->apiClient = new OpenWeatherClient();
    }

    public function test_returns_correct_data()
    {
        $openWeatherStub = base_path() . "/tests/stubs/open_weather.json";
        Http::fake([
            "api.openweathermap.org/data/2.5/forecast/daily*" => Http::response(
                json_decode(
                    file_get_contents($openWeatherStub),
                    associative: true
                ),
                200
            ),
        ]);
        $response = $this->apiClient->getHistoricalWeatherForecast(1, 1, 10);
        $this->assertArrayHasKey("city", $response);
        $this->assertArrayHasKey("list", $response);
    }
}

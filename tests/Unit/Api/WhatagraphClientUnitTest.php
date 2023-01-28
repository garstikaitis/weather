<?php

namespace Tests\Unit\Api\WhatagraphClientUnitTest;

use App\API\WhatagraphAPI;
use Tests\TestCase;
use App\API\WhatagraphClient;
use Illuminate\Support\Facades\Http;

class WhatagraphClientUnitTest extends TestCase
{
    public function test_returns_dimensions()
    {
        $stubPath = base_path() . "/tests/stubs/metric.json";
        Http::fake([
            "https://api.whatagraph.com/v1/*" => Http::response(
                ["data" => json_decode(file_get_contents($stubPath))],
                200
            ),
        ]);

        $apiClient = new WhatagraphClient();
        $response = $apiClient->getIntegrationMetrics();
        $this->assertTrue(count($response) === 1);
    }
}

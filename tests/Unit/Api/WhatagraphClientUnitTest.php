<?php

namespace Tests\Unit\Api;

use Tests\TestCase;
use Tests\TestHelpers;
use App\API\WhatagraphClient;

class WhatagraphClientUnitTest extends TestCase
{
    private WhatagraphClient $apiClient;
    public function setUp(): void
    {
        parent::setUp();
        (new TestHelpers())->fakeWhatagrapHttpCalls();
        $this->apiClient = new WhatagraphClient();
    }

    public function test_returns_metrics()
    {
        $response = $this->apiClient->getIntegrationMetrics();
        $this->assertTrue(count($response) === 1);
        $metric = $response[0];
        $this->assertTrue($metric["id"] === 1);
        $this->assertTrue($metric["external_id"] === "averageTemp");
    }

    public function test_creates_metric()
    {
        $metric = $this->apiClient->createIntegrationMetric();
        $this->assertTrue($metric["id"] === 1);
        $this->assertTrue($metric["external_id"] === "averageTemp");
    }

    public function test_deletes_metric()
    {
        $response = $this->apiClient->deleteIntegrationMetrics(1);
        $this->assertTrue($response);
    }

    public function test_returns_dimensions()
    {
        $response = $this->apiClient->getIntegrationDimensions();
        $this->assertTrue(count($response) === 1);
        $dimension = $response[0];
        $this->assertTrue($dimension["id"] === 1);
        $this->assertTrue($dimension["external_id"] === "city");
    }

    public function test_creates_dimension()
    {
        $dimension = $this->apiClient->createIntegrationDimension();
        $this->assertTrue($dimension["id"] === 1);
        $this->assertTrue($dimension["external_id"] === "city");
    }

    public function test_deletes_dimension()
    {
        $response = $this->apiClient->deleteIntegrationDimensions(1);
        $this->assertTrue($response);
    }
}

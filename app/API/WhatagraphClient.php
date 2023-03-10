<?php

namespace App\API;

use App\Traits\NormalizesRequests;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Spatie\LaravelData\DataCollection;
use Illuminate\Http\Client\PendingRequest as HttpClient;

class WhatagraphClient
{
    use NormalizesRequests;
    private HttpClient $httpClient;

    public function __construct()
    {
        $whatagraphApiKey = config(
            "integrations.integrator.whatagraph.api_key"
        );
        $this->httpClient = Http::withToken($whatagraphApiKey)->baseUrl(
            "https://api.whatagraph.com/v1/"
        );
    }

    public function getIntegrationMetrics(): mixed
    {
        $data = $this->httpClient
            ->get("/integration-metrics", [
                "external_id" => config(
                    "integrations.integrator.whatagraph.external_app_id"
                ),
            ])
            ->json("data");
        return $data;
    }

    public function getIntegrationDimensions(): mixed
    {
        $data = $this->httpClient
            ->get("/integration-dimensions", [
                "external_id" => config(
                    "integrations.integrator.whatagraph.external_app_id"
                ),
            ])
            ->json("data");
        return $data;
    }

    public function getIntegrationSourceData(): mixed
    {
        $data = $this->httpClient
            ->get("/integration-source-data", [
                "external_id" => config(
                    "integrations.integrator.whatagraph.external_app_id"
                ),
            ])
            ->json("data");
        return $data;
    }

    public function createIntegrationMetric(): mixed
    {
        $data = $this->httpClient
            ->post("/integration-metrics", [
                "name" => "Average Temperature",
                "external_id" => "averageTemp",
                "type" => "int",
                "accumulator" => "sum",
                "negative_ratio" => false,
            ])
            ->json("data");
        return $data;
    }
    public function createIntegrationDimension(): mixed
    {
        $data = $this->httpClient
            ->post("/integration-dimensions", [
                "name" => "City",
                "external_id" => "city",
                "type" => "string",
            ])
            ->json("data");
        return $data;
    }

    public function deleteIntegrationMetrics(
        Collection|array|int $metricIds
    ): bool {
        $metricIds = $this->normalizeRequest($metricIds);
        $metricIds->each(function ($id) {
            $this->httpClient
                ->delete("/integration-metrics/{$id}")
                ->json("data");
        });
        return true;
    }

    public function deleteIntegrationDimensions(
        Collection|array|int $dimenstionIds
    ): bool {
        $dimenstionIds = $this->normalizeRequest($dimenstionIds);
        $dimenstionIds->each(function ($id) {
            $this->httpClient
                ->delete("/integration-dimensions/{$id}")
                ->json("data");
        });
        return true;
    }

    public function deleteIntegrationSourceData(
        Collection|array|int $sourceDataIds
    ): bool {
        $sourceDataIds = $this->normalizeRequest($sourceDataIds);
        $sourceDataIds->each(function ($id) {
            $this->httpClient
                ->delete("/integration-source-data/{$id}")
                ->json("data");
        });
        return true;
    }

    public function createIntegrationSourceData(DataCollection $data): mixed
    {
        return $this->httpClient
            ->post("/integration-source-data/", [
                "data" => $data,
            ])
            ->json("data");
    }
}

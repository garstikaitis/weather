<?php

namespace Tests;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Promise\PromiseInterface;

class TestHelpers
{
    /**
     * Returns mocked Http responses based on URL
     * @return void
     */
    public function fakeHttpCalls(): void
    {
        $dimensionStub = base_path() . "/tests/stubs/dimensions.json";
        $metricStub = base_path() . "/tests/stubs/metric.json";
        Http::fake([
            "https://api.whatagraph.com/v1/integration-metric*" => fn(
                Request $request
            ) => $this->getMockedResponse($request, stubPath: $metricStub),
            "https://api.whatagraph.com/v1/integration-dimension*" => fn(
                Request $request
            ) => $this->getMockedResponse($request, stubPath: $dimensionStub),
        ]);
    }

    /**
     * Returns decoded JSON value from the path
     * If HTTP method is GET return list
     * If HTTP method is POST return first decoded item
     * @return array
     */
    private function getStubDataBasedOnRequestMethod(
        string $method,
        string $stubPath
    ): array {
        $data = json_decode(file_get_contents(filename: $stubPath));
        return $method === "GET" ? $data : (array) $data[0];
    }

    /**
     * returns mocked Http response instance.
     */
    private function getMockedResponse(
        Request $request,
        string $stubPath
    ): PromiseInterface {
        return Http::response([
            "data" => $this->getStubDataBasedOnRequestMethod(
                method: $request->method(),
                stubPath: $stubPath
            ),
            $request->method() === "GET" ? 200 : 201,
        ]);
    }
}

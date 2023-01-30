<?php

namespace App\Http\Controllers;

use App\Actions\PushOpenWeatherDataToWhatagraph;
use Throwable;

class IntegrationController extends Controller
{
    public function index(PushOpenWeatherDataToWhatagraph $action)
    {
        try {
            // Call a reusable action that pushes weather data to whatagraph
            $wasDataPushed = $action->handle();
            return response()->json(
                [
                    "data" => $wasDataPushed,
                    "success" => true,
                    "message" => $wasDataPushed
                        ? "Successfuly pushed data"
                        : "No data was pushed",
                ],
                200
            );
        } catch (Throwable $e) {
            return response()->json(
                [
                    "success" => true,
                    "message" => $e->getMessage(),
                    "data" => null,
                ],
                500
            );
        }
    }
}

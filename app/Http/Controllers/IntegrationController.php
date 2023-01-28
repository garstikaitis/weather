<?php

namespace App\Http\Controllers;

use App\Actions\PushOpenWeatherDataToWhatagraph;
use Throwable;

class IntegrationController extends Controller
{
    public function index(PushOpenWeatherDataToWhatagraph $action)
    {
        try {
            return response()->json(
                [
                    "data" => $action->handle(),
                    "success" => true,
                    "message" => "Successfuly pushed data",
                ],
                200
            );
        } catch (Throwable $e) {
            dd($e);
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

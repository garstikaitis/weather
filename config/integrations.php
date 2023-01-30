<?php

return [
    // Data providers
    "providers" => [
        // Add different data providers
        "open_weather" => [
            // Add api key for current data provider
            "api_key" => env("OPEN_WEATHER_MAP_API_KEY"),
        ],
    ],
    // Integration providers
    "integrator" => [
        // Add different integrators
        "whatagraph" => [
            "api_key" => env("WG_API_KEY"),
            "external_app_id" => env("WG_EXTERNAL_APP_ID"),
        ],
    ],
];

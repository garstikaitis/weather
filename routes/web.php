<?php

use Illuminate\Support\Facades\Route;

Route::get("/", function () {
    return response()->json([
        "success" => true,
        "data" => null,
        "message" => "visit /api/push-forecast for some magic",
    ]);
});

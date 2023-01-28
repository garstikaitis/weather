<?php

use App\Http\Controllers\IntegrationController;
use Illuminate\Support\Facades\Route;

Route::get("/push-forecast", [IntegrationController::class, "index"])->name(
    "integrations.index"
);

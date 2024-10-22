<?php

use App\Http\Controllers\ProcessBillingController;
use Illuminate\Support\Facades\Route;

Route::prefix('billing')
    ->group(function () {
        Route::post('/process/csv', ProcessBillingController::class)->name('billing.process.csv');
    });

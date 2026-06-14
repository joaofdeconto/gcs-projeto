<?php

use App\Http\Controllers\ProdutoController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::apiResource('produtos', ProdutoController::class);
});

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'env'    => config('app.env'),
        'time'   => now()->toDateTimeString(),
    ]);
});


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;

// Ensure that the TranslationController class exists in the specified namespace
// If it does not exist, create the class in the App\Http\Controllers namespace


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/list', [TranslationController::class, 'list']);
    Route::post('/create', [TranslationController::class, 'create']);
    Route::put('/update/{id}', [TranslationController::class, 'update']);
});
Route::get('export', [TranslationController::class, 'export']);

<?php

declare(strict_types=1);

use App\Http\Controllers\Url\DestroyUrlController;
use App\Http\Controllers\Url\StoreUrlController;
use App\Http\Controllers\Url\UpdateUrlController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {

    Route::post('/', StoreUrlController::class)->name('store');
    Route::put('/{url}', UpdateUrlController::class)->name('update');
    Route::delete('/{url}', DestroyUrlController::class)->name('destroy');

});

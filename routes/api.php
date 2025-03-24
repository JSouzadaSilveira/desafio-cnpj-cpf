<?php

use App\Http\Controllers\SupplierController;
use Illuminate\Support\Facades\Route;

Route::apiResource('suppliers', SupplierController::class);
Route::get('suppliers/document/{document}', [SupplierController::class, 'findByDocument']);

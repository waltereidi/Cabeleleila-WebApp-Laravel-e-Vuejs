<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Okipa\LaravelTable\Table;
use App\Models\Clientes; // Substitua pelo modelo relacionado à sua tabela
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



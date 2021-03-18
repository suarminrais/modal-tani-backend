<?php

use App\Http\Controllers\Api\AccessTokenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\TestimonyController;
use App\Http\Controllers\ProgramController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [AuthenticationController::class, 'store']);
Route::post('token', [AccessTokenController::class, 'store']);
Route::middleware('auth:sanctum')->post('logout', [AuthenticationController::class, 'destroy']);

//route program
Route::get('program', [ProgramController::class, 'index']);
Route::get('program/{program}', [ProgramController::class, 'show']);
Route::middleware('auth:sanctum')->post('program', [ProgramController::class, 'store']);
Route::middleware('auth:sanctum')->post('program/{program}', [ProgramController::class, 'update']);
Route::middleware('auth:sanctum')->delete('program/{program}', [ProgramController::class, 'destroy']);

//route user
Route::middleware('auth:sanctum')->get('user', [UserController::class, 'index']);
Route::middleware('auth:sanctum')->post('user', [UserController::class, 'store']);
Route::middleware('auth:sanctum')->get('user/{id}', [UserController::class, 'show']);
Route::middleware('auth:sanctum')->put('user/{id}', [UserController::class, 'update']);
Route::middleware('auth:sanctum')->delete('user/{id}', [UserController::class, 'destroy']);

//route testimony
Route::middleware('auth:sanctum')->post('testimony', [TestimonyController::class, 'store']);
Route::middleware('auth:sanctum')->get('testimony', [TestimonyController::class, 'index']);
Route::middleware('auth:sanctum')->get('testimony/{testimony}', [TestimonyController::class, 'show']);
Route::middleware('auth:sanctum')->put('testimony/{testimony}', [TestimonyController::class, 'update']);
Route::middleware('auth:sanctum')->delete('testimony/{testimony}', [TestimonyController::class, 'destroy']);

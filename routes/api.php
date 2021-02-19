<?php

use App\Http\Controllers\Api\AccessTokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthenticationController;
use App\Http\Controllers\Api\UserController;
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

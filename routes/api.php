<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BuyersController;
use App\Http\Controllers\BranchOfficeController;

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

/* Buyers Routes */
 Route::post('buyers', [BuyersController::class,'store']);
 Route::get('buyers', [BuyersController::class,'index']);
 Route::delete('buyers/{buyer}', [BuyersController::class,'delete']);
 Route::post('buyers/assignament/{buyer}', [BuyersController::class,'assignament']);
/* Branch Offices Routes */
 Route::post('branchOffice', [BranchOfficeController::class,'store']);
 Route::get('branchOffice', [BranchOfficeController::class,'index']);
 Route::get('branchOffice/ticket_available/{branchOffice}', [BranchOfficeController::class,'available']);
 Route::delete('branchOffice/{branchOffice}', [BranchOfficeController::class,'delete']);


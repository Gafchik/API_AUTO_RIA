<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/search',[APIController::class,'Get_Car'])->name('search');
Route::group(['prefix' => 'prop'],function() {
    Route::get('/type',[APIController::class,'Get_Type']);
    Route::get('/mark',[APIController::class,'Get_Mark']);
    Route::get('/model',[APIController::class,'Get_Model']);
    Route::get('/region',[APIController::class,'Get_Region']);
});

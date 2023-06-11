<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Route::post('/geocode', 'App\Http\Controllers\GeocodeController@geocode');



Route::post('/upload-head', 'App\Http\Controllers\UploadEverythingController@uploadHead');
Route::get('/get-all-data-from-custom-all-tables', 'App\Http\Controllers\UploadEverythingController@getAllDataFromCustomAllTables');
Route::get('/get-all-data-from-custom-all-tables-for-user', 'App\Http\Controllers\UploadEverythingController@getAllDataFromCustomAllTablesForUser');
Route::post('/update-headline-now', 'App\Http\Controllers\UploadEverythingController@updateHeadlineNow');
Route::post('/upload-all-name-and-amount', 'App\Http\Controllers\UploadEverythingController@uploadAllNameAndAmount');
Route::post('/delete-specific-item', 'App\Http\Controllers\UploadEverythingController@deleteSpecificItem');




Route::post('/get-current-component-with', 'App\Http\Controllers\CustomUsersController@getCurrentComponentWith');
Route::get('/get-all-routes-for-nav', 'App\Http\Controllers\CustomUsersController@getAllRoutesForNav');





<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [App\Http\Controllers\Api\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::apiResource('accomodation-type', App\Http\Controllers\AccomodationTypeController::class);
Route::apiResource('option', App\Http\Controllers\OptionController::class);
Route::apiResource('included-in-accomodation-pricing', App\Http\Controllers\IncludedInAccomodationPricingController::class);
Route::apiResource('service', App\Http\Controllers\ServiceController::class);
Route::apiResource('sport-type', App\Http\Controllers\SportTypeController::class);
Route::apiResource('object-type', App\Http\Controllers\ObjectTypeController::class);
Route::apiResource('feedback', App\Http\Controllers\FeedbackController::class);

Route::apiResource('accomodation-type-and-pricing', App\Http\Controllers\AccomodationTypeAndPricingController::class);
Route::apiResource('infrastructure', App\Http\Controllers\InfrastructureController::class);
Route::apiResource('accomodation-condition-pricing', App\Http\Controllers\AccomodationConditionAndPricingController::class);

Route::apiResource('sport-object', App\Http\Controllers\SportObjectController::class);

Route::apiResource('sport-type-and-object', App\Http\Controllers\SportTypeAndObjectController::class);
Route::apiResource('service-and-object', App\Http\Controllers\ServiceAndObjectController::class);
Route::apiResource('infrastructure-and-object', App\Http\Controllers\ServiceAndObjectController::class);


//Route::group(['middleware' => [ 'localization']], function () {

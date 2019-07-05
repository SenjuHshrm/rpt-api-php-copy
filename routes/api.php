<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Route::match(['post'], 'api/login', 'LoginCtrl@login')->middleware('cors');



Route::group(['middleware' => ['cors']], function() {
    Route::post('/login', 'LoginCtrl@login');
    Route::post('/register', 'RegisterCtrl@register');
    Route::get('/test', 'TestCtrl@testToken');
    Route::post('/check-pin-land', 'CheckPINLand@check');
    Route::post('/search-faas-record', 'SearchRecord@search');
    Route::get('/land-tax/position-holders', 'LandTaxPosHolders@getHolders');
    Route::post('/save/file/clearance', 'SaveClearance@save');
    Route::post('/get-file/land-tax', 'GetClearance@getFile');
    Route::post('/get-faas/land', 'GetLandFaas@getInfo');
    Route::post('/get-faas/bldg', 'GetBldgFaas@getInfo');
    Route::post('/get-data-taxdec', 'GetDataTaxDec@getData');
    Route::post('/segregation/get-data', 'SegregationCtrl@searchRecord');
		Route::post('/pending/segregation', 'GetPendingTrns@getPendingSegregation');
		Route::post('/pending/consolidation', 'GetPendingTrns@getPendingConsolidation');
		Route::post('/pending/subdivision', 'GetPendingTrns@getPendingSubdivision');
});

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
		// POST requests
    Route::post('/login', 'LoginCtrl@login');
    Route::post('/register', 'RegisterCtrl@register');
		Route::post('/save/file/clearance', 'SaveClearance@save');
    Route::post('/get-file/land-tax', 'GetClearance@getFile');
		Route::post('/check-pin-land', 'CheckPINLand@check');
		Route::post('/set-ref-num', 'SetRefNum@set');
		// GET requests
		Route::post('/get-data-taxdec', 'GetDataTaxDec@getData'); //get
    Route::get('/test', 'TestCtrl@testToken');
    Route::get('/search-faas-record/{sysCaller}/{searchIn}/{searchBy}/{info}', 'SearchRecord@search');
    Route::get('/position-holders/{sysCaller}', 'PosHolders@getHolders');
    Route::get('/get-faas/land/{id}', 'GetLandFaas@getInfo');
    Route::get('/get-faas/bldg/{id}', 'GetBldgFaas@getInfo');
    Route::get('/segregation/get-data/{sysCaller}/{searchBy}/{info}', 'SegregationCtrl@searchRecord');
		Route::get('/pending/segregation/{name}', 'GetPendingTrns@getPendingSegregation');
		Route::get('/pending/consolidation/{name}', 'GetPendingTrns@getPendingConsolidation');
		Route::get('/pending/subdivision/{name}', 'GetPendingTrns@getPendingSubdivision');
		Route::get('/land/market-values', 'GetMarketValues@getVal');
		Route::get('/bldg/kinds', 'BldgValuesCtrl@getBldgKind');
		Route::get('/sample-pdf', 'LandFaasGenFile@genFile');
		// PUT requests
		Route::put('/land-asmt/add', 'AssessLand@addLand');
		Route::put('/land-asmt/update', 'AssessLand@updateLand');
		Route::put('/bldg-asmt/add', 'AssessBldg@addBldg');
		Route::put('/bldg-asmt/update', 'AssessBldg@updateBldg');
		Route::put('/land-reasmt/reassess', 'ReassessmentCtrl@reassessLand');
		Route::put('/bldg-reasmt/reassess', 'ReassessmentCtrl@reassessBldg');
});

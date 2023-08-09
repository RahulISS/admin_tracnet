<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ChartController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\MobilePortalController;
use App\Http\Controllers\API\RawDataController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\FileController;

use App\Http\Controllers\API\PortalController;
use App\Http\Controllers\API\LocationController;
use App\Http\Controllers\API\ApiController;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::prefix('v1')->group(function () {
    // Artisan::call('cache:clear');
    // Artisan::call('route:cache');
    // Artisan::call('config:cache');
    // Artisan::call('view:clear');
    Route::post('login', [LoginController::class, 'login']);
    // Route::post('register', [LoginController::class, 'register']);
    Route::get('logout', [LoginController::class, 'logout']);
    Route::resource('product', ProductController::class);
    Route::resource('chart', ChartController::class);
    // mobile api
    Route::get('/getAllPortal',[MobilePortalController::class,'getAllPortal']);
    Route::get('/getSerialID',[MobilePortalController::class,'getSerialID']); 
    // raw data mongo2
    Route::get('rawdata',[RawDataController::class,'getRawData']);
    Route::get('traknetApiList/{date?}', [HomeController::class, 'traknetApiList']);
    Route::get('new-traknetApiList/{date?}', [HomeController::class, 'NewtraknetApiList']);
    Route::get('/atreenode-ref',[ApiController::class,'aTreeNodeRef']);


    Route::get('dynamicTable/{serialID}',[MobilePortalController::class,'dynamicTable']);

    // upload csv file
    Route::post('/upload',[FileController::class,'import']); 
    
    /** Get portal api */
    Route::get('/get-portal',[PortalController::class,'getPortal']);
    Route::get('/get-alert-installation',[PortalController::class,'getAlertInstallation']);
    Route::get('/tracnet-alarm-alert/{date?}',[PortalController::class,'tracnetAlarmAlert']);
    Route::get('/alocation-data/{id}',[PortalController::class,'aLocationData']);
    Route::get('/tracnet-alarm-alert-tab',[PortalController::class,'tractnetAlarmAlertTab']);



    Route::post('/addSetting',[HomeController::class,'addSetting']);
    Route::get('sensortList', [ChartController::class, 'listAllSensors']); 
    Route::get('html_aTreeNode_get_id_device_02_a', [ChartController::class, 'getDeviceId']);
    Route::get('location', [ApiController::class, 'getAllTimeZone']);
    Route::get('groupNode', [ApiController::class, 'getGroupNode']);
    Route::get('html_plot_chart_06_b', [ChartController::class, 'getDeviceData']);

    // tracnet mobile update api
    Route::post('/tracnet-mobile-portal-update', [ProductController::class, 'update']);

    Route::get('html_aTreeNode_hisEndVal', [HomeController::class, 'treenodeVal']);
    Route::post('alarm-notification',[ApiController::class , 'sendAlarmNotification']);

    /**Distance alert api */
    Route::get('user-definded-distancealert',[HomeController::class, 'userDefinedDistanceAlert']);
    Route::post('add-user-definded-distancealert',[HomeController::class, 'addUserDefinedDistanceAlert']);
    Route::get('get-setting-data', [HomeController::class, 'getSettingFormData']);
});
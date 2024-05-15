<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FTPController;
use App\Http\Controllers\Api\DeployConfigController;
use App\Models\DeployConfig;
use App\Http\Controllers\Api\CypressController;
use App\Http\Controllers\Api\ApiRunnerController;

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


Route::post('/cypress/createFile', [CypressController::class, 'init']);
Route::get('/cypress/run', [CypressController::class, 'run']);
Route::get('/cypress/log', [CypressController::class, 'log']);
Route::post('/apirunner/collection/create', [ApiRunnerController::class, 'create']);
Route::get('/apirunner/collection/run', [ApiRunnerController::class, 'run']);
Route::post('/upload-task', [ApiRunnerController::class, 'errorTaskCreate']);


Route::post('zterminal/project/validate', [FTPController::class,'validateUser']);
Route::post('zterminal/project/list', [FTPController::class,'list']);
Route::post('zterminal/project/show', [FTPController::class,'show']);
Route::post('zterminal/project/users', [FTPController::class,'users']);
Route::post('zterminal/project/createFile/{id}', [FTPController::class,'createFile']);
Route::post('zterminal/project/udpate/{user_id}', [FTPController::class,'udpateUserConfig']);


// Deploy Config
Route::group(['prefix' => 'deploy-configs', 'as' => 'deploy-configs.'], function () {
    Route::get('/', [DeployConfigController::class,'index']);
    Route::post('/store/{id?}', [DeployConfigController::class,'store']);
    Route::get('/destroy/{id}', [DeployConfigController::class,'destroy']);
    Route::get('/show/{id}', [DeployConfigController::class,'show']);
});






    
    


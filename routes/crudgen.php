<?php

use App\Http\Controllers\CrudGenerator\CrudGenController;
use Illuminate\Support\Facades\Route;


Route::group(
    ['prefix' => 'dev/crudgen', 'as' => 'crudgen.', 'controller' =>CrudGenController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/new', 'new')->name('new');
        Route::post('/generate', 'generateOld')->name('generate');
        Route::post('/bulk-import/generate', 'bulkImportGenerate')->name('bulk-import.generate');
        Route::get('/get-col', 'getColumns')->name('get-col');

        Route::post('/process-requirement', 'processRequirements')->name('process-requirement');

    }
);



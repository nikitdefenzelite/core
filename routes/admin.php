<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\CategoryTypeController;
use App\Http\Controllers\Admin\CategoryController;

Route::fallback(
    function () {
        return view('panel.admin.error-page.error-404');
    }
);

Route::group(
    ['middleware' => ['auth', 'role:admin'], 'prefix' => 'admin', 'as' => 'panel.admin.'], function () {
        Route::group(
            ['prefix' => 'dashboard', 'as' => 'dashboard.', 'controller' => DashboardController::class], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/logout-as', 'logoutAs')->name('logout-as');
            }
        );
        Route::group(
            ['prefix' => 'users', 'as' => 'users.', 'controller' => UserController::class], function () {
                Route::get('/', 'index')->name('index');
                Route::any('print', 'print')->name('print');
                Route::get('create', 'create')->name('create')->middleware('permission:add_user');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{user}', 'edit')->name('edit')->middleware('permission:edit_user');
                Route::get('show/{user}', 'show')->name('show');
                Route::get('destroy/{id}', 'destroy')->name('destroy');
                Route::post('update/{user}', 'update')->name('update');
                Route::get('update/status/{id}/{s}', 'updateStatus')->name('update-status');
                Route::get('login-as/{id}/', 'loginAs')->name('login-as');
                Route::get('{id}/sessions', 'session')->name('sessions');
                Route::get('sessionDelete/{id}/', 'delete')->name('delete');
                Route::post('bulk-action', 'bulkAction')->name('bulk-action');
                Route::post('session/bulk-action', 'sessionBulkAction')->name('session.bulk-action');
                Route::post('/kyc-status', 'updateKycStatus')->name('update-kyc-status');
                Route::get('/verified-status/{id}', 'verifiedStatus')->name('verified-status');
                Route::post('/user/update-password/{id}', 'updateUserPassword')->name('update-user-password');
                Route::get('get/users', 'getUsers')->name('get-users');
                Route::get('/user-delete', 'userDelete')->name('userDelete');
                Route::post('/export', 'export')->name('export');
                Route::post('/bulk', 'export')->name('bulk');
                Route::get('/get-permissions', 'getPermission')->name('get.permission');

            }
        );
        Route::group(
            ['prefix' => 'roles', 'as' => 'roles.', 'controller' => RoleController::class], function () {
                Route::get('/', 'index')->name('index')->middleware('permission:view_roles');
                Route::post('store', 'store')->name('store');
                Route::get('edit/{role}', 'edit')->name('edit')->middleware('permission:edit_role');
                Route::post('update/{id}', 'update')->name('update');
                Route::get('destroy/{role}', 'destroy')->name('destroy');
            }
        );
        Route::group(
            ['prefix' => 'permissions', 'as' => 'permissions.', 'controller' => PermissionController::class], function () {
                Route::get('/', 'index')->name('index')->middleware('permission:view_permissions');
                Route::post('store', 'store')->name('store');
                Route::get('destroy/{id}', 'destroy')->name('destroy');
            }
        );
    }
);

Route::group(['middleware' => ['can:view_projects'],'prefix' => 'admin/projects','as'
=>'admin.projects.','controller' =>
App\Http\Controllers\Admin\ProjectController::class], function () {
    Route::get('','index')->name('index');
    Route::any('/print','print')->name('print');
    Route::get('create','create')->name('create');
    Route::post('store','store')->name('store');;
    Route::get('edit/{id}','edit')->name('edit');
    Route::post('update/{id}','update')->name('update');
    Route::get('delete/{id}','destroy')->name('destroy');
    Route::post('more-action','moreAction')->name('more-action');
    Route::get('/{id}','show')->name('show');
    Route::get('restore/{id}','restore')->name('restore');
  

    Route::get('store/task/{id}','storeTask')->name('store-task-scenario');
    Route::get('show/import/project/modal', 'showImportProjectModal')->name('show-import-project-modal');
  

});

Route::group(['middleware' => ['can:view_projects'],'prefix' => 'admin/upload','as'
=>'admin.upload.','controller' =>
App\Http\Controllers\Admin\ProjectController::class], function () {
    Route::post('task','uploadTask');

});


Route::group(['middleware' => ['can:view_cy_runners'],'prefix' => 'admin/cy-runners','as'
=>'admin.cy-runners.','controller' =>
App\Http\Controllers\Admin\CyRunnerController::class], function () {
    Route::get('','index')->name('index');
    Route::any('/print','print')->name('print');
    Route::get('create','create')->name('create');
    Route::post('store','store')->name('store');;
    Route::get('edit/{id}','edit')->name('edit');
    Route::post('update/{id}','update')->name('update');
    Route::get('delete/{id}','destroy')->name('destroy');
    Route::post('more-action','moreAction')->name('more-action');
    Route::get('/{id}','show')->name('show');
    Route::get('restore/{id}','restore')->name('restore');
    Route::get('get/scenario','runScenario')->name('run-scenario');
    Route::post('run/bulk/scenario','runBulkScenario')->name('run-bulk-scenario');
    Route::get('get/group/scenario/{id}','getGroupScenario')->name('get-group-scenario');
    Route::get('get/group/drag/drop/scenario','getGroupDragAndDropScenario')->name('get-group-drag-drop-scenario');
    Route::get('get/bulk/scenario','getBulkScenario')->name('get-bulk-scenario');
    Route::get('get/scenario/change/location','getGroupScenario')->name('get-change-location-scenario');
});


Route::group(['middleware' => ['can:view_cy_runner_logs'],'prefix' => 'admin/cy-runner-logs','as'
=>'admin.cy-runner-logs.','controller' =>
App\Http\Controllers\Admin\CyRunnerLogController::class], function () {
Route::get('','index')->name('index');
Route::any('/print','print')->name('print');
Route::get('create','create')->name('create');
Route::post('store','store')->name('store');;
Route::get('edit/{id}','edit')->name('edit');
Route::post('update/{id}','update')->name('update');
Route::get('delete/{id}','destroy')->name('destroy');
Route::post('more-action','moreAction')->name('more-action');
Route::get('/{id}','show')->name('show');
    Route::get('restore/{id}','restore')->name('restore');
});

Route::group(['middleware' => ['can:view_api_runner_logs'],'prefix' => 'admin/api-runner-logs','as'
=>'admin.api-runner-logs.','controller' =>
App\Http\Controllers\Admin\ApiRunnerLogController::class], function () {
Route::get('','index')->name('index');
Route::any('/print','print')->name('print');
Route::get('create','create')->name('create');
Route::post('store','store')->name('store');;
Route::get('edit/{id}','edit')->name('edit');
Route::post('update/{id}','update')->name('update');
Route::get('delete/{id}','destroy')->name('destroy');
Route::post('more-action','moreAction')->name('more-action');
Route::get('/{id}','show')->name('show');
    Route::get('restore/{id}','restore')->name('restore');
});


Route::group(['middleware' => ['can:view_api_runners'],'prefix' => 'admin/api-runners','as'
=>'admin.api-runners.','controller' =>
App\Http\Controllers\Admin\ApiRunnerController::class], function () {
Route::get('','index')->name('index');
Route::any('/print','print')->name('print');
Route::get('create','create')->name('create');
Route::post('store','store')->name('store');;
Route::get('edit/{id}','edit')->name('edit');
Route::post('update/{id}','update')->name('update');
Route::get('delete/{id}','destroy')->name('destroy');
Route::post('more-action','moreAction')->name('more-action');
Route::get('/{id}','show')->name('show');
Route::get('restore/{id}','restore')->name('restore');
Route::get('get/scenario','runScenario')->name('run-api-scenario');
Route::post('run/bulk/scenario','runBulkScenario')->name('run-bulk-scenario');
Route::get('get/bulk/scenario','getBulkScenario')->name('get-bulk-scenario');
Route::get('get/group/scenario/{id}','getGroupScenario')->name('get-group-scenario');
Route::get('get/group/drag/drop/scenario','getGroupDragAndDropScenario')->name('get-group-drag-drop-scenario');
Route::post('import/postman/collection', 'importPostmanCollection')->name('import-postman-collection');
});


Route::group(['prefix' => 'category-types', 'as' => 'category-types.', 'controller' => CategoryTypeController::class], function () {
    Route::get('/', 'index')->name('index')->middleware('permission:view_categories');
    Route::get('/create', 'create')->name('create')->middleware('permission:add_category');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit')->middleware('permission:edit_category');
    Route::get('/show/{id}', 'show')->name('show');
    Route::post('/update/{categoryType}', 'update')->name('update');
    Route::post('more-action', 'moreAction',)->name('more-action');
    Route::any('/print', 'print')->name('print');
    Route::get('/destroy/{id}', 'destroy')->name('destroy')->middleware('permission:delete_category');
    Route::post('bulk-action', 'bulkAction')->name('bulk-action');
});


Route::group(['prefix' => 'categories', 'as' => 'categories.', 'controller' => CategoryController::class], function () {
    Route::get('/{projectId}', 'index')->name('index');
    Route::get('/create/{categoryTypeId}/{level?}/{parent_id?}', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/edit/{id}', 'edit')->name('edit');
    Route::get('/show/{category}', 'show')->name('show');
    Route::post('/update/{category}', 'update')->name('update');
    Route::post('more-action', 'moreAction',)->name('more-action');
    Route::any('/print', 'print')->name('print');
    Route::get('/destroy/{id}', 'destroy')->name('destroy');
    Route::post('bulk-action', 'bulkAction')->name('bulk-action');
});

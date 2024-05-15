{{-- Crud Routes Start --}}

Route::group(['middleware' => ['can:{{ $data['permissions']['view'] }}'],'prefix' => '{{ $prefix }}','as'
=>'{{ $as }}.','controller' =>
App\Http\Controllers\{{ $data['controller_namespace'] }}\{{ $data['model'] }}Controller::class], function () {
Route::get('','index')->name('index');
Route::any('/print','print')->name('print');
Route::get('create','create')->name('create');
Route::post('store','store')->name('store');;
Route::get('edit/{id}','edit')->name('edit');
Route::post('update/{id}','update')->name('update');
Route::get('delete/{id}','destroy')->name('destroy');
Route::post('more-action','moreAction')->name('more-action');
Route::get('/{id}','show')->name('show');
@isset($data['softdelete'])
    Route::get('restore/{id}','restore')->name('restore');
@endisset
@isset($data['export_btn'])
    Route::get('export','export')->name('export');
@endisset
@isset($data['import_btn'])
    Route::post('import','import')->name('import');
@endisset
});

{{-- Crud Routes End --}}

{{-- Crud Routes Start --}}

Route::group(['namespace' => 'Api','prefix' => '{{ $data['view_name'] }}','as' =>'{{ $as }}.','middleware' =>
["api", "auth:api"]], function () {
Route::get('/', ['uses' => '{{ $data['model'] }}Controller@index']);
Route::post('/', ['uses' => '{{ $data['model'] }}Controller@store']);
Route::get('/{{ '{' . substr($variable, 1) . '}' }}', ['uses' => '{{ $data['model'] }}Controller@show']);
Route::put('/{{ '{' . substr($variable, 1) . '}' }}', ['uses' => '{{ $data['model'] }}Controller@update']);
Route::delete('/{{ '{' . substr($variable, 1) . '}' }}', ['uses' => '{{ $data['model'] }}Controller@destroy']);
});

{{-- Crud Routes End --}}

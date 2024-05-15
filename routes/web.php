<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use Illuminate\Http\Request;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('{role}/login', [LoginController::class, 'loginForm'])->name('login');
Route::post('{role}/login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/login-validate', [LoginController::class, 'validateLoginByNumber'])->name('login-validate');
Route::get('/otp', [LoginController::class, 'otp'])->name('otp-index');
Route::get('/auth-signup', [LoginController::class, 'signup'])->name('signup');
Route::post('/signup-validate', [LoginController::class, 'validateSignup'])->name('signup-validate');
// Route::get('{role}/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/auth-otp-validate', [LoginController::class, 'validateOTP'])->name('otp-validate');
// Route::post('{role}/register', [RegisterController::class, 'register']);




Route::get('/qb', function () {

return cyFaker('ipv4');



  });
    

  Route::group(
    [], function () {
        include_once __DIR__ . '/admin.php';
        include_once __DIR__ . '/crudgen.php';
    }
);

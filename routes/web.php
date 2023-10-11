<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CoreController;
use App\Http\Controllers\HomeController;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', [CoreController::class, 'index']);
Route::get('/index', [CoreController::class, 'index']);

Route::get('/create', [CoreController::class, 'create']);
Route::post('/create', [CoreController::class, 'create']);

Route::get('/login', [CoreController::class, 'loginPage']);
Route::post('/login', [CoreController::class, 'login']);

Route::post('/coupon', [CoreController::class, 'coupon']);
Route::get('/coupon', [CoreController::class, 'coupon']);
Route::get('/search_HN', [CoreController::class,'search_HN']);
Route::post('/search_HN', [CoreController::class,'search_HN']);



Route::post('/savedata', [CoreController::class, 'SaveData']);
Route::post('/couponlist', [CoreController::class,'couponlist']);
Route::get('/couponlist', [CoreController::class,'couponlist']);

Route::post('postlogin',[CoreController::class,'login'])->name('postlogin');

// Route::get('/', [HomeController::class, 'index'])->name('index');
// Route::get('/loginVac.create', [HomeController::class, 'loginVac']);
// Route::get('/logoutVac' , [HomeController::class, 'logoutVac']);





//Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/login', [App\Http\Controllers\HomeController::class, 'login'])->name('login');

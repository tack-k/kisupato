<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Consts;
use \App\Http\Controllers\Users\UserController;
use \App\Http\Controllers\Admins\AdminController;
use \App\Http\Controllers\Admins\DepartmentController;
use \App\Http\Controllers\Admins\PositionController;
use \App\Http\Controllers\Admins\TagController;
use \App\Http\Controllers\Admins\UserContactTitleController;
use \App\Http\Controllers\Admins\ExpertContactTitleController;


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


require __DIR__ . '/user_auth.php';
require __DIR__ . '/admin_auth.php';

//仮置き
Route::get('/dashboard', function () {
    return Inertia::render('Users/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');


//ユーザー:認証なし
Route::group(['middleware' => 'guest'], function() {
    Route::get('/register', [UserController::class, 'create'])->name('create');
    Route::post('/register', [UserController::class, 'store'])->name('store');
});



//ユーザー:認証あり
Route::group(['middleware' => 'auth:user'], function() {

});

//管理者:認証なし
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'guest'], function() {
   Route::get('/init_password', [AdminController::class, 'inputInitPassword'])->name('inputInitPassword');
   Route::post('/init_password', [AdminController::class, 'initializePassword'])->name('initializePassword');
});

//管理者:認証あり
Route::resource('admin', AdminController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function() {
    Route::post('/delete', [AdminController::class, 'delete'])->name('delete');
    Route::resource('department', DepartmentController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/department/delete', [DepartmentController::class, 'delete'])->name('department.delete');
    Route::resource('position', PositionController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/position/delete', [PositionController::class, 'delete'])->name('position.delete');
    Route::resource('tag', TagController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/tag/delete', [TagController::class, 'delete'])->name('tag.delete');
    Route::resource('userContactTitle', UserContactTitleController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/userContactTitle/delete', [UserContactTitleController::class, 'delete'])->name('userContactTitle.delete');
    Route::resource('expertContactTitle', ExpertContactTitleController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/expertContactTitle/delete', [ExpertContactTitleController::class, 'delete'])->name('expertContactTitle.delete');
});

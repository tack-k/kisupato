<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Consts;
use \App\Http\Controllers\Users\UserController;
use \App\Http\Controllers\Admins\AdminController;

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

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::group(['prefix' => 'user', 'namespace' => 'Users', 'as' => 'user.'], function() {
//    Route::resources(['users', UserController::class]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Users/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {




    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Dashboard');
    })->middleware(['auth:admin', 'verified'])->name('dashboard');
    Route::get('/sidebar', function() {
       return Inertia::render('Admin/SideBar', ['sideBarLists' => Consts\SideBarConst::SIDEBAR_LISTS]);
    });
});


Route::resource('admin', AdminController::class)->only(['index', 'store']);
Route::post('/admin/deleteMultiple', [AdminController::class, 'delete'])->name('admin.delete');

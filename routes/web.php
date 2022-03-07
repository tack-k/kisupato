<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Consts;
use \App\Http\Controllers\Users\UserController;
use \App\Http\Controllers\Users\ResourceController;
use \App\Http\Controllers\Users\TopController;
use \App\Http\Controllers\Users\ChatroomController;
use \App\Http\Controllers\Users\MessagesController;
use \App\Http\Controllers\Users\UserContactController;
use \App\Http\Controllers\Users\FavoritesController;
use \App\Http\Controllers\Admins\AdminController;
use \App\Http\Controllers\Admins\DepartmentController;
use \App\Http\Controllers\Admins\PositionController;
use \App\Http\Controllers\Admins\TagController;
use \App\Http\Controllers\Admins\UserContactTitleController;
use \App\Http\Controllers\Admins\ExpertContactTitleController;
use \App\Http\Controllers\Experts\ExpertController;
use \App\Http\Controllers\Experts\HomeController;
use \App\Http\Controllers\Experts\MyPageController;
use \App\Http\Controllers\Experts\ExpertProfileController;


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
require __DIR__ . '/expert_auth.php';

//仮置き
Route::get('/dashboard', function () {
    return Inertia::render('Users/Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//})->name('home');

//ユーザー認証なし
Route::get('/', [TopController::class, 'index'])->name('home');

Route::group(['prefix' => 'contact', 'as' => 'contact.'], function() {
    Route::get('/create', [UserContactController::class, 'create'])->name('create');
    Route::post('/confirm', [UserContactController::class, 'confirm'])->name('confirm');
    Route::post('/finish', [UserContactController::class, 'finish'])->name('finish');
});

Route::group(['prefix' => 'resource', 'as' => 'resource.'], function() {
    Route::get('/', [ResourceController::class, 'index'])->name('index');
    Route::post('/card', [ResourceController::class, 'card'])->name('card');
    Route::get('/show/{id}', [ResourceController::class, 'show'])->name('show');
});



//ユーザー:認証なし（認証時リダイレクト）
Route::group(['middleware' => 'guest'], function() {
    Route::get('/register', [UserController::class, 'create'])->name('create');
    Route::post('/register', [UserController::class, 'store'])->name('store');
});


//ユーザー:認証あり
Route::group(['middleware' => 'auth:user'], function () {
    Route::group(['prefix' => 'chatroom', 'as' => 'chatroom.'], function () {
        Route::get('/show/{id}', [ChatroomController::class, 'show'])->name('show');
        Route::post('/store', [ChatroomController::class, 'store'])->name('store');
    });
    Route::group(['prefix' => 'message', 'as' => 'message.'], function() {
       Route::post('store', [MessagesController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'favorite', 'as' => 'favorite.'], function() {
       Route::post('/switch', [FavoritesController::class, 'switch'])->name('switch');
       Route::get('/', [FavoritesController::class, 'index'])->name('index');
       Route::post('/delete', [FavoritesController::class, 'delete'])->name('delete');
    });
});


//専門家:認証なし
Route::group(['prefix' => 'expert', 'as' => 'expert.', 'middleware' => 'guest'], function () {
    Route::get('/register', [ExpertController::class, 'create'])->name('create');
    Route::post('/register', [ExpertController::class, 'store'])->name('store');
});


//専門家:認証あり
Route::group(['prefix' => 'expert', 'as' => 'expert.', 'middleware' => 'auth:expert'], function () {
    //トップページ
    Route::get('/', [HomeController::class, 'top'])->middleware(['verified'])->name('home');
    Route::get('/my_page', [MyPageController::class, 'top'])->name('myPage.top');
    Route::get('/profile/show', [ExpertProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/input', [ExpertProfileController::class, 'input'])->name('profile.input');
    Route::post('/profile/input', [ExpertProfileController::class, 'update'])->name('profile.update');
    Route::post('profile/status', [ExpertProfileController::class, 'status'])->name('profile.status');

});

//管理者:認証なし
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'guest'], function () {
    Route::get('/init_password', [AdminController::class, 'inputInitPassword'])->name('inputInitPassword');
    Route::post('/init_password', [AdminController::class, 'initializePassword'])->name('initializePassword');
});

//管理者:認証あり
Route::resource('admin', AdminController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth:admin'], function () {
    Route::post('/delete', [AdminController::class, 'delete'])->name('delete');
    Route::resource('department', DepartmentController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/department/delete', [DepartmentController::class, 'delete'])->name('department.delete');
    Route::resource('position', PositionController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/position/delete', [PositionController::class, 'delete'])->name('position.delete');
    Route::resource('tag', TagController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/tag/delete', [TagController::class, 'delete'])->name('tag.delete');
    Route::resource('user_contact_title', UserContactTitleController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/user_contact_title/delete', [UserContactTitleController::class, 'delete'])->name('userContactTitle.delete');
    Route::resource('expert_contact_title', ExpertContactTitleController::class)->only(['index', 'store', 'edit', 'update'])->middleware('auth:admin');
    Route::post('/expert_contact_title/delete', [ExpertContactTitleController::class, 'delete'])->name('expertContactTitle.delete');
});

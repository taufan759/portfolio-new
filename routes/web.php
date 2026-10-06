<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/books', [BookController::class, 'index'])->name('books.index');
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ResourceController;

Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1');
    });

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('news/fetch', [DashboardController::class, 'fetchNews'])->name('admin.news.fetch');

        Route::prefix('{resource}')->where(['resource' => 'projects|certificates|books|posts|messages'])->group(function () {
            Route::get('/', [ResourceController::class, 'index'])->name('admin.index');
            Route::get('create', [ResourceController::class, 'create'])->name('admin.create');
            Route::post('/', [ResourceController::class, 'store'])->name('admin.store');
            Route::get('{id}/edit', [ResourceController::class, 'edit'])->name('admin.edit');
            Route::put('{id}', [ResourceController::class, 'update'])->name('admin.update');
            Route::delete('{id}', [ResourceController::class, 'destroy'])->name('admin.destroy');
        });
    });
});

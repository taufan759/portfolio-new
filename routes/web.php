<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SeoController;
use App\Http\Middleware\SetLocale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// "/" sends visitors to their language: saved choice, then browser language, then Indonesian.
Route::get('/', function (Request $request) {
    $saved = $request->cookie('lang');
    $locale = in_array($saved, SetLocale::LOCALES, true)
        ? $saved
        : ($request->getPreferredLanguage(SetLocale::LOCALES) ?? 'id');

    return redirect('/'.$locale, 302);
})->name('root');

Route::get('sitemap.xml', [SeoController::class, 'sitemap']);
Route::get('robots.txt', [SeoController::class, 'robots']);
Route::get('llms.txt', [SeoController::class, 'llms']);
Route::get('llms-full.txt', [SeoController::class, 'llmsFull']);
Route::get('ai.txt', [SeoController::class, 'aiTxt']);
Route::get('.well-known/ai.txt', [SeoController::class, 'aiTxt']);

Route::post('/contact', [ContactController::class, 'store'])->middleware('throttle:5,1')->name('contact.store');

Route::prefix('{locale}')->where(['locale' => 'id|en'])->middleware(SetLocale::class)->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('about', [AboutController::class, 'index'])->name('about');
    Route::get('gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
    Route::get('projects/{slug}', [ProjectController::class, 'show'])->name('projects.show');
    Route::get('blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
    Route::get('books', [BookController::class, 'index'])->name('books.index');
    Route::get('news', [NewsController::class, 'index'])->name('news.index');
    Route::get('search.json', [SearchController::class, 'index'])->name('search.index');
});

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryBulkController;
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
        Route::post('gallery-bulk', [GalleryBulkController::class, 'store'])->name('admin.gallery.bulk');

        Route::prefix('{resource}')->where(['resource' => 'projects|certificates|books|posts|profile|events|gallery|partners|messages'])->group(function () {
            Route::get('/', [ResourceController::class, 'index'])->name('admin.index');
            Route::get('create', [ResourceController::class, 'create'])->name('admin.create');
            Route::post('/', [ResourceController::class, 'store'])->name('admin.store');
            Route::get('{id}/edit', [ResourceController::class, 'edit'])->name('admin.edit');
            Route::put('{id}', [ResourceController::class, 'update'])->name('admin.update');
            Route::delete('{id}', [ResourceController::class, 'destroy'])->name('admin.destroy');
        });
    });
});

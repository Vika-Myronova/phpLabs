<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReaderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
//use App\Http\Controllers\TestController;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});
//Route::get('/test', [TestController::class, 'test']);

Route::get('products', [ProductController::class, 'index']);
Route::get('products/{id}', [ProductController::class, 'show']);
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{id}', [ProductController::class, 'update']);
Route::delete('products/{id}', [ProductController::class, 'destroy']);

Route::resource('authors', AuthorController::class);
Route::resource('books', BookController::class);
Route::resource('categories', CategoryController::class);
Route::resource('readers', ReaderController::class);
Route::resource('borrowings', BorrowingController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

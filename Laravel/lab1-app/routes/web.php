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

Route::middleware('auth:api')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->middleware('role:ROLE_CLIENT');

    Route::get('products/{id}', [ProductController::class, 'show'])->middleware('role:ROLE_CLIENT');

    Route::post('products', [ProductController::class, 'store'])->middleware('role:ROLE_ADMIN,ROLE_MANAGER');

    Route::put('products/{id}', [ProductController::class, 'update'])->middleware('role:ROLE_ADMIN,ROLE_MANAGER');

    Route::delete('products/{id}', [ProductController::class, 'destroy'])->middleware('role:ROLE_ADMIN');
});

Route::resource('authors', AuthorController::class);
Route::resource('books', BookController::class);
Route::resource('categories', CategoryController::class);
Route::resource('readers', ReaderController::class);
Route::resource('borrowings', BorrowingController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

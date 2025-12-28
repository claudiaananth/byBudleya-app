<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('/menu',[ProductController::class, 'index'])->name('menu.index');


Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/products',[ProductController::class, 'indexAdmin'])->name('products.index');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');
    Route::put('/products/{product}', [ProductController::class, "update"])->name('products.update');
    Route::delete('/products/{product}', [ProductController::class, "destroy"])->name('products.destroy');
    Route::get('/products/create', [ProductController::class, "create"])->name('products.create');
    Route::get('/products/{product}/edit', [ProductController::class, "edit"])->name('products.edit');
    
});



require __DIR__.'/settings.php';

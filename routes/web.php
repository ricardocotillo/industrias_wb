<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\MarcaAPIController;
use App\Http\Controllers\ProductoAPIController;
use App\Http\Controllers\ModeloAPIController;
use Illuminate\Support\Facades\Artisan;

/**
 * Homepage controller.
 *
 * This function is the controller for the homepage. It fetches the featured and
 * promoted products from the database and passes them to the view.
 *
 * @return \Illuminate\View\View
 */
Route::get('/', function () {
    Artisan::call('optimize:clear');
    $featured_products = Producto::where('destacado', true)->limit(10)->get();
    $promoted_products = Producto::where('promocion', true)->limit(10)->get();
    $page = [
        'title' => 'Industrias Willy Busch',
        'search_description' => 'Búsqueda de productos',
    ];

    return view('home.home_page', compact('featured_products', 'promoted_products', 'page'));
})->name('home');

Route::get('/about', function () {
    $page = [
        'title' => 'Industrias Willy Busch',
        'search_description' => 'Acerca de Industrias Willy Busch',
    ];
    return view('home.about_page', compact('page'));
})->name('about');

Route::get('/contact', function () {
    $page = [
        'title' => 'Industrias Willy Busch',
        'search_description' => 'Contacto Industrias Willy Busch',
    ];
    return view('home.contact_page', compact('page'));
})->name('contact');
    

Route::post('/contact/email', [ContactController::class, 'email'])->name('contact.email');
Route::post('/contact/quote', [ContactController::class, 'quote'])->name('contact.quote');

Route::prefix('productos')->group(function () {
    Route::resource('productos', ProductoController::class);
    Route::get('/search', [ProductoController::class, 'search'])->name('products.search');
    Route::get('/cart', [ProductoController::class, 'cart'])->name('products.cart');
    Route::post('/cart/update', [ProductoController::class, 'cart_update'])->name('products.cart_update');
    Route::post('/cart/delete', [ProductoController::class, 'cart_delete'])->name('products.cart_delete');
    Route::get('/{slug}', [ProductoController::class, 'line'])->name('products.line');
});

Route::prefix('api')->group(function () {
    Route::resource('productos', ProductoAPIController::class)->only(['index'])->names('api.productos');
    Route::resource('modelos', ModeloAPIController::class)->only(['index'])->names('api.modelos');
    Route::resource('marcas', MarcaAPIController::class)->only('index')->names('api.marcas');
});

# create route to run optimize:clear
Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    return redirect()->back();
});

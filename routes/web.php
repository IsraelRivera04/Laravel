<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\ComplementoController;
use App\Http\Controllers\segundaManoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ComentarioController;


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

Route::get('', function () {
    return view('inicio');
})->name('inicio');

/*
Route::get('/juegos', function () {
    return view('juegos.index');
})->name('juegos_index');

Route::get('/juegos/{id}', function ($id) {
    return view('juegos.show', ['id' => $id]);
})->where('id', '[0-9]+')
->name('juegos_show');
*/

Route::middleware(['auth'])->group(function () {
    Route::resource('juegos', JuegoController::class);
    Route::resource('segundaMano', segundaManoController::class);
    Route::resource('complementos', ComplementoController::class);
});

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
Route::post('/usuarioUnico', [RegisterController::class, 'usuarioUnico'])->name('usuarioUnico');
Route::post('/emailUnico', [RegisterController::class, 'emailUnico'])->name('emailUnico');

Route::get('/compra/finalizar', [CompraController::class, 'finalizar'])->name('compra.finalizar');
Route::post('/compra/procesar', [CompraController::class, 'procesar'])->name('compra.procesar');
Route::get('/compra/descargarPDF', [CompraController::class, 'descargarPDF'])->name('compra.descargarPDF');



Route::middleware(['auth'])->group(function () {
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/actualizar/{item}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/eliminar/{item}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::delete('/carrito/vaciar', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
});

Route::post('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');

Route::resource('eventos', EventoController::class);
Route::post('/eventos/{evento}/inscribirse', [EventoController::class, 'inscribirse'])
    ->name('eventos.inscribirse')
    ->middleware('auth');
Route::post('/juegos/{juego}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
Route::post('juegos/asignar-ofertas', [JuegoController::class, 'asignarOfertas'])->name('juegos.asignarOfertas');

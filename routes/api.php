<?php
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\JuegoController;
use App\Http\Controllers\ComplementoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\segundaManoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\ComentarioController;



//MI CUENTA
Route::middleware('auth:sanctum')->get('/usuarios/me', function (Request $request) {
    return response()->json($request->user());
});

//JUEGOS
Route::get('/juegos', [JuegoController::class, 'index']);

Route::get('/juegos/{id}', [JuegoController::class, 'show']); 

//LOGIN-LOGOUT
Route::post('/login', [LoginController::class, 'login']);

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/user', [LoginController::class, 'user'])->middleware('auth:sanctum');

//COMPLEMENTOS
Route::get('/complementos', [ComplementoController::class, 'index']);

Route::get('/complementos/{id}', [ComplementoController::class, 'show']);

//EVENTOS
Route::get('/eventos', [EventoController::class, 'index']);

Route::get('/eventos/{id}', [EventoController::class, 'show']);

//REGISTRO
Route::post('register', function (Request $request) {
    $request->validate([
        'username' => 'required|string|min:3|unique:usuarios,username',
        'email' => 'required|email|unique:usuarios,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user = Usuario::create([
        'username' => $request->username,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    $token = $user->createToken('AppName')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ]);
});

//PÁGINA DE INICIO
Route::get('/juegos-destacados', [HomeController::class, 'juegosDestacados']);

Route::get('/complementos-populares', [HomeController::class, 'complementosPopulares']);

Route::get('/proximos-eventos', [HomeController::class, 'proximosEventos']);

//EVENTOS INSCRIPCIÓN
Route::prefix('eventos')->group(function () {
    Route::get('{id}/participantes', [EventoController::class, 'obtenerParticipantes']);
});
Route::post('eventos/{evento}/inscribirse', [EventoController::class, 'inscribirse']);

//SEGUNDA MANO
Route::get('/segunda-mano', [segundaManoController::class, 'index']);
Route::get('/segunda-mano/{id}', [segundaManoController::class, 'show']);

//CARRITO
Route::post('/carrito/agregar', [CarritoController::class, 'agregar'])->middleware('auth:sanctum');

Route::get('/carrito', [CarritoController::class, 'obtenerCarritoApi'])->middleware('auth:sanctum');

Route::delete('/carrito/eliminar/{itemId}', [ CarritoController::class, 'eliminarItem'])->middleware('auth:sanctum');

Route::put('/carrito/actualizar/{itemId}', [ CarritoController::class, 'actualizarCantidad'])->middleware('auth:sanctum');

Route::delete('carrito/vaciar', [ CarritoController::class, 'vaciarCarrito'])->middleware('auth:sanctum');

Route::post('/compra/procesar', [CompraController::class, 'procesarCompra'])->middleware('auth:sanctum');

Route::get('/compra/confirmacion/{pedido}', [ CompraController::class, 'mostrarConfirmacion'])->middleware('auth:sanctum');

Route::get('/compra/descargarPDF/{pedido}', [ CompraController::class, 'descargarPDF'])->middleware('auth:sanctum');

//COMENTARIOS
Route::post('/juegos/{juego}/comentarios', [ComentarioController::class, 'storeComentario'])->middleware('auth:sanctum');

Route::get('juegos/{juegoId}/comentarios', [ComentarioController::class, 'index'])->middleware('auth:sanctum');


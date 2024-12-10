<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class CompraController extends Controller
{
    public function finalizar()
    {
        $carrito = Carrito::where('usuario_id', auth()->id())->first();

        if (!$carrito || $carrito->items->isEmpty()) {
            return response()->json(['error' => 'No hay productos en el carrito.'], 400);
        }

        return view('compra.finalizar', compact('carrito'));
    }

    public function procesar(Request $request)
    {
        $request->validate([
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'metodo_pago' => 'required|string',
        ]);

        // Crear el pedido
        $pedido = Order::create([
            'usuario_id' => auth()->id(),
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'metodo_pago' => $request->metodo_pago,
            'estado' => 'pendiente',
            'total' => $this->calcularTotal(),
        ]);

        $carrito = Carrito::where('usuario_id', auth()->id())->first();

        // Crear los items del pedido
        foreach ($carrito->items as $item) {
            $pedido->items()->create([
                'producto_id' => $item->producto_id,
                'producto_type' => $item->producto_type,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
            ]);
        }

        // Limpiar el carrito
        $carrito->items()->delete();

        // Si la petición es de tipo JSON
        if ($request->wantsJson()) {
            return response()->json([
                'success' => 'Pedido procesado con éxito.',
                'pedido' => $pedido
            ]);
        }

        // Si la petición es para renderizar una vista
        return view('compra.factura', compact('pedido'));
    }

    public function procesarCompra(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'direccion' => 'required|string|max:255',
        'telefono' => 'required|string|max:15',
        'metodo_pago' => 'required|string',
    ]);

    $usuario = Auth::user();

    if (!$usuario) {
        return response()->json(['error' => 'Usuario no autenticado.'], 401);
    }


    // Buscar el carrito
    $carrito = Carrito::where('usuario_id', auth()->id())->first();


    // Validar la existencia del carrito
    if (!$carrito) {
        return response()->json(['error' => 'No se encontró un carrito para este usuario.'], 404);
    }


    // Validar si el carrito tiene items
    if ($carrito->items->isEmpty()) {
        return response()->json(['error' => 'El carrito está vacío.'], 400);
    }


    // Crear el pedido
    $pedido = Order::create([
        'usuario_id' => auth()->id(),
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
        'metodo_pago' => $request->metodo_pago,
        'estado' => 'pendiente',
        'total' => $this->calcularTotal(),
    ]);


    // Crear los items del pedido
    foreach ($carrito->items as $item) {
        $pedido->items()->create([
            'producto_id' => $item->producto_id,
            'producto_type' => $item->producto_type,
            'cantidad' => $item->cantidad,
            'precio_unitario' => $item->precio_unitario,
        ]);
    }


    // Limpiar el carrito
    $carrito->items()->delete();


    // Respuesta JSON
    return response()->json([
        'success' => 'Compra procesada con éxito.',
        'pedido' => $pedido
    ]);
}




    private function calcularTotal()
    {
        $total = 0;
        $carrito = Carrito::where('usuario_id', auth()->id())->first();
        foreach ($carrito->items as $item) {
            $total += $item->cantidad * $item->precio_unitario;
        }

        return $total;
    }

    public function descargarPDF()
    {
        $usuario = Auth::user();

        if(!$usuario) {
            return response()->json(['error'=> 'No autenticado'], 401);
        }
        $pedido = Order::where('usuario_id', auth()->id())->latest()->first();

        if (!$pedido) {
            return response()->json(['error' => 'No se encontró el pedido.'], 404);
        }

        // Generar el PDF
        $pdf = \PDF::loadView('compra.factura_pdf', compact('pedido'));

        // Si la petición es de tipo JSON
        if (request()->wantsJson()) {
            return response()->json([
                'success' => 'Factura generada con éxito.',
                'pdf_url' => url('factura/' . $pedido->id . '.pdf')
            ]);
        }

        // Descargar el PDF
        return $pdf->download('factura_confirmacion_compra.pdf');
    }

    public function mostrarConfirmacion($pedidoId)
    {
        // Buscar el pedido por su ID
        $pedido = Order::with('usuario', 'items.producto')->find($pedidoId);


        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado.'], 404);
        }


        // Verificar que el pedido pertenece al usuario autenticado
        if ($pedido->usuario_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }


        // Devolver los detalles del pedido
        return response()->json([
            'success' => true,
            'pedido' => $pedido
        ]);
    }

}



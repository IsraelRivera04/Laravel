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

        $pedido = Order::create([
            'usuario_id' => auth()->id(),
            'direccion' => $request->direccion,
            'telefono' => $request->telefono,
            'metodo_pago' => $request->metodo_pago,
            'estado' => 'pendiente',
            'total' => $this->calcularTotal(),
        ]);

        $carrito = Carrito::where('usuario_id', auth()->id())->first();

        foreach ($carrito->items as $item) {
            $pedido->items()->create([
                'producto_id' => $item->producto_id,
                'producto_type' => $item->producto_type,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
            ]);
        }

        $carrito->items()->delete();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => 'Pedido procesado con éxito.',
                'pedido' => $pedido
            ]);
        }

        return view('compra.factura', compact('pedido'));
    }

    public function procesarCompra(Request $request)
{
    $request->validate([
        'direccion' => 'required|string|max:255',
        'telefono' => 'required|string|max:15',
        'metodo_pago' => 'required|string',
    ]);

    $usuario = Auth::user();

    if (!$usuario) {
        return response()->json(['error' => 'Usuario no autenticado.'], 401);
    }

    $carrito = Carrito::where('usuario_id', auth()->id())->first();

    if (!$carrito) {
        return response()->json(['error' => 'No se encontró un carrito para este usuario.'], 404);
    }

    if ($carrito->items->isEmpty()) {
        return response()->json(['error' => 'El carrito está vacío.'], 400);
    }

    $pedido = Order::create([
        'usuario_id' => auth()->id(),
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
        'metodo_pago' => $request->metodo_pago,
        'estado' => 'pendiente',
        'total' => $this->calcularTotal(),
    ]);

    foreach ($carrito->items as $item) {
        $pedido->items()->create([
            'producto_id' => $item->producto_id,
            'producto_type' => $item->producto_type,
            'cantidad' => $item->cantidad,
            'precio_unitario' => $item->precio_unitario,
        ]);
    }

    $carrito->items()->delete();

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

        $pdf = \PDF::loadView('compra.factura_pdf', compact('pedido'));

        if (request()->wantsJson()) {
            return response()->json([
                'success' => 'Factura generada con éxito.',
                'pdf_url' => url('factura/' . $pedido->id . '.pdf')
            ]);
        }

        return $pdf->download('factura_confirmacion_compra.pdf');
    }

    public function mostrarConfirmacion($pedidoId)
    {

        $pedido = Order::with('usuario', 'items.producto')->find($pedidoId);

        if (!$pedido) {
            return response()->json(['error' => 'Pedido no encontrado.'], 404);
        }

        if ($pedido->usuario_id !== auth()->id()) {
            return response()->json(['error' => 'No autorizado.'], 403);
        }

        return response()->json([
            'success' => true,
            'pedido' => $pedido
        ]);
    }

}



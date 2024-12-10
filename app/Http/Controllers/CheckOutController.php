<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $carrito = $this->obtenerCarrito();

        $order = Order::create([
            'user_id' => auth()->id(),
            'total' => $carrito->total()
        ]);

        foreach ($carrito->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'producto_id' => $item->producto_id,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario
            ]);
        }

        $this->vaciarCarrito();

        return redirect()->route('carrito.index')->with('success', 'Pedido realizado con éxito.');
    }
}


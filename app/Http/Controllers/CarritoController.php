<?php

namespace App\Http\Controllers;

use App\Models\Carrito;
use App\Models\Juego;
use App\Models\Complemento;
use App\Models\SegundaManoJuego;
use App\Models\CarritoItem;
use App\Mail\NotificarReponerStock;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function index()
    {
        $carrito = Carrito::where('usuario_id', Auth::id())->first();

        if (request()->wantsJson()) {
            return response()->json([
                'carrito' => $carrito
            ]);
        }

        return view('carrito.index', compact('carrito'));
    }

    protected function obtenerCarrito()
    {
        if (auth()->check()) {
            return Carrito::firstOrCreate([
                'usuario_id' => auth()->user()->id,
            ]);
        } else {
            $session_id = session()->getId();
            return Carrito::firstOrCreate([
                'session_id' => $session_id,
            ]);
        }
    }

    public function obtenerCarritoApi()
{
    $carrito = $this->obtenerCarrito();

    if (!$carrito || $carrito->items->isEmpty()) {
        return response()->json([
            'message' => 'Tu carrito está vacío.',
            'carrito' => [],
            'total' => 0,
        ], 200);
    }

    $total = $carrito->total();

    return response()->json([
        'carrito' => $carrito->load('items.producto'),
        'total' => $total,
    ], 200);
}


    public function agregar(Request $request)
    {
        $carrito = $this->obtenerCarrito();

        $request->validate([
            'producto_id' => 'required|integer',
            'cantidad' => 'required|integer|min:1',
            'tipo' => 'required|string|in:juego,complemento,segunda_mano',
        ]);

        $usuario_id = auth()->user() ? auth()->user()->id : null;
        $session_id = $usuario_id ? null : session()->getId();

        if ($request->tipo === 'juego') {
            $producto = Juego::find($request->producto_id);
            $productoType = 'App\Models\Juego';
        } elseif ($request->tipo === 'complemento') {
            $producto = Complemento::find($request->producto_id);
            $productoType = 'App\Models\Complemento';
        } elseif ($request->tipo === 'segunda_mano') {
            $producto = SegundaManoJuego::find($request->producto_id);
            $productoType = 'App\Models\SegundaManoJuego';
        } else {
            return back()->with('error', 'Tipo de producto no válido.');
        }

        if (!$producto) {
            return back()->with('error', 'Producto no encontrado.');
        }

        $precioFinal = $producto->oferta ? $producto->precio_oferta : $producto->precio;

        $itemExistente = $carrito->items()
            ->where('producto_id', $request->producto_id)
            ->where('producto_type', $productoType)
            ->first();

        if ($request->tipo !== 'segunda_mano' && $producto->stock < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        if ($request->tipo === 'segunda_mano' && $itemExistente) {
            return back()->with('error', 'El juego de segunda mano ya está en tu carrito.');
        }

        if ($request->tipo !== 'segunda_mano') {
            $producto->stock -= $request->cantidad;
            $producto->save();

            if ($producto->stock == 0) {
                Mail::to('israelriveracastillo004@gmail.com')->send(new NotificarReponerStock($producto));
                \Log::info('Correo de notificación enviado al administrador.');
            }
        }

        if ($itemExistente) {
            $itemExistente->cantidad += $request->cantidad;
            $itemExistente->save();
        } else {
            $carrito->items()->create([
                'producto_id' => $producto->id,
                'producto_type' => $productoType,
                'cantidad' => $request->tipo === 'segunda_mano' ? 1 : $request->cantidad,
                'precio_unitario' => $precioFinal,
                'usuario_id' => $usuario_id,
                'session_id' => $session_id,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => 'Producto añadido al carrito.',
                'carrito' => $carrito
            ]);
        }

        return back()->with('success', 'Producto añadido al carrito.');
    }

    public function actualizar(Request $request, CarritoItem $item)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $nuevaCantidad = $request->cantidad;
        $diferenciaCantidad = $nuevaCantidad - $item->cantidad;

        if ($item->producto_type === 'App\Models\Juego') {
            $producto = Juego::find($item->producto_id);
        } elseif ($item->producto_type === 'App\Models\Complemento') {
            $producto = Complemento::find($item->producto_id);
        }

        if (isset($producto) && $item->producto_type !== 'App\Models\SegundaManoJuego') {
            if ($diferenciaCantidad > 0) {
                if ($producto->stock < $diferenciaCantidad) {
                    return redirect()->route('carrito.index')->with('error', 'No hay suficiente stock disponible.');
                }
                $producto->stock -= $diferenciaCantidad;
            } elseif ($diferenciaCantidad < 0) {
                $producto->stock += abs($diferenciaCantidad);
            }
            $producto->save();
        }

        $item->cantidad = $nuevaCantidad;
        $item->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => 'Cantidad actualizada y stock ajustado.',
                'carrito' => $this->obtenerCarrito()
            ]);
        }

        return redirect()->route('carrito.index')->with('success', 'Cantidad actualizada y stock ajustado.');
    }

    public function actualizarCantidad($itemId, Request $request)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);
    
        $carrito = Carrito::where('usuario_id', auth()->id())->first();
    
        $item = $carrito->items()->find($itemId);
    
        if (!$item) {
            return response()->json(['error' => 'Producto no encontrado en el carrito.'], 404);
        }
    
        $nuevaCantidad = $request->cantidad;
        $diferenciaCantidad = $nuevaCantidad - $item->cantidad;
    
        if ($item->producto_type === 'App\Models\Juego') {
            $producto = Juego::find($item->producto_id);
        } elseif ($item->producto_type === 'App\Models\Complemento') {
            $producto = Complemento::find($item->producto_id);
        }
    
        if (isset($producto) && $item->producto_type !== 'App\Models\SegundaManoJuego') {
            if ($diferenciaCantidad > 0) {
                if ($producto->stock < $diferenciaCantidad) {
                    return response()->json(['error' => 'No hay suficiente stock disponible.'], 422);
                }
                $producto->stock -= $diferenciaCantidad;
            } elseif ($diferenciaCantidad < 0) {
                $producto->stock += abs($diferenciaCantidad);
            }
            $producto->save();
        }
    
        $item->cantidad = $nuevaCantidad;
        $item->save();
    
        return response()->json(['success' => 'Cantidad actualizada correctamente.']);
    }
    
    
    

    public function eliminar(CarritoItem $item)
    {
        if ($item->producto_type === 'App\Models\Juego') {
            $producto = Juego::find($item->producto_id);
        } elseif ($item->producto_type === 'App\Models\Complemento') {
            $producto = Complemento::find($item->producto_id);
        }

        if (isset($producto) && $item->producto_type !== 'App\Models\SegundaManoJuego') {
            $producto->stock += $item->cantidad;
            $producto->save();
        }

        $item->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => 'Artículo eliminado del carrito y stock actualizado.',
                'carrito' => $this->obtenerCarrito()
            ]);
        }

        return redirect()->route('carrito.index')->with('success', 'Artículo eliminado del carrito y stock actualizado.');
    }


    public function eliminarItem($itemId)
    {
        $carrito = Carrito::where('usuario_id', auth()->id())->first();
    
        $item = $carrito->items()->find($itemId);
    
        if (!$item) {
            return response()->json(['error' => 'Producto no encontrado en el carrito.'], 404);
        }

        if ($item->producto_type === 'App\Models\Juego') {
            $producto = Juego::find($item->producto_id);
        } elseif ($item->producto_type === 'App\Models\Complemento') {
            $producto = Complemento::find($item->producto_id);
        }
    
        if (isset($producto) && $item->producto_type !== 'App\Models\SegundaManoJuego') {
            $producto->stock += $item->cantidad;
            $producto->save();
        }

        $item->delete();
    
        return response()->json(['success' => 'Producto eliminado del carrito.']);
    }
    
    
    

    public function vaciar()
    {
        $carrito = $this->obtenerCarrito();

        foreach ($carrito->items as $item) {
            if ($item->producto_type === 'App\Models\Juego') {
                $producto = Juego::find($item->producto_id);
            } elseif ($item->producto_type === 'App\Models\Complemento') {
                $producto = Complemento::find($item->producto_id);
            }

            if (isset($producto) && $item->producto_type !== 'App\Models\SegundaManoJuego') {
                $producto->stock += $item->cantidad;
                $producto->save();
            }
        }

        $carrito->items()->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => 'Carrito vaciado y stock actualizado.',
                'carrito' => $this->obtenerCarrito()
            ]);
        }

        return redirect()->route('carrito.index')->with('success', 'Carrito vaciado y stock actualizado.');
    }

    public function vaciarCarrito()
{
    $carrito = Carrito::where('usuario_id', auth()->id())->first();

    if (!$carrito || $carrito->items->isEmpty()) {
        return response()->json(['error' => 'El carrito ya está vacío.'], 404);
    }

    foreach ($carrito->items as $item) {
        if ($item->producto_type === 'App\Models\Juego') {
            $producto = Juego::find($item->producto_id);
        } elseif ($item->producto_type === 'App\Models\Complemento') {
            $producto = Complemento::find($item->producto_id);
        }

        if (isset($producto) && $item->producto_type !== 'App\Models\SegundaManoJuego') {
            $producto->stock += $item->cantidad;
            $producto->save();
        }
    }
    $carrito->items()->delete();

    return response()->json(['success' => 'Carrito vaciado correctamente.']);
}




}


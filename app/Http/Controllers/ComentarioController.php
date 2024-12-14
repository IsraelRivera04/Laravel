<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Juego;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(Request $request, Juego $juego)
    {
    $request->validate([
        'comentario' => 'required|string|max:1000',
        'valoracion' => 'required|numeric|min:1|max:10',
    ]);

    Comentario::create([
        'juego_id' => $juego->id,
        'usuario_id' => auth()->id(),
        'comentario' => $request->comentario,
        'valoracion' => $request->valoracion,
    ]);

    $juego->actualizarRating();
    if ($juego->comentarios()->where('usuario_id', auth()->id())->exists()) {
        return redirect()->back()->withErrors('Ya has valorado este juego.');
    }
    return redirect()->route('juegos.show', $juego)->with('success', 'Comentario y valoración añadidos con éxito.');
    }

    public function storeComentario(Request $request, $juegoId)
    {
        $validatedData = $request->validate([
            'comentario' => 'required|string|max:1000',
            'valoracion' => 'required|integer|min:1|max:10',
        ]);
        $juego = Juego::findOrFail($juegoId);

        $comentario = new Comentario();
        $comentario->comentario = $validatedData['comentario'];
        $comentario->valoracion = $validatedData['valoracion'];
        $comentario->juego_id = $juego->id;
        $comentario->usuario_id = auth()->id(); 
        $comentario->save();

        return response()->json([
            'message' => 'Comentario creado con éxito',
            'comentario' => $comentario,
        ], 201);
    }

    public function index($juegoId)
    {
        $juego = Juego::with('comentarios.usuario')->findOrFail($juegoId);

        return response()->json($juego->comentarios);
    }

}


<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JuegoController extends Controller
{
    public function index()
    {
        $juegos = Juego::all();
        return response()->json($juegos);
    }

    public function store(Request $request)
    {
        $validar = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'edicion' => 'nullable|string|max:50',
            'num_jugadores_min' => 'required|integer|min:1',
            'num_jugadores_max' => 'required|integer|min:1',
            'edad_recomendada' => 'required|integer|min:1',
            'duracion_aprox' => 'nullable|integer|min:0',
            'editor' => 'nullable|string|max:100',
            'disenador' => 'nullable|string|max:100',
            'ano_publicacion' => 'nullable|integer',
            'dureza' => 'nullable|numeric|min:1|max:5',
            'precio' => 'nullable|numeric|min:1',
            'rating' => 'nullable|numeric|min:1|max:10',
            'imagen' => 'nullable|imagen|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'stock' => 'nullable|integer|min:0',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.max' => 'El nombre es demasiado largo (máximo 100 caracteres).',
            'edicion.max' => 'Le edición es demasiado larga (máximo 50 caracteres).',
            'num_jugadores_min.required' => 'El número mínimo de jugadores es obligatorio.',
            'num_jugadores_min.min' => 'El número mínimo de jugadores es 1.',
            'num_jugadores_max.required' => 'El número máximo de jugadores es obligatorio.',
            'num_jugadores_max.min' => 'El número mínimo de jugadores es 1.',
            'edad_recomendada.required' => 'La edad mínima recomendada es obligatoria.',
            'edad_recomendada.min' => 'La edad mínima recomendada es 1.',
            'duracion_aprox.min' => 'La duración mínima es 1.',
            'editor.max' => 'El editor es demasiado largo (máximo 100 caracteres).',
            'disenador.max' => 'El diseñador es demasiado largo (máximo 100 caracteres).',
            'dureza.min' => 'La dureza mínima es 1.',
            'dureza.max' => 'La dureza máxima es 5.',
            'precio.min' => 'EL precio tiene que ser mayor que 0.',
            'rating.min' => 'El rating mínimo es 1.',
            'rating.max' => 'El rating máximo es 10.',
            'stock.min' => 'El stock mínimo es 0.',
        ]);
        if($request->hasFile('imagen')) {
            $path = $request->file('image')->store('public/images');
            $imageUrl = Storage::url($path);
        } else {
            $imageUrl = null;
        }
        Juego::create($request->all());


        return response()->json($juego, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juego = Juego::findOrFail($id);
        return response()->json($juego);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

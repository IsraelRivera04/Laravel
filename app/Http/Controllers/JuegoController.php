<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Complemento;
use Illuminate\Http\Request;

class JuegoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $juegos = Juego::query();
    
        // Filtro opcional por ofertas
        if ($request->has('oferta') && $request->oferta == '1') {
            $juegos->where('oferta', true);
        }
    
        // Paginar los resultados
        $juegos = $juegos->paginate(10);
    
        // Si la solicitud espera JSON (usado por Angular)
        if ($request->wantsJson()) {
            return response()->json($juegos, 200);
        }
    
        // Si la solicitud espera una vista (usado por Laravel)
        return view('juegos.index', compact('juegos'));
    }
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Juego::class);
        
        return view('juegos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
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
            'imagen' => 'nullable|mimes:jpeg,png,jpg|max:2048',
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
            'imagen.max' => 'La imagen es demasiado grande',
            'stock.min' => 'El stock mínimo es 0.',
        ]);

        $juego = new Juego($request->all());

        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $imagen = $request->file('imagen');
            $juego->imagen = base64_encode(file_get_contents($imagen->getRealPath()));
        } else {
            $juego->imagen = base64_encode('No hay imagen para este juego por el momento');
        }

        $juego->save();
        return redirect()->route('juegos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    $juego = Juego::find($id); // Busca el juego por su ID

    if (!$juego) {
        return response()->json(['error' => 'Juego no encontrado'], 404);
    }

    return response()->json($juego); // Retorna el juego en formato JSON
    }
    public function showView($id)
{
    $juego = Juego::find($id); // Busca el juego por su ID

    if (!$juego) {
        return redirect()->route('juegos.index')->with('error', 'Juego no encontrado.');
    }

    return view('juegos.show', compact('juego')); // Retorna la vista del detalle
}



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $juego = Juego::findOrFail($id);
        return view('juegos.edit', compact('juego'));
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
    $juego = Juego::findOrFail($id);

    $this->authorize('update', $juego);

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
        'imagen' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        'stock' => 'nullable|integer|min:0',
    ], [
        'nombre.required' => 'El nombre es obligatorio.',
        'nombre.max' => 'El nombre es demasiado largo (máximo 100 caracteres).',
        'edicion.max' => 'La edición es demasiado larga (máximo 50 caracteres).',
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
        'precio.min' => 'El precio tiene que ser mayor que 0.',
        'rating.min' => 'El rating mínimo es 1.',
        'rating.max' => 'El rating máximo es 10.',
        'stock.min' => 'El stock mínimo es 0.',
    ]);

    $juego->fill($validar);

    if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
        $imagen = $request->file('imagen');
        $juego->imagen = base64_encode(file_get_contents($imagen->getRealPath()));
    } else {
        $juego->imagen = base64_encode('No hay imagen para este juego por el momento');
    }

    $juego->save();

    return redirect()->route('juegos.show', $juego->id)->with('success', 'Juego actualizado correctamente');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $juego = Juego::findOrFail($id);
        $juego->delete();
        return redirect()->route('juegos.index');
    }

    public function asignarOfertas()
{
    Juego::where('oferta', true)->update([
        'oferta' => false,
        'precio_oferta' => null, 
    ]);

    $juegosSinOferta = Juego::where('oferta', false)->get();

    if ($juegosSinOferta->count() < 5) {
        return back()->with('error', 'No hay suficientes juegos disponibles para asignar 5 ofertas.');
    }

    $juegosParaOfertas = $juegosSinOferta->random(5);

    foreach ($juegosParaOfertas as $juego) {
        $descuento = rand(10, 50); 

        $juego->oferta = true;
        $juego->precio_oferta = $juego->precio * (1 - $descuento / 100);
        $juego->save();
    }

    return back()->with('success', 'Se han asignado nuevas ofertas con descuentos aleatorios a 5 juegos.');
}

    

}

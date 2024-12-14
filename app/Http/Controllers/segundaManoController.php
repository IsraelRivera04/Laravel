<?php

namespace App\Http\Controllers;

use App\Models\SegundaManoJuego;
use App\Models\Complemento;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ComplementoController;
use Illuminate\Http\Request;

class segundaManoController extends Controller
{
    public function index(Request $request)
    {
        $segundaManoJuegos = SegundaManoJuego::with('usuario:id,username')
            ->orderBy('nombre', 'asc')
            ->paginate(10);
    
        if ($request->wantsJson()) {
            return response()->json($segundaManoJuegos, 200);
        }
    
        return view('segundaMano.index', compact('segundaManoJuegos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('segundaMano.create');
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
            'imagen' => 'nullable|mimes:jpeg,png,jpg|max:2048',
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
            'imagen.max' => 'La imagen es demasiado grande',
        ]);

        $segundaManoJuego = new segundaManoJuego($request->all());

        if($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $imagen = $request->file('imagen');
        }

        if($imagen->getRealPath()) {
            $segundaManoJuego->imagen = base64_encode(file_get_contents($imagen->getRealPath()));
        } else {
            return back()->withErrors(['imagen' =>'error']);
        }
        $segundaManoJuego->usuario_id = Auth::id();
        $segundaManoJuego->save();
        return redirect()->route('segundaMano.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $segundaManoJuego = segundaManoJuego::findOrFail($id);
        
        $complementos = Complemento::where('nombre', 'LIKE', '%' . $segundaManoJuego->nombre . '%')->get();
    
        $origin = $request->headers->get('origin'); 
        if ($origin === 'http://localhost:4200') {
            return response()->json([
                'segundaManoJuego' => $segundaManoJuego,
                'complementos' => $complementos,
            ], 200);
        }

        return view('segundaMano.show', compact('segundaManoJuego', 'complementos'));
    }
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $segundaManoJuego = segundaManoJuego::findOrFail($id);

        if (auth()->id() !== $segundaManoJuego->usuario_id) {
            abort(403, 'No tienes permisos para editar este juego.');
        }
    
        return view('segundaMano.edit', compact('segundaManoJuego'));
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
            'imagen' => 'nullable|mimes:jpeg,png,jpg|max:2048',
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
        ]);
        $segundaManoJuego = segundaManoJuego::findOrFail($id);
        $segundaManoJuego->fill($request->all());

        if($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $imagen = $request->file('imagen');
            $segundaManoJuego->imagen = base64_encode(file_get_contents($imagen->getRealPath()));
        } else {
            $segundaManoJuego->imagen = base64_encode('No hay imagen para este juego por el momento');
        }

        $segundaManoJuego->save();
        return redirect()->route('segundaMano.show', $segundaManoJuego->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $segundaManoJuego = segundaManoJuego::findOrFail($id);

        if (auth()->id() !== $segundaManoJuego->usuario_id) {
            abort(403, 'No tienes permisos para eliminar este juego.');
        }

        $segundaManoJuego->delete();

        return redirect()->route('segundaMano.index')->with('success', 'Juego eliminado');
    }
}

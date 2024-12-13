<?php

namespace App\Http\Controllers;

use App\Models\Complemento;
use Illuminate\Http\Request;

class ComplementoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $complementos = Complemento::query();
      
        // Ordenar por nombre o precio según los parámetros de la solicitud
        if ($request->has('orden') && $request->orden == 'precio') {
            $complementos->orderBy('precio', $request->get('direction', 'asc'));
        } else {
            $complementos->orderBy('nombre', $request->get('direction', 'asc'));
        }
      
        // Paginar los resultados
        $complementos = $complementos->paginate(1000);
      
        // Detectar si la solicitud viene desde Angular
        $origin = $request->headers->get('origin');
        if ($origin === 'http://localhost:4200') {
            return response()->json($complementos, 200);
        }
      
        return view('complementos.index', compact('complementos'));
    }
    
    
    
    


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Complemento::class);

        return view('complementos.create');
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
        'nombre' => 'required|string|max:255',
        'precio' => 'required|numeric',
        'imagen' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        'stock' => 'nullable|numeric',
    ]);

    $complemento = new Complemento($request->all());

    if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
        $imagen = $request->file('imagen');
        $complemento->imagen = base64_encode(file_get_contents($imagen->getRealPath()));
    } else {
        $complemento->imagen = base64_encode('No hay imagen para este complemento por el momento');
    }

    $complemento->save();

    return redirect()->route('complementos.index')->with('success', 'Complemento creado correctamente.');
}


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
{
    $complemento = Complemento::findOrFail($id);

    // Detectar si la solicitud viene desde Angular
    $origin = $request->headers->get('origin'); // Origen de la solicitud
    if ($origin === 'http://localhost:4200') {
        return response()->json($complemento, 200);
    }

    // Si viene de Laravel, mostrar la vista del detalle
    return view('complementos.show', compact('complemento'));
}


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $complemento = Complemento::findOrFail($id);
        return view('complementos.edit', compact('complemento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complemento $complemento)
    {
        $this->authorize('update', $complemento);
    
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'precio' => 'required|numeric',
            'imagen' => 'nullable|mimes:jpeg,png,jpg|max:2048',
            'stock' => 'nullable|numeric',
        ]);
    
        $complemento->fill($request->except('imagen'));
    
        if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
            $imagen = $request->file('imagen');
            $complemento->imagen = base64_encode(file_get_contents($imagen->getRealPath()));
        } else {
            $complemento->imagen = base64_encode('No hay imagen para este complemento por el momento');
        }
    
        $complemento->save();
    
        return redirect()->route('complementos.show', $complemento->id);
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

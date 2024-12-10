<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;
class EventoController extends Controller
{
    public function index(Request $request)
{
    $eventos = Evento::query();

    // Ordenar por fecha
    $eventos->orderBy('fecha', 'asc');

    // Paginar los resultados
    $eventos = $eventos->paginate(5);

    // Detectar si la solicitud viene desde Angular
    $origin = $request->headers->get('origin'); // Origen de la solicitud
    if ($origin === 'http://localhost:4200') {
        return response()->json($eventos, 200);
    }

    // Si viene de Laravel
    return view('eventos.index', compact('eventos'));
}


    public function create()
    {
        return view('eventos.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string|max:1000',
        'fecha' => 'required|date',
        'ubicacion' => 'nullable|string|max:255',
        'imagen' => 'nullable|mimes:jpeg,png,jpg|max:2048',
    ]);

    $evento = new Evento($validated);

    if ($request->hasFile('imagen') && $request->file('imagen')->isValid()) {
        $imagen = $request->file('imagen');
        
        $imagenBase64 = base64_encode(file_get_contents($imagen->getRealPath()));

        $evento->imagen = $imagenBase64;
    }
    $evento->usuario_id = Auth::id();
    $evento->save();

    return redirect()->route('eventos.index')->with('success', 'Evento creado con éxito.');
}



public function show(Request $request, $id)
{
    $evento = Evento::findOrFail($id); // Buscar el evento por ID o lanzar error 404

    // Detectar si la solicitud viene desde Angular
    $origin = $request->headers->get('origin'); // Origen de la solicitud
    if ($origin === 'http://localhost:4200') {
        return response()->json(['data' => $evento], 200);
    }

    // Si viene de Laravel, mostrar la vista del detalle
    return view('eventos.show', compact('evento'));
}





    public function edit(Evento $evento)
    {
        return view('eventos.edit', compact('evento'));
    }

    public function update(Request $request, Evento $evento)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:1000',
            'fecha' => 'required|date',
            'ubicacion' => 'nullable|string|max:255',
            'imagen' => 'nullable|mimes:jpeg,png,jpg|max:2048',
        ]);

        $evento->fill($validated);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            $evento->imagen = base64_encode(file_get_contents($imagen->getRealPath()));
        }

        $evento->save();

        return redirect()->route('eventos.index')->with('success', 'Evento actualizado con éxito.');
    }

    public function destroy(Evento $evento)
    {
        $evento->delete();
        return redirect()->route('eventos.index')->with('success', 'Evento eliminado con éxito.');
    }

    public function obtenerParticipantes($id)
    {
        $evento = Evento::find($id);

        if (!$evento) {
            return response()->json(['message' => 'Evento no encontrado'], 404);
        }

        $participantes = $evento->participantes;
        return response()->json($participantes);
    }


    // En el controlador de eventos
    public function inscribirse($eventoId)
    {
        // Obtén el evento
        $evento = Evento::find($eventoId);
    
        // Verifica si el evento existe
        if (!$evento) {
            return response()->json(['error' => 'Evento no encontrado'], 404);
        }
    
        // Verifica si hay plazas disponibles
        if ($evento->plazas_disponibles <= 0) {
            return response()->json(['error' => 'No hay plazas disponibles'], 400);
        }
    
        // Lógica para inscribir al usuario (suponiendo que el usuario está autenticado)
        $evento->usuarios()->attach(auth()->id());  // Asumiendo que tienes una relación many-to-many
    
        // Disminuye las plazas disponibles
        $evento->plazas_disponibles -= 1;
        $evento->save();
    
        return response()->json(['message' => 'Inscripción exitosa']);
    }
    
/**
 * Manejar respuestas para solicitudes web y JSON.
 */
private function responseWithMessage(string $message, string $type)
{
    if (request()->wantsJson()) {
        $status = $type === 'success' ? 200 : 400;
        return response()->json(['message' => $message, 'type' => $type], $status);
    }

    $redirectType = $type === 'success' ? 'success' : 'error';
    return redirect()->back()->with($redirectType, $message);
}

    


}

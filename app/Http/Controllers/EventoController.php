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
    $eventos = $eventos->paginate(1000);

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
        'hora_inicio' => 'required|date_format:H:i',
        'hora_final' => 'required|date_format:H:i|after:hora_inicio',
        'plazas' => 'required|integer|min:1', 
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

    public function inscribirse(Request $request, Evento $evento)
    {
        // Verifica si el usuario ya está inscrito
        if ($evento->participantes->contains(auth()->id())) {
            // Respuesta en caso de que ya esté inscrito
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Ya estás inscrito en este evento.',
                ], 409);
            }
    
            return redirect()->route('eventos.show', $evento->id)
                             ->with('error', 'Ya estás inscrito en este evento.');
        }
    
        // Verifica si hay plazas disponibles
        if ($evento->plazas > $evento->participantes()->count()) {
            // Inscribe al usuario
            $evento->participantes()->attach(auth()->id());
    
            \Log::info("Usuario con ID " . auth()->id() . " inscrito en evento ID " . $evento->id);
    
            // Verificar si la solicitud es desde Angular
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Te has inscrito con éxito al evento.',
                    'evento' => $evento,
                ], 200);
            }
    
            // Redirigir en caso de que la solicitud sea desde Laravel
            return redirect()->route('eventos.show', $evento->id)
                             ->with('success', 'Te has inscrito con éxito al evento.');
        } else {
            // Si no hay plazas disponibles, enviar una respuesta de error
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'No hay plazas disponibles en este evento.',
                ], 400);
            }
    
            return redirect()->route('eventos.show', $evento->id)
                             ->with('error', 'No hay plazas disponibles en este evento.');
        }
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

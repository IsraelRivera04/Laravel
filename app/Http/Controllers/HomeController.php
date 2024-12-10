<?php

namespace App\Http\Controllers;

use App\Models\Juego;
use App\Models\Complemento;
use App\Models\Evento;
use Illuminate\Http\JsonResponse;

class HomeController extends Controller
{
    public function juegosDestacados(): JsonResponse
    {
        $juegos = Juego::inRandomOrder()->take(3)->get();
        return response()->json($juegos);
    }

    public function complementosPopulares(): JsonResponse
    {
        $complementos = Complemento::inRandomOrder()->take(3)->get();
        return response()->json($complementos);
    }

    public function proximosEventos(): JsonResponse
    {
        $eventos = Evento::where('fecha', '>', now())
            ->orderBy('fecha', 'asc')
            ->take(5)
            ->get();
        return response()->json($eventos);
    }
}

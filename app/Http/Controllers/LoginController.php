<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('username', 'password'))) {
            return response()->json(['message' => 'Credenciales inválidas'], 401);
        }

        $user = $request->user();
        $token = $user->createToken('token-name')->plainTextToken;

        return response()->json(['token' => $token, 'user' => $user]);
    }

    public function loginLaravel(Request $request) {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('juegos.index'));
        } else {
            $error = 'Usuario incorrecto';
            return view('auth.login', compact('error'));
        }
    }


    
    public function logout(Request $request)
    {
        try {
            // Revocar la sesión del usuario
            Auth::logout();
    
            if ($request->wantsJson()) {
                // Respuesta JSON para Angular
                return response()->json(['message' => 'Sesión cerrada correctamente'], 200);
            }
    
            // Redirigir a la página de inicio de sesión en Laravel
            return redirect('/login')->with('message', 'Sesión cerrada correctamente');
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                // Manejo de error en JSON para Angular
                return response()->json([
                    'message' => 'Error al cerrar sesión',
                    'error' => $e->getMessage(),
                ], 500);
            }
    
            // Manejo de error con redirección en Laravel
            return redirect('/login')->withErrors(['error' => 'Error al cerrar sesión']);
        }
    }
    
    
    

    public function user(Request $request)
    {
        return $request->user();
    }
}

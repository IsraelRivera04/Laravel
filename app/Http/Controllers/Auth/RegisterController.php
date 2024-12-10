<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|unique:usuarios,username', 
            'email' => ['required', 'string', 'email', 'unique:usuarios,email', 
                        'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/'],
            'password' => 'required|string|confirmed',
        ], [
            'username.required' => 'El nombre de usuario es obligatorio.',
            'username.unique' => 'Este nombre de usuario ya está en uso.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
            'email.regex' => 'El correo electrónico debe tener el formato correcto "texto@texto.com".',
            'password.required' => 'La contraseña es obligatoria.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
        ]);

        $usuario = Usuario::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($usuario);
        return redirect()->route('inicio');
    }

    public function __construct() 
    {
        $this->middleware('guest');
    }

    public function usuarioUnico(Request $request)
{
    $username = $request->username;
    $existe = Usuario::where('username', $username)->exists();
    
    return response()->json(['exists' => $existe]);
}

public function emailUnico(Request $request)
{
    $email = $request->email;
    $existe = Usuario::where('email', $email)->exists();
    
    return response()->json(['exists' => $existe]);
}
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function create()
    {
        if (auth()->check()) {
            return redirect()->to('/admin/dashboard');
        } else {
            return view('auth.register');
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|min:3|max:30',
            'apellido_p' => 'required|string|min:3|max:30',
            'apellido_m' => 'required|string|min:3|max:30',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = User::create(request(['nombre', 'apellido_p', 'apellido_m', 'correo', 'password']));

        auth()->login($user);

        return redirect()->to('/admin/dashboard');

    }
}

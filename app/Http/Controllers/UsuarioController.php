<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Exceptions\Handler;
use App\Models\Log;
use App\Models\Oficina;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if(auth()->user()->is_root){            
            return response()->view('usuario.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
        
    }

    public function getUsuario() 
    {
        
        $usuario = DB::table('users')
            ->where("privilegio", "!=", 'cliente')
            ->get();

        return datatables()->of($usuario)->addColumn('btn', 'usuario.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addUsuario(Request $request)
    {        

        if ($request->ajax())
        {                
            $validacion = $request->validate([
                'nombre' => 'required|string',
                'apellidop' => 'required|string',
                'correo' => 'required|email|unique:users',
                'password' => 'required',
                'privilegio' => 'required',
            ]);

            $usuario = new User;

            $usuario->nombre = strtoupper($request->input('nombre'));
            $usuario->apellido_p = strtoupper($request->input('apellidop'));
            $usuario->apellido_m = strtoupper($request->input('apellidom'));
            $usuario->correo = $request->input('correo');
            $usuario->password = $request->input('password');
            $usuario->privilegio = $request->input('privilegio');

            $usuario->save();

            $usuario_id = $usuario->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Usuario";
            $log->id_tabla = $usuario_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            return response($usuario);
        }
    }

    public function editUsuario(Request $request)
    {   
        if ($request->ajax())
        {

            $validacion = $request->validate([
                'nombre' => 'required|string',
                'apellidop' => 'required|string',
                'correo' => 'required|email',
                'privilegio' => 'required',
            ]);

            //Editar registros en la tabla usuarios
            $usuario = User::find($request->id);            
            $usuario->nombre = strtoupper($request->input('nombre'));
            $usuario->apellido_p = strtoupper($request->input('apellidop'));
            $usuario->apellido_m = strtoupper($request->input('apellidom'));
            $usuario->privilegio = $request->input('privilegio');

            $usuario->update();

            return response($usuario);

        }
    }

    public function deleteUsuario(Request $request)
    {
        if ($request->ajax())
        {
            User::destroy($request->id);
        }
    }
}
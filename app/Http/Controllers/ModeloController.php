<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(auth()->user()->is_root){
            return view('modelo.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getModelo()
    {
        $modelo = Modelo::all();

        return datatables()->of($modelo)->addColumn('btn', 'modelo.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addModelo(Request $request)
    {
        if ($request->ajax()) {
            
            $request->validate([
                'modelo' => 'required',
            ]);

            $modelo = new Modelo;
            $modelo->modelo = strtoupper($request->input('modelo'));
            $modelo->empresa = $request->input('empresa');
            $modelo->save();

            $modelo_id = $modelo->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Modelo";
            $log->id_tabla = $modelo_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            return response($modelo);
        }
    }

    public function editModelo(Request $request)
    {
        if ($request->ajax()) {
            
            $request->validate([
                'modelo' => 'required',
            ]);

            $modelo = Modelo::find($request->id);
            $modelo->modelo = strtoupper($request->input('modelo'));
            $modelo->empresa = strtoupper($request->input('empresa'));
            $modelo->update();

            $modelo_id = $modelo->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Modelo";
            $log->id_tabla = $modelo_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            return response($modelo);
        }
    }

    public function deleteModelo(Request $request)
    {
        $modelo_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Modelo";
        $log->id_tabla = $modelo_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Modelo::destroy($request->id);
            }
        }
    }

    public function getClave(Request $request)
    {
        $clave = DB::table('users')->where("id", "=", auth()->user()->id)->first();

            if (\Hash::check($request->clave, $clave->password)) {
                return response("success");
            }else{
                return response("error");
            }
    }
}
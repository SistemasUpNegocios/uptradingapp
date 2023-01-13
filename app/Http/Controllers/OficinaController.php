<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Oficina;
use Illuminate\Http\Request;

class OficinaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            return view('oficina.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }  
        
    }

    public function getOficina()
    {
        $oficinas = Oficina::all();

        return datatables()->of($oficinas)->addColumn('btn', 'oficina.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addOficina(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'codigo_oficina' => 'required|unique:oficina',
                'ciudad' => 'required',
            ]);

            $oficina = new Oficina;
            $oficina->ciudad = strtoupper($request->input('ciudad'));
            $oficina->codigo_oficina = $request->input('codigo_oficina');
            $oficina->coord_x = $request->input('coord_x');
            $oficina->coord_y = $request->input('coord_y');
            $oficina->save();

            $oficina_id = $oficina->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Oficina";
            $log->id_tabla = $oficina_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            return response($oficina);
        }
    }

    public function editOficina(Request $request)
    {
        if ($request->ajax()) {
            
            $request->validate([
                'codigo_oficina' => 'required',
                'ciudad' => 'required',
            ]);

            $oficina = Oficina::find($request->id);
            $oficina->ciudad = strtoupper($request->input('ciudad'));
            $oficina->codigo_oficina = $request->input('codigo_oficina');
            $oficina->coord_x = $request->input('coord_x');
            $oficina->coord_y = $request->input('coord_y');
            $oficina->update();

            $oficina_id = $oficina->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Oficina";
            $log->id_tabla = $oficina_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            return response($oficina);
        }
    }

    public function deleteOficina(Request $request)
    {
        $oficina_id = $request->id;
        $bitacora_id = session('bitacora_id');
        
        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Oficina";
        $log->id_tabla = $oficina_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Oficina::destroy($request->id);
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
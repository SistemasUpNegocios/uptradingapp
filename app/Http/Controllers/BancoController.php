<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Log;
use Illuminate\Http\Request;

class BancoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            return view('banco.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }

    }

    public function getBanco()
    {
        $banco = Banco::all();

        return datatables()->of($banco)->addColumn('btn', 'banco.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addBanco(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'nombre' => 'required',
            ]);

            $banco = new Banco;
            $banco->nombre = strtoupper($request->input('nombre'));
            $banco->save();

            $banco_id = $banco->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Banco";
            $log->id_tabla = $banco_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                return response($banco);
            }
        }
    }

    public function editBanco(Request $request)
    {
        if ($request->ajax()) {
            
            $request->validate([
                'nombre' => 'required',
            ]);

            $banco = Banco::find($request->id);
            $banco->nombre = strtoupper($request->input('nombre'));
            $banco->update();

            $banco_id = $banco->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Banco";
            $log->id_tabla = $banco_id;
            $log->bitacora_id = $bitacora_id;


            if ($log->save()) {
                return response($banco);
            }
        }
    }

    public function deleteBanco(Request $request)
    {
        if ($request->ajax()) {
            $banco_id = $request->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Eliminación";
            $log->tabla = "Banco";
            $log->id_tabla = $banco_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                Banco::destroy($request->id);
            }
        }
    }
}
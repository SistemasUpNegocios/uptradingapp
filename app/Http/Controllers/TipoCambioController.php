<?php

namespace App\Http\Controllers;

use App\Models\TipoCambio;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoCambioController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin');
    }
    
    public function index()
    {
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos){
            return view("tipo-cambio.show");
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getTipoCambio()
    {

        $tipo_cambio = TipoCambio::join('contrato', 'contrato.id', 'tipo_cambio.contrato_id')
            ->select("tipo_cambio.id", "tipo_cambio.fecha", "tipo_cambio.valor", "contrato.contrato")
            ->get();

        return datatables()->of($tipo_cambio)->addColumn('btn', 'tipo-cambio.buttons')->rawColumns(['btn'])->toJson();
    }
    
    public function deleteTipoCambio(Request $request)
    {
        $tipo_cambio_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Tipo de cambio";
        $log->id_tabla = $tipo_cambio_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                TipoCambio::destroy($request->id);
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
<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos){
            return response()->view('pagos.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getPagos()
    {
        $pagos = Pago::join('contrato', "contrato.id", "=", "pagos.id_contrato")
            ->select(DB::raw("pagos.id, contrato.contrato, pagos.memo, pagos.monto, pagos.tipo_pago, pagos.tipo_cambio, contrato.moneda"))
            ->orderBy('pagos.id', 'desc')
            ->get();

        return datatables()->of($pagos)->addColumn('btn', 'pagos.buttons')->rawColumns(['btn'])->toJson();
    }

    public function deletePago(Request $request)
    {
        $pago_id = $request->id;
        $bitacora_id = session('bitacora_id');
        
        $log = new Log;
        $log->tipo_accion = "Eliminación";
        $log->tabla = "Pagos";
        $log->id_tabla = $pago_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Pago::destroy($request->id);
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

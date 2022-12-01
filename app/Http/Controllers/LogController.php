<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Log;

class LogController extends Controller
{
    public function __construct()
    {        
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(auth()->user()->is_root){
            return view('logs.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getLogs()
    {
        $logs = DB::table('logs')
        ->join('bitacora_acceso', 'bitacora_acceso.id', '=', 'logs.bitacora_id')
        ->join('users', 'users.id', '=', 'bitacora_acceso.user_id')
        ->select(DB::raw("bitacora_acceso.id, bitacora_acceso.direccion_ip, bitacora_acceso.fecha_entrada, bitacora_acceso.fecha_salida, bitacora_acceso.dispositivo, bitacora_acceso.sistema_operativo, bitacora_acceso.navegador, bitacora_acceso.user_id, users.nombre AS user_nombre, users.apellido_p AS user_apellidop, users.apellido_m AS users_apellidom, users.correo AS user_correo, users.privilegio AS user_privilegio, users.foto_perfil AS user_fotoperfil, logs.hora_fecha, logs.tipo_accion, logs.tabla, logs.id AS logsid"))
        ->orderByDesc('logs.hora_fecha')
        ->get();

        return datatables()->of($logs)->addColumn('tipos', 'logs.tipos')->addColumn('btn', 'logs.buttons')->rawColumns(['tipos', 'btn'])->toJson();
    }

    public function deleteCambio(Request $request)
    {
        if ($request->ajax()) {
            Log::destroy($request->id);
        }
    }
}

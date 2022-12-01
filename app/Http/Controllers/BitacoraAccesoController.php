<?php

namespace App\Http\Controllers;

use App\Models\BitacoraAcceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Jenssegers\Agent\Agent;

class BitacoraAccesoController extends Controller
{
    public function __construct()
    {        
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if(auth()->user()->is_root){
            $bitacoras = DB::table('bitacora_acceso')
                ->join('users', 'users.id', '=', 'bitacora_acceso.user_id')
                ->select(DB::raw("bitacora_acceso.id, bitacora_acceso.direccion_ip, bitacora_acceso.fecha_entrada, bitacora_acceso.fecha_salida, bitacora_acceso.dispositivo, bitacora_acceso.sistema_operativo, bitacora_acceso.navegador, bitacora_acceso.user_id, users.nombre AS user_nombre, users.apellido_p AS user_apellidop, users.apellido_m AS users_apellidom, users.correo AS user_correo, users.privilegio AS user_privilegio, users.foto_perfil AS user_fotoperfil"))
                ->orderByDesc('bitacora_acceso.fecha_salida')
                ->get();

            $data = array(
                "bitacoras" => $bitacoras,
            );

            return response()->view('bitacora-acceso.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
        
    }

    public static function get_dispositivo()
    {
        $dispositivo = "";
        $agent = new Agent();

        if ($agent->isMobile() == true) {
            $nombre_dispositivo = $agent->device();
            $dispositivo = "Celular " . $nombre_dispositivo;
        } elseif ($agent->isTablet() == true) {
            $nombre_dispositivo = $agent->device();
            $dispositivo = "Tablet " . $nombre_dispositivo;
        } elseif ($agent->isDesktop() == true) {
            $dispositivo = "Computadora";
        }

        return $dispositivo;
    }

    public static function get_sistema_operativo()
    {
        $agent = new Agent();

        $sistema_operativo = $agent->platform();

        return $sistema_operativo;
    }

    public static function get_navegador()
    {
        $agent = new Agent();

        $navegador = $agent->browser();

        return $navegador;
    }

    public function getDetallesBitacora(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $bitacora = DB::table('bitacora_acceso')
            ->join('users', 'users.id', '=', 'bitacora_acceso.user_id')
            ->select(DB::raw("bitacora_acceso.id, bitacora_acceso.direccion_ip, bitacora_acceso.fecha_entrada, bitacora_acceso.fecha_salida, bitacora_acceso.dispositivo, bitacora_acceso.sistema_operativo, bitacora_acceso.navegador, bitacora_acceso.user_id, users.nombre AS user_nombre, users.apellido_p AS user_apellidop, users.apellido_m AS user_apellidom, users.correo AS user_correo, users.privilegio AS user_privilegio, users.foto_perfil AS user_fotoperfil"))
            ->where('bitacora_acceso.id', '=', $id)
            ->get();

            return response($bitacora);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\BitacoraAcceso;
use App\Http\Controllers\BitacoraAccesoController;
use App\Models\Oficina;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\This;

class SessionController extends Controller
{
    public function create()
    {
        if (auth()->check()) {
            return redirect()->to('/admin/dashboard');
        } else {
            return view('auth.login');
        }
    }

    public function store()
    {

        if (auth()->attempt(request(['correo', 'password'])) == false) {
            return back()->withErrors([
                'message' => 'Datos incorrectos, intenta de nuevo'
            ]);
        } else {
            
            $perfilPS = DB::table('users')
                ->join('ps', 'ps.correo_institucional', '=', 'users.correo')
                ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
                ->select(DB::raw("users.id, users.nombre, users.apellido_p, users.apellido_m, users.correo, users.privilegio, ps.id AS psid, ps.fecha_nac, ps.nacionalidad, ps.direccion, ps.colonia, ps.cp, ps.ciudad, ps.estado, ps.celular, ps.correo_personal, ps.ine, ps.pasaporte, ps.vencimiento_pasaporte, ps.iban, ps.swift, ps.oficina_id, oficina.codigo_oficina"))
                ->where('correo', '=', auth()->user()->correo)
                ->get();

            if (count($perfilPS) > 0) {
                foreach ($perfilPS[0] as $clave => $valor) {
                    session([$clave => $valor]);
                }
            }

            $perfilClien = DB::table('users')
                ->join('cliente', 'cliente.correo_institucional', '=', 'users.correo')
                ->select(DB::raw("cliente.id AS clienteid, cliente.fecha_nac, cliente.nacionalidad, cliente.direccion, cliente.colonia, cliente.cp, cliente.ciudad, cliente.estado, cliente.celular, cliente.correo_personal, cliente.ine, cliente.pasaporte, cliente.vencimiento_pasaporte, cliente.iban, cliente.swift"))
                ->where('correo', '=', auth()->user()->correo)
                ->get();

            if (count($perfilClien) > 0) {
                foreach ($perfilClien[0] as $clave => $valor) {
                    session([$clave => $valor]);
                }
            }

            if (auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond) {
                session(["clienteid" => "%"]);
                session(["psid" => "%"]);
            }else if (auth()->user()->is_cliente) {
                session(["codigo_oficina" => "%"]);
                session(["psid" => "%"]);
            }else if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_contabilidad){
                session(["clienteid" => "%"]);
                session(["codigo_oficina" => "%"]);
                session(["psid" => "%"]);
            }

            $fecha_entrada = Carbon::now();
            $fecha_entrada->toDateTimeString();

            $bitacoraAcceso = new BitacoraAcceso;
            $bitacoraAcceso->direccion_ip = request()->ip();
            $bitacoraAcceso->fecha_entrada = $fecha_entrada;

            $fecha_salida = Carbon::parse($fecha_entrada);
            // La cookie de sesión expira en 120 minutos desde que se inicia sesión (este valor cambiará a menos que el usuario cierre esta sesión antes)
            $fecha_salida->addMinutes(120);
            $fecha_salida->toDateTimeString();

            $bitacoraAcceso->fecha_salida = $fecha_salida;
            $bitacoraAcceso->dispositivo = BitacoraAccesoController::get_dispositivo();
            $bitacoraAcceso->sistema_operativo = BitacoraAccesoController::get_sistema_operativo();
            $bitacoraAcceso->navegador = BitacoraAccesoController::get_navegador();
            $bitacoraAcceso->user_id = auth()->user()->id;

            $bitacoraAcceso->save();

            $bitacoraAcceso_id = $bitacoraAcceso->id;

            session(['bitacora_id' => $bitacoraAcceso_id]);

            return redirect()->to('/admin/dashboard');
        }
    }

    public function destroy()
    {
        auth()->logout();

        $bitacoraAcceso_id = session('bitacora_id');

        $bitacoraAcceso = BitacoraAcceso::find($bitacoraAcceso_id);

        $fecha_salida = Carbon::now()->toDateTimeString();

        $bitacoraAcceso->fecha_salida = $fecha_salida;

        $bitacoraAcceso->update();

        return redirect()->to('/');
    }

    public function getDistanceBetweenCoords(
        $latitudeFrom,
        $longitudeFrom,
        $latitudeTo,
        $longitudeTo,
        $earthRadius = 6371000
    ) {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return number_format((float)($angle * $earthRadius), 2, '.', '');
    }

    public function checkLocation(Request $request)
    {
        if ($request->ajax()) {
            $latFrom = $request->coord_x;
            $lngFrom = $request->coord_y;

            $oficinas = Oficina::all();
            $i = 0;

            foreach ($oficinas as $oficina) {
                $latTo = floatval($oficina->coord_x);
                $lngTo = floatval($oficina->coord_y);

                $distance_m = $this->getDistanceBetweenCoords($latFrom, $lngFrom, $latTo, $lngTo, $earthRadius = 6371000);

                if ($distance_m <= 1500) {
                    $i++;
                }
            }

            return response($i, 200);
        }
    }
}
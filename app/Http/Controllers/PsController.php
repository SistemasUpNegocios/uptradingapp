<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\Ps;
use App\Models\Cliente;
use App\Models\Formulario;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            $codigo = session('codigo_oficina');

            $oficinas = Oficina::select()->where("codigo_oficina", "like", $codigo)->get();
            $ps = DB::table("ps")
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->where("tipo_ps", "=", "Encargado")
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->get();

            $data = array(
                "lista_oficinas" => $oficinas,
                "lista_ps" => $ps
            );
            return response()->view('ps.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getPs()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            $codigo = session('codigo_oficina');
            $ps = DB::table('ps')
                ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
                ->select(DB::raw("ps.id, ps.codigoPS, ps.nombre, ps.apellido_p, ps.apellido_m, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS nombrePS, ps.fecha_nac, ps.nacionalidad, ps.direccion, ps.colonia, ps.cp, ps.ciudad, ps.estado, ps.celular, ps.estado, ps.celular, ps.correo_personal, ps.correo_institucional, ps.ine, ps.pasaporte, ps.vencimiento_pasaporte, ps.tipo_ps, ps.encargado_id, oficina.id AS oficina_id, oficina.ciudad AS oficina_ciudad, ps.swift, ps.iban"))
                ->where("tipo_ps", "=", "Encargado")
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->get();

            return datatables()->of($ps)->addColumn('btn', 'ps.buttons')->rawColumns(['btn'])->toJson();
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function addPs(Request $request)
    {
        if ($request->ajax()) {
            
            $request->validate([
                'codigops' => 'required|unique:ps',
                'nombre' => 'required|string',
                'apellidop' => 'required|string',
                'fechanac' => 'required|date',
                'nacionalidad' => 'required|string',
                'direccion' => 'required',
                'colonia' => 'required',
                'cp' => 'required|numeric|digits:5',
                'ciudad' => 'required|string',
                'estado' => 'required|string',
                'celular' => 'required|numeric|digits:10',
                'correo_institucional' => 'required|email|unique:ps',
                'correo_personal' => 'required|email',
            ]);

            $ps = new Ps;
            $ps->codigoPS = $request->input('codigops');
            $ps->nombre = strtoupper($request->input('nombre'));
            $ps->apellido_p = strtoupper($request->input('apellidop'));
            $ps->apellido_m = strtoupper($request->input('apellidom'));
            $ps->fecha_nac = $request->input('fechanac');
            $ps->nacionalidad = strtoupper($request->input('nacionalidad'));
            $ps->direccion = strtoupper($request->input('direccion'));
            $ps->colonia = strtoupper($request->input('colonia'));
            $ps->cp = $request->input('cp');
            $ps->ciudad = strtoupper($request->input('ciudad'));
            $ps->estado = strtoupper($request->input('estado'));
            $ps->celular = $request->input('celular');
            $ps->correo_personal = strtolower($request->input('correo_personal'));
            $ps->correo_institucional = strtolower($request->input('correo_institucional'));
            $ps->ine = $request->input('ine');
            $ps->pasaporte = strtoupper($request->input('pasaporte'));
            $ps->vencimiento_pasaporte = $request->input('fechapas');
            $ps->tipo_ps = "Encargado";
            $ps->oficina_id = $request->input('oficina_id');
            $ps->swift = $request->input('swift');
            $ps->iban = $request->input('iban');
            $ps->save();

            $ps_id = $ps->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "PS";
            $log->id_tabla = $ps_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();


            //Añadir registros a la tabla users
            $verificacion = User::where("correo", strtolower($request->correo_institucional))->count();
            if ($verificacion == 0) {
                $user = new User;
                $user->nombre = strtoupper($request->nombre);
                $user->apellido_p = strtoupper($request->apellidop);
                $user->apellido_m = strtoupper($request->apellidom);
                $user->correo = strtolower($request->correo_institucional);
                $userId = User::select('id')->orderBy('id', 'desc')->first();
                $userId = intval($userId->id) + 1;
                $pass = explode("@", $request->correo_institucional);
                $user->password = $userId . $pass[0];
                $user->privilegio = 'ps_silver';

                $user->save();
            } else {

                User::where('correo', strtolower($request->input('correo_institucional')))
                    ->update([
                        'nombre' => strtoupper($request->nombre),
                        "apellido_p" => strtoupper($request->apellidop),
                        "apellido_m" => strtoupper($request->apellidom),
                        "privilegio" => "ps_silver"
                    ]);
            }

            return response($ps);
        }
    }

    public function editPs(Request $request)
    {
        if ($request->ajax()) {
            
            $request->validate([
                'codigops' => 'required',
                'nombre' => 'required|string',
                'apellidop' => 'required|string',
                'fechanac' => 'required|date',
                'nacionalidad' => 'required|string',
                'direccion' => 'required',
                'colonia' => 'required',
                'cp' => 'required|numeric|digits:5',
                'ciudad' => 'required|string',
                'estado' => 'required|string',
                'celular' => 'required|numeric|digits:10',
                'correo_institucional' => 'required|email',
                'correo_personal' => 'required|email',
            ]);

            $ps = Ps::find($request->id);
            $ps->codigoPS = $request->input('codigops');
            $ps->nombre = strtoupper($request->input('nombre'));
            $ps->apellido_p = strtoupper($request->input('apellidop'));
            $ps->apellido_m = strtoupper($request->input('apellidom'));
            $ps->fecha_nac = strtoupper($request->input('fechanac'));
            $ps->nacionalidad = strtoupper($request->input('nacionalidad'));
            $ps->direccion = strtoupper($request->input('direccion'));
            $ps->colonia = strtoupper($request->input('colonia'));
            $ps->cp = $request->input('cp');
            $ps->ciudad = strtoupper($request->input('ciudad'));
            $ps->estado = strtoupper($request->input('estado'));
            $ps->celular = $request->input('celular');
            $ps->correo_personal = strtolower($request->input('correo_personal'));
            $ps->correo_institucional = strtolower($request->input('correo_institucional'));
            $ps->ine = $request->input('ine');
            $ps->pasaporte = strtoupper($request->input('pasaporte'));
            $ps->vencimiento_pasaporte = $request->input('fechapas');
            $ps->oficina_id = $request->input('oficina_id');
            $ps->tipo_ps = "Encargado";
            $ps->swift = $request->input('swift');
            $ps->iban = $request->input('iban');

            $ps->update();

            $ps_id = $ps->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "PS";
            $log->id_tabla = $ps_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();


            //editar user
            User::where('correo', strtolower($request->correo_temp))
                ->update([
                    'nombre' => strtoupper($request->nombre),
                    "apellido_p" => strtoupper($request->apellidop),
                    "apellido_m" => strtoupper($request->apellidom),
                    "correo" => strtolower($request->input('correo_institucional'))
                ]);

            return response($ps);
        }
    }

    public function deletePs(Request $request)
    {
        $ps_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "PS";
        $log->id_tabla = $ps_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Ps::destroy($request->id);
            }
        }
    }

    public function numPS(Request $request)
    {

        $numeroOficina = session('codigo_oficina');

        if ($numeroOficina == "%") {
            $numeroOficina = "001";
        }

        $codigoPS = Ps::select('codigoPs')->where("codigoPs", "like", "$numeroOficina%")->orderBy('codigoPs', 'DESC')->first();
        
        if (!empty($codigoPS)) {

            $codigoPS = explode("-", $codigoPS);
            $ps = intval($codigoPS[1]) + 1;

            $numeroPS = str_pad($ps, 3, "0", STR_PAD_LEFT);
            $numeroPSCompleto = "$numeroOficina-$numeroPS";

            $codigoForm = Formulario::select('codigoCliente')->orderBy('codigoCliente', 'DESC')->first();
            $codigoCliente = Cliente::select('codigoCliente')->orderBy('codigoCliente', 'DESC')->first();
            if (!empty($codigoForm) && !empty($codigoCliente)) {
                $codigoForm = explode("-", $codigoForm);            
                $codigoCliente = explode("-", $codigoCliente);
                if($codigoForm[2] >= $codigoCliente[2]){
                    $cliente = intval($codigoForm[2]) + 1;
                }else if($codigoForm[2] < $codigoCliente[2]){
                    $cliente = intval($codigoCliente[2]) + 1;
                }else{
                    $cliente = intval($codigoForm[2]) + 1;
                }        
                $numeroCliente = str_pad($cliente, 5, "0", STR_PAD_LEFT);
                $correoPS = "mxa_" . $numeroCliente . "@uptradingexperts.com";
            } else {
                $correoPS = "mxa_00001@uptradingexperts.com";
            }

            $data = array(
                "numeroPS" => $numeroPSCompleto,
                "correoPS" => $correoPS
            );

            return response($data);
        } else {
            $numeroPS = "001-001";

            $data = array(
                "numeroPS" => $numeroPS,
                "correoPS" => "ps_mx00001@uptradingexperts.com"
            );
            return response($data);
        }
    }

    public function numPSOficina(Request $request)
    {
        $oficina = Oficina::find($request->id);
        $numeroOficina = $oficina->codigo_oficina;
        $codigoPS = Ps::select('codigoPs')->where("codigoPs", "like", "$numeroOficina%")->orderBy('codigoPs', 'DESC')->first();
        
        if (!empty($codigoPS)) {

            $codigoPS = explode("-", $codigoPS);
            $ps = intval($codigoPS[1]) + 1;

            $numeroPS = str_pad($ps, 3, "0", STR_PAD_LEFT);
            $numeroPSCompleto = "$numeroOficina-$numeroPS";
            
            $data = array(
                "numeroPS" => $numeroPSCompleto,
            );

            return response($data);
        } else {
            $data = array(
                "numeroPS" => "001-001",
            );
            return response($data);
        }
    }
}
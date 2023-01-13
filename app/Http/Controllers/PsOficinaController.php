<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Oficina;
use App\Models\Ps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PsOficinaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            $oficinas = Oficina::all();
            $ps = DB::table("ps")
                ->where("tipo_ps", "=", "Encargado")
                ->get();

            $data = array(
                "lista_oficinas" => $oficinas,
                "lista_ps" => $ps
            );

            return response()->view('psoficina.show', $data, 200);
            
        }else{
            return redirect()->to('/admin/dashboard');
        }

    }

    public function getPs()
    {

        $codigo = session('codigo_oficina');
        $ps = DB::table("ps AS ps1")
            ->join("ps AS ps2", "ps2.id", "=", "ps1.encargado_id")
            ->join('oficina', 'oficina.id', '=', 'ps1.oficina_id')
            ->select(DB::raw("ps1.id, ps1.codigoPS, ps1.nombre, ps1.apellido_p, ps1.apellido_m, CONCAT(ps1.nombre, ' ', ps1.apellido_p, ' ', ps1.apellido_m) AS nombrePS, ps1.fecha_nac, ps1.nacionalidad, ps1.direccion, ps1.colonia, ps1.cp, ps1.ciudad, ps1.estado, ps1.celular, ps1.estado, ps1.celular, ps1.correo_personal, ps1.correo_institucional, ps1.ine, ps1.pasaporte, ps1.vencimiento_pasaporte, ps1.tipo_ps, ps1.encargado_id, oficina.id AS oficina_id, oficina.ciudad AS oficina, CONCAT(ps2.nombre, ' ', ps2.apellido_p, ' ', ps2.apellido_m) AS nombreEncargado, ps1.swift, ps1.iban"))
            ->where("ps1.tipo_ps", "=", "Oficina")
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->get();

        return datatables()->of($ps)->addColumn('btn', 'ps.buttons')->rawColumns(['btn'])->toJson();
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
            $ps->correo_personal = strtoupper($request->input('correo_personal'));
            $ps->correo_institucional = strtoupper($request->input('correo_institucional'));
            $ps->ine = $request->input('ine');
            $ps->pasaporte = strtoupper($request->input('pasaporte'));
            $ps->vencimiento_pasaporte = $request->input('fechapas');
            $ps->tipo_ps = "Oficina";
            $ps->oficina_id = $request->input('oficina_id');
            $ps->encargado_id = $request->input('encargado_id');
            $ps->swift = $request->input('swift');
            $ps->iban = $request->input('iban');

            $ps->save();

            $ps_id = $ps->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "PS Oficina";
            $log->id_tabla = $ps_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

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
            $ps->nombre = $request->input('nombre');
            $ps->apellido_p = $request->input('apellidop');
            $ps->apellido_m = $request->input('apellidom');
            $ps->fecha_nac = $request->input('fechanac');
            $ps->nacionalidad = $request->input('nacionalidad');
            $ps->direccion = $request->input('direccion');
            $ps->colonia = $request->input('colonia');
            $ps->cp = $request->input('cp');
            $ps->ciudad = $request->input('ciudad');
            $ps->estado = $request->input('estado');
            $ps->celular = $request->input('celular');
            $ps->correo_personal = $request->input('correo_personal');
            $ps->correo_institucional = $request->input('correo_institucional');
            $ps->ine = $request->input('ine');
            $ps->pasaporte = $request->input('pasaporte');
            $ps->vencimiento_pasaporte = $request->input('fechapas');
            $ps->tipo_ps = "Oficina";
            $ps->oficina_id = $request->input('oficina_id');
            $ps->encargado_id = $request->input('encargado_id');
            $ps->swift = $request->input('swift');
            $ps->iban = $request->input('iban');

            $ps->update();

            $ps_id = $ps->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "PS Oficina";
            $log->id_tabla = $ps_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            return response($ps);
        }
    }

    public function deletePs(Request $request)
    {
        $ps_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "PS Oficina";
        $log->id_tabla = $ps_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Ps::destroy($request->id);
            }
        }
    }

    public function getPsEncargado(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $ps_oficina = DB::table("ps")
                ->where("oficina_id", "=", $id)
                ->where("tipo_ps", "=", "Encargado")
                ->get();

            $data = array(
                "lista_ps" => $ps_oficina,
            );
            return response()->view('psoficina.psencargado', $data, 200);
        }
    }
}
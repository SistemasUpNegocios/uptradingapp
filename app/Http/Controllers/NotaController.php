<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Nota;
use App\Models\Formulario;
use App\Models\Ps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze || auth()->user()->is_ps_diamond){
            if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
                $lista_form = Formulario::all();
                $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                    ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                    ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                    ->get();
            }else{
                $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
                $psid = $ps_cons->id;
                $lista_form = Formulario::where("ps_id", $psid)->get();
                $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                    ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                    ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                    ->where("notas.ps_id", $psid)
                    ->get();
            }
            
            return view('nota.show', compact("notas", "lista_form"));
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function addNota(Request $request)
    {
        $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
        $psid = $ps_cons->id;
        $codigoPS = $ps_cons->codigoPS;

        $nota = new Nota;
        $nota->ps_id = $psid;
        $nota->cliente_id = $request->cliente_id;
        $nota->comentario = $request->comentario;
        $file = $request->file('comprobante_pago');
        $filename = $file->getClientOriginalName();
        $file->move(public_path("documentos/comprobantes_pagos/ps_convenios/$codigoPS/"), $filename);
        $nota->comprobante = $filename;
        $nota->estatus = "pendiente";
        $nota->fecha = Carbon::now()->toDateTimeString();
        $nota->save();
        
        $nota_id = $nota->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;
        $log->tipo_accion = "Inserción";
        $log->tabla = "Nota";
        $log->id_tabla = $nota_id;
        $log->bitacora_id = $bitacora_id;
        $log->save();

        $lista_form = Formulario::where("ps_id", $psid)->get();
        $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
            ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
            ->where("notas.ps_id", $psid)
            ->get();
        
        return view('nota.notas', compact("notas", "lista_form"));
    }

    public function editNota(Request $request)
    {
        $nota = Nota::find($request->id);
        $nota->estatus = $request->estatus;
        $nota->save();

        $nota_id = $nota->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;
        $log->tipo_accion = "Actualización";
        $log->tabla = "Notas";
        $log->id_tabla = $nota_id;
        $log->bitacora_id = $bitacora_id;
        $log->save();

        $lista_form = Formulario::all();
        $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
            ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
            ->get();

        return view('nota.notas', compact("notas", "lista_form"));
    }

    public function deleteNota(Request $request)
    {
        $nota_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;
        $log->tipo_accion = "Eliminación";
        $log->tabla = "Nota";
        $log->id_tabla = $nota_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Nota::destroy($request->id);
                
                if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
                    $lista_form = Formulario::all();
                    $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                        ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                        ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                        ->get();
                }else{
                    $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
                    $psid = $ps_cons->id;
                    $lista_form = Formulario::where("ps_id", $psid)->get();
                    $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                        ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                        ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                        ->where("notas.ps_id", $psid)
                        ->get();
                }
                return view('nota.notas', compact("notas", "lista_form"));
            }
        }
    }
}
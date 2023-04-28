<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Nota;
use App\Models\Formulario;
use App\Models\Ps;
use App\Models\Cliente;
use App\Models\Oficina;
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
                $lista_ps = Ps::all();
                $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                    ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                    ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                    ->get();
            }else if(auth()->user()->is_ps_diamond) {
                $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
                $codigo = Oficina::select()->where("id", $ps_cons->oficina_id)->first()->codigo_oficina;
                $numeroCliente = "MXN-" . $codigo . "-";
                $lista_form = Formulario::select()->where('codigoCliente', 'like', "$numeroCliente%")->get();
                $lista_ps = Ps::where("oficina_id", $ps_cons->oficina_id)->get();
                $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                    ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                    ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                    ->where("ps.oficina_id", $ps_cons->oficina_id)
                    ->get();
            }else if(auth()->user()->is_ps_bronze || auth()->user()->is_ps_gold) {
                $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
                $psid = $ps_cons->id;
                $lista_form = Formulario::where("ps_id", $psid)->get();
                $lista_ps = (object) [
                    'psid' => $psid,
                    'nombrecompleto' => $ps_cons->nombre." ".$ps_cons->apellido_p." ".$ps_cons->apellido_m,
                ];
                $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                    ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                    ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                    ->where("notas.ps_id", $psid)
                    ->get();
            }
            
            return view('nota.show', compact("notas", "lista_form", "lista_ps"));
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function addNota(Request $request)
    {

        $codigoPS = Ps::find($request->ps_id);
        $nombreps = $codigoPS->nombre.' '.$codigoPS->apellido_p.' '.$codigoPS->apellido_m;

        $codigoCliente = Formulario::find($request->cliente_id);
        $codigoCliente = $codigoCliente->codigoCliente;
        
        $nota = new Nota;
        $nota->ps_id = $request->ps_id;
        $nota->cliente_id = $request->cliente_id;
        $nota->comentario = $request->comentario;
        $file = $request->file('comprobante_pago');
        $filename = $file->getClientOriginalName();
        $file->move(public_path("documentos/comprobantes_pagos/convenios/$nombreps/$codigoCliente/"), $filename);
        $nota->comprobante = $filename;
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            $nota->estatus = "cargado";
        }else{
            $nota->estatus = "pendiente";
        }
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

        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            $lista_form = Formulario::all();
            $lista_ps = Ps::all();
            $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                ->get();

            \Telegram::sendMessage([
                'chat_id' => '-1001976160071',
                'parse_mode' => 'HTML',
                'text' => "Se aperturó una cuenta MAM para el cliente $cliente->codigoCliente y ya se subió el comprobante de pago."
            ]);
        }else if(auth()->user()->is_ps_diamond) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
            $codigo = Oficina::select()->where("id", $ps_cons->oficina_id)->first()->codigo_oficina;
            $numeroCliente = "MXN-" . $codigo . "-";
            $lista_form = Formulario::select()->where('codigoCliente', 'like', "$numeroCliente%")->get();
            $lista_ps = Ps::where("oficina_id", $ps_cons->oficina_id)->get();
            $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                ->where("ps.oficina_id", $ps_cons->oficina_id)
                ->get();
        }else if(auth()->user()->is_ps_bronze || auth()->user()->is_ps_gold) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
            $psid = $ps_cons->id;
            $lista_form = Formulario::where("ps_id", $psid)->get();
            $lista_ps = (object) [
                'psid' => $psid,
                'nombrecompleto' => $ps_cons->nombre." ".$ps_cons->apellido_p." ".$ps_cons->apellido_m,
            ];
            $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                ->where("notas.ps_id", $psid)
                ->get();
        }
        
        return view('nota.notas', compact("notas", "lista_form", "lista_ps"));
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
        $lista_ps = Ps::all();
        $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
            ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
            ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
            ->get();

        return view('nota.notas', compact("notas", "lista_form", "lista_ps"));
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
                    $lista_ps = Ps::all();
                    $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                        ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                        ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                        ->get();
                }else if(auth()->user()->is_ps_diamond) {
                    $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
                    $codigo = Oficina::select()->where("id", $ps_cons->oficina_id)->first()->codigo_oficina;
                    $numeroCliente = "MXN-" . $codigo . "-";
                    $lista_form = Formulario::select()->where('codigoCliente', 'like', "$numeroCliente%")->get();
                    $lista_ps = Ps::where("oficina_id", $ps_cons->oficina_id)->get();
                    $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                        ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                        ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                        ->where("ps.oficina_id", $ps_cons->oficina_id)
                        ->get();
                }else if(auth()->user()->is_ps_bronze || auth()->user()->is_ps_gold) {
                    $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
                    $psid = $ps_cons->id;
                    $lista_form = Formulario::where("ps_id", $psid)->get();
                    $lista_ps = (object) [
                        'psid' => $psid,
                        'nombrecompleto' => $ps_cons->nombre." ".$ps_cons->apellido_p." ".$ps_cons->apellido_m,
                    ];
                    $notas = Nota::join('ps', 'ps.id', '=', 'notas.ps_id')
                        ->join('formulario', 'formulario.id', '=', 'notas.cliente_id')
                        ->select(DB::raw("CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, ps.codigoPS, CONCAT(formulario.nombre, ' ', formulario.apellido_p, ' ', formulario.apellido_m) AS clientenombre, formulario.codigoCliente, notas.id AS notaid, notas.comentario, notas.comprobante, notas.estatus, notas.fecha"))
                        ->where("notas.ps_id", $psid)
                        ->get();
                }
                
                return view('nota.notas', compact("notas", "lista_form", "lista_ps"));
            }
        }
    }
}
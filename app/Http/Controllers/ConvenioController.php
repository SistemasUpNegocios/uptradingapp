<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Cliente;
use App\Models\Convenio;
use App\Models\Log;
use App\Models\Oficina;
use App\Models\PagoPSConvenio;
use App\Models\Ps;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ConvenioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond || auth()->user()->is_cliente){
            $codigo = session('codigo_oficina');
            $numeroCliente = "MXN-" . $codigo . "-";

            $ps = Ps::select()->orderBy("apellido_p")->where('codigoPS', 'like', "$codigo%")->get();
            $clientes = Cliente::select()->orderBy("apellido_p")->where("codigoCliente", "like", "%$numeroCliente%")->get();
            $bancos = Banco::all();

            $data = array(
                "lista_ps" => $ps,
                "clientes" => $clientes,
                "bancos" => $bancos,
            );

            return response()->view('convenio.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getConvenio()
    {

        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        if (auth()->user()->is_ps_gold) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();            
            $psid = $ps_cons->id;
        }

        $cliente_con = Cliente::select()->where("correo_institucional", auth()->user()->correo)->first();
        if (strlen($cliente_con) > 0) {
            $clienteid = $cliente_con->id;

            $convenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('banco', 'banco.id', '=', 'convenio.banco_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
                ->where(function ($query) use ($psid, $clienteid) {
                    $query->where("convenio.ps_id", "like", $psid)
                    ->orWhere("convenio.cliente_id", "like", $clienteid);
                })
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->get();
        }else{
            $convenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('banco', 'banco.id', '=', 'convenio.banco_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
                ->where("convenio.ps_id", "like", $psid)
                ->where("convenio.cliente_id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->get();
        }

        if (auth()->user()->is_cliente) {
            $clienteid = $cliente_con->id;
            $convenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('banco', 'banco.id', '=', 'convenio.banco_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
                ->where("convenio.ps_id", "like", $psid)
                ->where("convenio.cliente_id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->get();
        }

        return datatables()->of($convenio)->addColumn('btn', 'convenio.buttons')->rawColumns(['btn'])->toJson();
    }

    public function getConvenioActivado()
    {
        
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        if (auth()->user()->is_ps_gold) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();            
            $psid = $ps_cons->id;
        }

        $cliente_con = Cliente::select()->where("correo_institucional", auth()->user()->correo)->first();
        if (strlen($cliente_con) > 0) {
            $clienteid = $cliente_con->id;

            $convenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('banco', 'banco.id', '=', 'convenio.banco_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
                ->where(function ($query) use ($psid, $clienteid) {
                    $query->where("convenio.ps_id", "like", $psid)
                    ->orWhere("convenio.cliente_id", "like", $clienteid);
                })
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('convenio.status', 'Activado')
                ->get();
        }else{
            $convenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('banco', 'banco.id', '=', 'convenio.banco_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
                ->where("convenio.ps_id", "like", $psid)
                ->where("convenio.cliente_id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('convenio.status', 'Activado')
                ->get();
        }

        if (auth()->user()->is_cliente) {
            $clienteid = $cliente_con->id;
            $convenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('banco', 'banco.id', '=', 'convenio.banco_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
                ->where("convenio.ps_id", "like", $psid)
                ->where("convenio.cliente_id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('convenio.status', 'Activado')
                ->get();
        }

        return datatables()->of($convenio)->addColumn('btn', 'convenio.buttons')->rawColumns(['btn'])->toJson();
    }

    public function getConvenioPendiente()
    {
        
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        if (auth()->user()->is_ps_gold) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();            
            $psid = $ps_cons->id;
        }

        $cliente_con = Cliente::select()->where("correo_institucional", auth()->user()->correo)->first();
        if (strlen($cliente_con) > 0) {
            $clienteid = $cliente_con->id;

            $convenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('banco', 'banco.id', '=', 'convenio.banco_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
                ->where(function ($query) use ($psid, $clienteid) {
                    $query->where("convenio.ps_id", "like", $psid)
                    ->orWhere("convenio.cliente_id", "like", $clienteid);
                })
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('convenio.status', 'Pendiente de activación')
                ->get();
        }else{
            $convenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('banco', 'banco.id', '=', 'convenio.banco_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
                ->where("convenio.ps_id", "like", $psid)
                ->where("convenio.cliente_id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('convenio.status', 'Pendiente de activación')
                ->get();
        }

        if (auth()->user()->is_cliente) {
            $clienteid = $cliente_con->id;
            $convenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('banco', 'banco.id', '=', 'convenio.banco_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, banco.id AS banco_id"))
                ->where("convenio.ps_id", "like", $psid)
                ->where("convenio.cliente_id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where('convenio.status', 'Pendiente de activación')
                ->get();
        }

        return datatables()->of($convenio)->addColumn('btn', 'convenio.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addConvenio(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'folio' => 'required|unique:convenio',
                'cliente_id' => 'required',
                'ps_id' => 'required',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date',
                'capertura' => 'required',
                'cmensual' => 'required',
                'monto' => 'required',
                'monto_letra' => 'required',
                'status' => 'required',
                'banco_id' => 'required',
            ]);

            $convenio = new Convenio;

            $convenio->monto = $request->input('monto');
            $convenio->monto_letra = $request->input('monto_letra');
            $convenio->fecha_inicio = $request->input('fecha_inicio');
            $convenio->fecha_fin = $request->input('fecha_fin');
            $convenio->capertura = $request->input('capertura');
            $convenio->cmensual = $request->input('cmensual');
            $convenio->ctrimestral = $request->input('ctrimestral');

            if (empty($request->status)) {
                $convenio->folio = $request->input('folio');
                $convenio->status = "Pendiente de activación";
            } elseif ($request->status == "Refrendado") {
                $convenio->status = "Pendiente de activación";
                Convenio::where('folio', $request->folio)->update(["status" => "Finiquitado"]);

                $convenioAct = Convenio::select()
                    ->orderBy("id", "desc")
                    ->first();

                $folio = explode("-", $convenioAct->folio);
                $num_convenio = intval($folio[3]) + 1;
                $num_convenio = str_pad($num_convenio, 2, "0", STR_PAD_LEFT);
                $folio_completo = $folio[0].'-'.$folio[1].'-'.$folio[2].'-'.$num_convenio.'-'.'00';

                $convenio->folio = strtoupper($folio_completo);
            } else {
                $convenio->folio = $request->input('folio');
                $convenio->status = $request->input('status');
            }

            $convenio->numerocuenta = $request->input('numerocuenta');
            $convenio->ps_id = $request->input('ps_id');
            $convenio->cliente_id = $request->input('cliente_id');
            $convenio->banco_id = $request->input('banco_id');

            $convenio->save();
            $convenio_id = $convenio->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Convenio";
            $log->id_tabla = $convenio_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            for ($i = 0; $i < 13; $i++) {
                $serie = "serie-pagops" . $i;
                $fechaPago = "fecha-pagops" . $i;
                $fechaLimite = "fecha-limitepagops" . $i;
                $pago = "pago-pagops" . $i;

                $pagoPSConvenio = new PagoPSConvenio;
                $pagoPSConvenio->tipo_pago = 'Pendiente';

                if ($i == 3 || $i == 6 || $i == 9 || $i == 12) {
                    $pagoPSConvenio->convenio_id = $convenio_id;
                    $pagoPSConvenio->serie = $request->input($serie);
                    $pagoPSConvenio->fecha_pago = $request->input($fechaPago);
                    $pagoPSConvenio->fecha_limite = $request->input($fechaLimite);
                    $pagoPSConvenio->pago = $request->input($pago);
                    $pagoPSConvenio->status = "Pendiente";
                    $pagoPSConvenio->memo = "Comisión mensual";

                    $pagoPSConvenio->save();

                    $pagoPSConvenio = new PagoPSConvenio;
                    $pagoPSConvenio->tipo_pago = 'Pendiente';
                    $pagoPSConvenio->convenio_id = $convenio_id;
                    $pagoPSConvenio->serie = $request->input("serie-pagops" . $i . "trimestral");
                    $pagoPSConvenio->fecha_pago = $request->input("fecha-pagops" . $i . "trimestral");
                    $pagoPSConvenio->fecha_limite = $request->input("fecha-limitepagops" . $i . "trimestral");
                    $pagoPSConvenio->pago = 0;
                    $pagoPSConvenio->status = "Pendiente";
                    $pagoPSConvenio->memo = "Comisión por rédito trimestral";

                    $pagoPSConvenio->save();
                } elseif ($i == 0) {
                    $serie = intval($request->input($serie));
                    $pagoPSConvenio->convenio_id = $convenio_id;
                    $pagoPSConvenio->serie = ($serie + 1);
                    $pagoPSConvenio->fecha_pago = $request->input($fechaPago);
                    $pagoPSConvenio->fecha_limite = $request->input($fechaLimite);
                    $pagoPSConvenio->pago = $request->input($pago);
                    $pagoPSConvenio->status = "Pendiente";
                    $pagoPSConvenio->memo = "Comisión por apertura";

                    $pagoPSConvenio->save();
                } else {
                    $pagoPSConvenio->convenio_id = $convenio_id;
                    $pagoPSConvenio->serie = $request->input($serie);
                    $pagoPSConvenio->fecha_pago = $request->input($fechaPago);
                    $pagoPSConvenio->fecha_limite = $request->input($fechaLimite);
                    $pagoPSConvenio->pago = $request->input($pago);
                    $pagoPSConvenio->status = "Pendiente";
                    $pagoPSConvenio->memo = "Comisión mensual";

                    $pagoPSConvenio->save();
                }
            }

            // if ($pagoPSConvenio->save()) {
            return response($convenio);
            // }
        }
    }

    public function editConvenio(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'folio' => 'required',
                'cliente_id' => 'required',
                'ps_id' => 'required',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'required|date',
                'capertura' => 'required',
                'cmensual' => 'required',
                'monto' => 'required',
                'monto_letra' => 'required',
                'status' => 'required',
                'banco_id' => 'required',
            ]);

            $convenio = Convenio::find($request->id);

            $convenio->monto = $request->input("monto");
            $convenio->monto_letra = $request->input("monto_letra");
            $convenio->fecha_inicio = $request->input('fecha_inicio');
            $convenio->fecha_fin = $request->input('fecha_fin');
            $convenio->capertura = $request->input('capertura');
            $convenio->cmensual = $request->input('cmensual');
            $convenio->ctrimestral = $request->input('ctrimestral');
            $convenio->numerocuenta = $request->input('numerocuenta');
            $convenio->ps_id = $request->input('ps_id');
            $convenio->cliente_id = $request->input('cliente_id');
            $convenio->banco_id = $request->input('banco_id');

            if ($request->status == "Refrendado") {
                $convenio->status = "Activado";
                $folio = explode("-", $request->folio);
                $refrendo = intval($folio[4]) + 1;
                $refrendo = str_pad($refrendo, 2, "0", STR_PAD_LEFT);
                $folio_completo = $folio[0].'-'.$folio[1].'-'.$folio[2].'-'.$folio[3].'-'.$refrendo;

                $convenio->folio = strtoupper($folio_completo);
            } else {
                $convenio->folio = strtoupper($request->folio);
                $convenio->status = $request->status;
            }

            // if ($request->status == "Refrendado") {
            //     $monto_ant = $convenio->monto;
            //     $monto_nvo = $request->monto;
            //     $folio_nvo = "";

            //     $folio_ant = $convenio->folio;

            //     $partes_folio = explode("-", $folio_ant);

            //     $num_items = count($partes_folio);
            //     $i = 0;

            //     foreach ($partes_folio as $parte_folio) {
            //         if (++$i === $num_items) {
            //             $num_refrendo = $parte_folio;
            //             $num_refrendo = intval($num_refrendo);
            //             $num_refrendo++;
                        
            //             if (strlen(strval($num_refrendo)) == 1) {
            //                 $num_refrendo = "0" . $num_refrendo;
            //             }

            //             $folio_nvo .= $num_refrendo;
            //         } else {
            //             $folio_nvo .= $parte_folio . '-';
            //         }
            //     }

            //     $convenio_new = new Convenio;

            //     $convenio_new->folio = $folio_nvo;
            //     $convenio_new->monto = $monto_nvo;
            //     $convenio_new->monto_letra = $request->monto_letra;
            //     $convenio_new->fecha_inicio = $request->fecha_fin;

            //     $fecha_fin_nvo = \Carbon\Carbon::parse($request->fecha_fin)->addYear()->toDateString();

            //     $convenio_new->fecha_fin = $fecha_fin_nvo;
            //     $convenio_new->capertura = $request->capertura;
            //     $convenio_new->cmensual = $request->cmensual;
            //     $convenio_new->ctrimestral = $request->ctrimestral;

            //     $convenio_new->status = "Pendiente de activación";

            //     $convenio_new->numerocuenta = $request->input('numerocuenta');
            //     $convenio_new->ps_id = $request->input('ps_id');
            //     $convenio_new->cliente_id = $request->input('cliente_id');
            //     $convenio_new->banco_id = $request->input('banco_id');

            //     $convenio_new->save();

            //     $convenionew_id = $convenio_new->id;

            //     // for ($i = 0; $i < 13; $i++) {
            //     //     $serie = "serie-pagops" . $i;
            //     //     $fechaPago = "fecha-pagops" . $i;
            //     //     $fechaLimite = "fecha-limitepagops" . $i;
            //     //     $pago = "pago-pagops" . $i;
    
            //     //     $pagoPSConvenio_new = new PagoPSConvenio;
            //     //     $pagoPSConvenio_new->tipo_pago = 'Pendiente';
    
            //     //     if ($i == 3 || $i == 6 || $i == 9 || $i == 12) {
            //     //         $pagoPSConvenio_new->convenio_id = $convenionew_id;
            //     //         $pagoPSConvenio_new->serie = $request->input($serie);
            //     //         $pagoPSConvenio_new->fecha_pago = $request->input($fechaPago);
            //     //         $pagoPSConvenio_new->fecha_limite = $request->input($fechaLimite);
            //     //         $pagoPSConvenio_new->pago = $request->input($pago);
            //     //         $pagoPSConvenio_new->status = "Pendiente";
            //     //         $pagoPSConvenio_new->memo = "Comisión mensual";
    
            //     //         $pagoPSConvenio_new->save();
    
            //     //         $pagoPSConvenio_new = new PagoPSConvenio;
            //     //         $pagoPSConvenio_new->tipo_pago = 'Pendiente';
            //     //         $pagoPSConvenio_new->convenio_id = $convenionew_id;
            //     //         $pagoPSConvenio_new->serie = $request->input("serie-pagops" . $i . "trimestral");
            //     //         $pagoPSConvenio_new->fecha_pago = $request->input("fecha-pagops" . $i . "trimestral");
            //     //         $pagoPSConvenio_new->fecha_limite = $request->input("fecha-limitepagops" . $i . "trimestral");
            //     //         $pagoPSConvenio_new->pago = 0;
            //     //         $pagoPSConvenio_new->status = "Pendiente";
            //     //         $pagoPSConvenio_new->memo = "Comisión por rédito trimestral";
    
            //     //         $pagoPSConvenio_new->save();
            //     //     } elseif ($i == 0) {
            //     //         $serie = intval($request->input($serie));
            //     //         $pagoPSConvenio_new->convenio_id = $convenionew_id;
            //     //         $pagoPSConvenio_new->serie = ($serie + 1);
            //     //         $pagoPSConvenio_new->fecha_pago = $request->input($fechaPago);
            //     //         $pagoPSConvenio_new->fecha_limite = $request->input($fechaLimite);
            //     //         $pagoPSConvenio_new->pago = $request->input($pago);
            //     //         $pagoPSConvenio_new->status = "Pendiente";
            //     //         $pagoPSConvenio_new->memo = "Comisión por apertura";
    
            //     //         $pagoPSConvenio_new->save();
            //     //     } else {
            //     //         $pagoPSConvenio_new->convenio_id = $convenionew_id;
            //     //         $pagoPSConvenio_new->serie = $request->input($serie);
            //     //         $pagoPSConvenio_new->fecha_pago = $request->input($fechaPago);
            //     //         $pagoPSConvenio_new->fecha_limite = $request->input($fechaLimite);
            //     //         $pagoPSConvenio_new->pago = $request->input($pago);
            //     //         $pagoPSConvenio_new->status = "Pendiente";
            //     //         $pagoPSConvenio_new->memo = "Comisión mensual";
    
            //     //         $pagoPSConvenio_new->save();
            //     //     }
            //     // }
            // } else {
            //     $convenio->monto = $request->input('monto');
            //     $convenio->monto_letra = $request->input('monto_letra');
            // }
            // $convenio->folio = $request->input('folio');
            // $convenio->fecha_inicio = $request->input('fecha_inicio');
            // $convenio->fecha_fin = $request->input('fecha_fin');
            // $convenio->capertura = $request->input('capertura');
            // $convenio->cmensual = $request->input('cmensual');
            // $convenio->ctrimestral = $request->input('ctrimestral');
            // if (empty($request->status)) {
            //     $convenio->status = "Pendiente de activación";
            // } else {
            //     $convenio->status = $request->input('status');
            // }
            // $convenio->numerocuenta = $request->input('numerocuenta');
            // $convenio->ps_id = $request->input('ps_id');
            // $convenio->cliente_id = $request->input('cliente_id');
            // $convenio->banco_id = $request->input('banco_id');

            $convenio_id = $convenio->id;

            DB::table('pago_ps_convenio')->where('convenio_id', '=', $convenio_id)->delete();

            for ($i = 0; $i < 13; $i++) {
                $serie = "serie-pagops" . $i;
                $fechaPago = "fecha-pagops" . $i;
                $fechaLimite = "fecha-limitepagops" . $i;
                $pago = "pago-pagops" . $i;

                $pagoPSConvenio = new PagoPSConvenio;
                $pagoPSConvenio->tipo_pago = 'Pendiente';

                if ($i == 3 || $i == 6 || $i == 9 || $i == 12) {
                    $pagoPSConvenio->convenio_id = $convenio_id;
                    $pagoPSConvenio->serie = $request->input($serie);
                    $pagoPSConvenio->fecha_pago = $request->input($fechaPago);
                    $pagoPSConvenio->fecha_limite = $request->input($fechaLimite);
                    $pagoPSConvenio->pago = $request->input($pago);
                    $pagoPSConvenio->status = "Pendiente";
                    $pagoPSConvenio->memo = "Comisión mensual";

                    $pagoPSConvenio->save();

                    $pagoPSConvenio = new PagoPSConvenio;
                    $pagoPSConvenio->tipo_pago = 'Pendiente';
                    $pagoPSConvenio->convenio_id = $convenio_id;
                    $pagoPSConvenio->serie = $request->input("serie-pagops" . $i . "trimestral");
                    $pagoPSConvenio->fecha_pago = $request->input("fecha-pagops" . $i . "trimestral");
                    $pagoPSConvenio->fecha_limite = $request->input("fecha-limitepagops" . $i . "trimestral");
                    $pagoPSConvenio->pago = 0;
                    $pagoPSConvenio->status = "Pendiente";
                    $pagoPSConvenio->memo = "Comisión por rédito trimestral";

                    $pagoPSConvenio->save();
                } elseif ($i == 0) {
                    $serie = intval($request->input($serie));
                    $pagoPSConvenio->convenio_id = $convenio_id;
                    $pagoPSConvenio->serie = ($serie + 1);
                    $pagoPSConvenio->fecha_pago = $request->input($fechaPago);
                    $pagoPSConvenio->fecha_limite = $request->input($fechaLimite);
                    $pagoPSConvenio->pago = $request->input($pago);
                    $pagoPSConvenio->status = "Pendiente";
                    $pagoPSConvenio->memo = "Comisión por apertura";

                    $pagoPSConvenio->save();
                } else {
                    $pagoPSConvenio->convenio_id = $convenio_id;
                    $pagoPSConvenio->serie = $request->input($serie);
                    $pagoPSConvenio->fecha_pago = $request->input($fechaPago);
                    $pagoPSConvenio->fecha_limite = $request->input($fechaLimite);
                    $pagoPSConvenio->pago = $request->input($pago);
                    $pagoPSConvenio->status = "Pendiente";
                    $pagoPSConvenio->memo = "Comisión mensual";

                    $pagoPSConvenio->save();
                }
            }

            $convenio->update();

            // $convenio_id = $convenio->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Convenio";
            $log->id_tabla = $convenio_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();


            return response($convenio);
        }
    }

    public function deleteConvenio(Request $request)
    {
        $convenio_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Convenio";
        $log->id_tabla = $convenio_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Convenio::destroy($request->id);
            }
        }
    }

    public function validateClave(Request $request)
    {
        $clave = DB::table('users')->where("id", "=", auth()->user()->id)->first();

        if (\Hash::check($request->clave, $clave->password)) {
            return response("success");
        }else{
            return response("error");
        }
    }

    public function editStatus(Request $request)
    {
        $convenio = Convenio::find($request->id);
        $id_user = auth()->user()->id;

        if($request->status == "Activado"){
            $convenio->memo_status = "Convenio activado por id:1";

            $notificacion = new Notificacion;
            $notificacion->titulo = "Hamilton activó un nuevo convenio";
            $notificacion->mensaje = "El convenio con folio $convenio->folio ha sido activado";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 1;
            $notificacion->save();

            $notificacion = new Notificacion;
            $notificacion->titulo = "Hamilton activó un nuevo convenio";
            $notificacion->mensaje = "El convenio con folio $convenio->folio ha sido activado";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 234;
            $notificacion->save();

            $notificacion = new Notificacion;
            $notificacion->titulo = "Hamilton activó un nuevo convenio";
            $notificacion->mensaje = "El convenio con folio $convenio->folio ha sido activado";
            $notificacion->status = "Pendiente";
            $notificacion->user_id = 235;
            $notificacion->save();

        }elseif($request->status == "Pendiente de activación"){
            $convenio->memo_status = "Convenio desactivado por id:$id_user";
        }elseif($request->status == "Finiquitado"){
            $convenio->memo_status = "Convenio finiquitado por id:$id_user";
        }elseif($request->status == "Refrendado"){
            $convenio->memo_status = "Convenio refrendado por id:$id_user";
        }

        $convenio->status = $request->status;
        $convenio->update();

        return response($convenio);
    }

    public function getPreview(Request $request)
    {
        $id = $request->id;

        $convenio = DB::table('convenio')
            ->where('id', '=', $id)
            ->get();

        return view('convenio.preview', compact('convenio'));
    }

    public function imprimirConvenio(Request $request)
    {

        $convenio = DB::table('convenio')
            ->join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->join('banco', 'banco.id', '=', 'convenio.banco_id')
            ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.memo_status, convenio.numerocuenta, ps.id AS ps_id, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, banco.nombre AS banconombre"))
            ->where('convenio.id', '=', $request->id)
            ->get();

        if(!empty($convenio[0]->memo_status)){
            $memo = explode(":", $convenio[0]->memo_status);
            $holograma_fecha = strtotime($convenio[0]->fecha_inicio);

            if (isset($memo[1])) {
                $holograma2 = $holograma_fecha."U".$convenio[0]->monto."P".$memo[1];
            }else{
                $holograma2 = "";
            }

        }else{
            $holograma2 = "";
        }

        $pdf = PDF::loadView('convenio.imprimir', ['convenio' => $convenio, 'convenio2' => $convenio, 'holograma2' => $holograma2]);

        $fecha_hoy = Carbon::now();
        $nombreDescarga = $convenio[0]->folio.'_'.$convenio[0]->clientenombre.'_'.$fecha_hoy->format('d-m-Y').'.pdf';

        $visualizacion = $pdf->stream($nombreDescarga);
        Storage::disk('convenios')->put($nombreDescarga, $visualizacion);

        return $visualizacion;
    }

    public function getFolioConvenio(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $opc = $request->opc;

            if ($opc == 1) {
                $cliente = DB::table("cliente")
                    ->select("codigoCliente")
                    ->where("id", "=", $id)
                    ->get();

                $codigoCliente = $cliente[0]->codigoCliente;
                $codigoCliente = explode("-", $codigoCliente);

                $codigoCliente = $codigoCliente[2];

                $convenios = Convenio::where("cliente_id", $id)
                    ->count();

                $convenios++;

                if (strlen(strval($convenios)) == 1) {
                    $convenios = '-MAM-0' . $convenios;
                } else {
                    $convenios = '-MAM-' . $convenios;
                }

                return response($codigoCliente . $convenios . '-00', 200);
            } elseif ($opc == 2) {
                $ps = Ps::where("id", $id)
                    ->get();

                $oficina_id = $ps[0]->oficina_id;

                $oficina = Oficina::where("id", $oficina_id)
                    ->get();

                $codigo_oficina = $oficina[0]->codigo_oficina;

                return response($codigo_oficina, 200);
            }
        }
    }

    public function enviarTelegram(Request $request)
    {
        $folio = explode("Folio de convenio: ", $request->mensaje);
        \Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID'),
            'parse_mode' => 'HTML',
            'text' => $folio[0]
        ]);

        \Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHANNEL_ID'),
            'parse_mode' => 'HTML',
            'text' => $folio[1]
        ]);
    }
}
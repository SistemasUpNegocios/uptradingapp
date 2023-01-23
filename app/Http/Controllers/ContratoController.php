<?php

namespace App\Http\Controllers;

use App\Models\Amortizacion;
use App\Models\Beneficiario;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Log;
use App\Models\Modelo;
use App\Models\TipoCambio;
use App\Models\PagoCliente;
use App\Models\PagoPS;
use App\Models\Ps;
use App\Models\TipoContrato;
use App\Models\Pendiente;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ZipArchive;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Storage;

class ContratoController extends Controller
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

            $ps = Ps::select()->where("codigoPS", "like", "$codigo%")->get();
            $clientes = Cliente::select()->orderBy("apellido_p")->where("codigoCliente", "like", "$numeroCliente%")->get();
            $tipos = TipoContrato::all();
            $pendientes = DB::table('pendiente')
                ->select()
                ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->where('oficina.codigo_oficina', 'like', $codigo)
                ->get();

            $data = array(
                "lista_ps" => $ps,
                "lista_clientes" => $clientes,
                "lista_tipos" => $tipos,
                "lista_pendientes" => $pendientes,
            );

            return response()->view('contrato.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getContrato()
    {
        
        $codigo = session('codigo_oficina');
        $psid = session('psid');
        $clienteid = session('clienteid');

        if (auth()->user()->is_ps_gold) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();            
            $psid = $ps_cons->id;
        }

        $cliente_con = Cliente::select()->where("correo_institucional", auth()->user()->correo)->first();        
        if (strlen($cliente_con) > 0) {
            $clienteid = $cliente_con->id;
            $contrato = DB::table('contrato')
                ->join('ps', 'ps.id', '=', 'contrato.ps_id')
                ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
                ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("contrato.id, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.operador_ine, contrato.fecha_renovacion, contrato.fecha_pago, contrato.fecha_limite, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.celular, tipo_contrato.id AS tipoid, tipo_contrato.tipo, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, tipo_contrato.rendimiento, contrato.porcentaje, contrato.folio, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.fecha_reintegro, contrato.status_reintegro, contrato.memo_reintegro, contrato.status, contrato.pendiente_id AS pendienteid, contrato.tipo_pago, contrato.monto_pago, contrato.comprobante_pago"))
                ->where(function ($query) use ($psid, $clienteid) {
                    $query->where("contrato.ps_id", "like", $psid)
                    ->orWhere("contrato.cliente_id", "like", $clienteid);
                })
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where("contrato.status", "!=", "Cancelado")
                ->where("contrato.status", "!=", "Finiquitado")
                ->get();
        }else{
            $contrato = DB::table('contrato')
                ->join('ps', 'ps.id', '=', 'contrato.ps_id')
                ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
                ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("contrato.id, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.operador_ine, contrato.fecha_renovacion, contrato.fecha_pago, contrato.fecha_limite, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.celular, tipo_contrato.id AS tipoid, tipo_contrato.tipo, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, tipo_contrato.rendimiento, contrato.porcentaje, contrato.folio, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.fecha_reintegro, contrato.status_reintegro, contrato.memo_reintegro, contrato.status, contrato.pendiente_id AS pendienteid, contrato.tipo_pago, contrato.monto_pago, contrato.comprobante_pago"))
                ->where("contrato.ps_id", "like", $psid)
                ->where("contrato.cliente_id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where("contrato.status", "!=", "Cancelado")
                ->where("contrato.status", "!=", "Finiquitado")
                ->get();
        }

        if (auth()->user()->is_cliente) {
            $clienteid = $cliente_con->id;
            $contrato = DB::table('contrato')
                ->join('ps', 'ps.id', '=', 'contrato.ps_id')
                ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
                ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("contrato.id, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.operador_ine, contrato.fecha_renovacion, contrato.fecha_pago, contrato.fecha_limite, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.celular, tipo_contrato.id AS tipoid, tipo_contrato.tipo, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, tipo_contrato.rendimiento, contrato.porcentaje, contrato.folio, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.fecha_reintegro, contrato.status_reintegro, contrato.memo_reintegro, contrato.status, contrato.pendiente_id AS pendienteid, contrato.tipo_pago, contrato.monto_pago, contrato.comprobante_pago"))
                ->where("contrato.ps_id", "like", $psid)
                ->where("contrato.cliente_id", "like", $clienteid)
                ->where("oficina.codigo_oficina", "like", $codigo)
                ->where("contrato.status", "!=", "Cancelado")
                ->where("contrato.status", "!=", "Finiquitado")
                ->get();
        }

        return datatables()->of($contrato)->addColumn('btn', 'contrato.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addContrato(Request $request)
    {
        if ($request->ajax()) {

            $codigo = session("codigo_oficina");
            if ($codigo == "%") {
                $codigo = "001";
            }

            $request->validate([
                'operador' => 'required',
                'operador_ine' => 'required',
                'contrato' => 'required|unique:contrato',
                'lugar_firma' => 'required',
                'fechainicio' => 'required|date',
                'periodo' => 'required',
                'fecha_renovacion' => 'required|date',
                'fecha_pago' => 'required|date',
                'fecha_limite' => 'required|date',
                'folio' => 'required',
                'tipo_cambio' => 'required',
                'porcentaje' => 'required',
                'inversion' => 'required',
                'inversion_us' => 'required',
                'inversion_letra' => 'required',
                'inversion_letra_us' => 'required',
                'fecha_reintegro' => 'required|date',
            ]);

            $contrato = new Contrato;

            $lugar = mb_convert_encoding(ucwords(strtolower($request->lugar_firma)), 'UTF-8', 'UTF-8');
            $lugar = str_replace('?', 'é', $lugar);

            $contrato->folio = $request->input('folio');
            $contrato->operador = strtoupper($request->input('operador'));
            $contrato->operador_ine = $request->input('operador_ine');
            $contrato->lugar_firma =  $lugar;
            $contrato->periodo = strtoupper($request->input('periodo'));
            $contrato->fecha = $request->input('fechainicio');
            $contrato->fecha_renovacion = $request->input('fecha_renovacion');
            $contrato->fecha_pago = $request->input('fecha_pago');
            $contrato->fecha_limite = $request->input('fecha_limite');
            $contrato->contrato = strtoupper($request->input('contrato'));
            $contrato->ps_id = $request->input('ps_id');
            $contrato->cliente_id = $request->input('cliente_id');
            $contrato->tipo_id = $request->input('tipo_id');
            $contrato->porcentaje = $request->input('porcentaje');
            $contrato->tipo_cambio = $request->input('tipo_cambio');
            $contrato->inversion = $request->input('inversion');
            $contrato->inversion_us = $request->input('inversion_us');
            $contrato->inversion_letra = $request->input('inversion_letra');
            $contrato->inversion_letra_us = $request->input('inversion_letra_us');
            $contrato->fecha_reintegro = $request->input('fecha_reintegro');
            $contrato->status_reintegro = 'pendiente';
            $contrato->memo_reintegro = strtoupper($request->input('memo_reintegro'));
            $contrato->fecha_carga = date('Y-m-d H:i:s', strtotime("now"));
            $contrato->pendiente_id = $request->input('pendiente_id');
            $contrato->memo_status = $request->input('memo_status');

            if (empty($request->status)) {
                $contrato->contrato = strtoupper($request->input('contrato'));
                $contrato->status = "Pendiente de activación";
            } elseif ($request->status == "Refrendado") {
                $contrato->status = "Pendiente de activación";

                Contrato::where('contrato', strtoupper($request->contrato))->update(["status" => "Finiquitado"]);

                $contratoNew = explode("-", $request->contrato);

                $contratoRef = Contrato::select()
                    ->orderBy("contrato", "desc")
                    ->where("contrato", "like", $contratoNew[0] . "-%")
                    ->first();

                if (!empty($contratoRef)) {
                    $contratoNum = explode("-", $contratoRef->contrato);
                    $contratoNum = intval($contratoNum[1]) + 1;
                } else {
                    $contratoNum = intval($contratoNew[1]) + 1;
                }

                $contratoNum = str_pad($contratoNum, 3, "0", STR_PAD_LEFT);
                $contratoNum = $contratoNew[0] . "-" . $contratoNum . "-00";

                $contrato->contrato = strtoupper($contratoNum);
            } else {
                $contrato->contrato = strtoupper($request->input('contrato'));
                $contrato->status = $request->input('status');
            }

            if (gettype($request->tipo_pago) != 'NULL'){
                $tipos_pagos = "";
                foreach ($request->tipo_pago as $tipo_pago) {
                    $tipos_pagos .= $tipo_pago.',';
                }
                $contrato->tipo_pago = $tipos_pagos;
            }

            gettype($request->monto_pago);

            if(count($request->monto_pago) > 0 ){
                $montos_pagos = "";
                foreach ($request->monto_pago as $monto_pago) {
                    if($monto_pago > 0){
                        $montos_pagos .= $monto_pago.',';
                    }
                }
                $contrato->monto_pago = $montos_pagos;
            }

            if ($request->hasFile('comprobante_pago')) {

                $comprobantes_pagos = "";
                $tipo = explode(",", $tipos_pagos);
                $i = 0;
                foreach($request->file('comprobante_pago') as $key => $comprobante_pago){
                    $ext = $comprobante_pago->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    
                    if(strlen($tipo[$i]) > 0){
                        $filename = $request->contrato . "_comprobante_" . $tipo[$i] . $ext;
                    }else{
                        $filename = $request->contrato . "_comprobante_" . $i . $ext;
                    }

                    $comprobante_pago->move(public_path("documentos/comprobantes_pagos/$request->contrato/"), $filename);
                    $comprobantes_pagos .= $filename.',';

                    $public_dir = public_path("documentos/comprobantes_pagos/$request->contrato");
                    $zipFileName = $request->contrato.'.zip';
                    $zip = new ZipArchive;
    
                    if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
                        $zip->addFile($public_dir . '/'.$filename, $filename);
                        $zip->close();
                    }

                    $i++;
                }

                $contrato->comprobante_pago = $comprobantes_pagos;
            }

            if (!empty($request->input('pendiente_id'))) {
                $contrato->pendiente_id = $request->input('pendiente_id');
            }

            $contrato->save();

            $tipo_cambio = new TipoCambio;
            $tipo_cambio->valor = $request->tipo_cambio;
            $tipo_cambio->contrato_id = $contrato->id;
            $tipo_cambio->memo = "Creación de contrato";
            $tipo_cambio->save();

            $contrato_id = $contrato->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Contrato";
            $log->id_tabla = $contrato_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            $periodo = $request->input('periodo');

            //editar el numero del cliente conforme a su número de contratos
            $numeroContratos = "MXN-$codigo-$request->contrato";

            $cliente = Cliente::find($request->cliente_id);
            $cliente->codigoCliente = $numeroContratos;
            $cliente->update();

            //agregar en la tabla beneficiarios
            for ($i = 0; $i <= 3; $i++) {
                if ($request->input('nombre-ben' . $i)) {
                    $nombre = 'nombre-ben' . ($i);
                    $porcentaje = 'porcentaje-ben' . ($i);
                    $telefono = 'telefono-ben' . ($i);
                    $correo_electronico = 'correo-ben' . ($i);
                    $curp = 'curp-ben' . ($i);

                    $beneficiario = new Beneficiario;

                    $beneficiario->contrato_id = $contrato_id;
                    $beneficiario->nombre = strtoupper($request->input($nombre));
                    $beneficiario->porcentaje = $request->input($porcentaje);
                    $beneficiario->telefono = $request->input($telefono);
                    $beneficiario->correo_electronico = strtoupper($request->input($correo_electronico));
                    $beneficiario->curp = strtoupper($request->input($curp));

                    $beneficiario->save();
                }
            }

            $tipo_id = $contrato->tipo_id;

            $tipo_contrato = DB::table('tipo_contrato')
                ->where('id', $tipo_id)
                ->get();

            $fecha_inicio = $contrato->fecha;
            $fecha_pago = Carbon::parse($fecha_inicio);
            $fecha_amortizacion = Carbon::parse($fecha_inicio);
            $fecha_feb = Carbon::parse($fecha_inicio);
            $fecha_nueva = Carbon::parse($fecha_inicio);
            $fechaFeb = Carbon::parse($fecha_inicio);
            
            $fecha_limite = "";

            $capertura = $tipo_contrato[0]->capertura;
            $capertura = $capertura * .01;

            $cmensual = $tipo_contrato[0]->cmensual;
            $cmensual = $cmensual * .001;

            $rendimiento = $contrato->porcentaje;
            $rendimiento = $rendimiento * .01;

            $monto = $contrato->inversion_us;

            if ($tipo_contrato[0]->tipo == "Rendimiento compuesto") {
                for ($i = 0; $i < $periodo; $i++) {
                    if ($fecha_limite == "") {
                        $fecha_pago->addMonth()->endOfMonth();
                        $fecha_pago->format('Y-m-d');
                    } else {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                    }

                    $fecha_limite = Carbon::parse($fecha_pago);
                    $fecha_limite->setDay(10)->addMonth();

                    $fecha_limite->format('Y-m-d');
                    if ($i == 0) {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato_id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = floatval(number_format(($pago * $capertura), 2));
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión por apertura';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();

                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato_id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = floatval(number_format(($pago * $cmensual), 2));
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    } else {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato_id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = floatval(number_format(($pago * $cmensual), 2));
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    }

                    $amortizacion = new Amortizacion;

                    $amortizacion->contrato_id = $contrato_id;
                    $amortizacion->serie = ($i + 1);
                    
                    $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                    $fecha_dia = $fecha_nueva->format('d');
                    $fecha_mes = $fechaFeb->format('m');
                    $fecha_anio = $fechaFeb->format('Y');

                    if ($fecha_mes == 2){
                        if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                            $amortizacion->fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                        }else{
                            $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
                    }else if ($fecha_dia == 31){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else if($fecha_dia == 29 || $fecha_dia == 30){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else{
                        $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                    }

                    $amortizacion->monto = $monto;
                    $redito = $monto * $rendimiento;
                    $amortizacion->redito = $redito;
                    $amortizacion->saldo_con_redito = ($monto + $redito);
                    $monto = ($monto + $redito);

                    $amortizacion->save();
                }

                $pago_cliente = $amortizacion->saldo_con_redito;
                $fecha_pago_cliente_inicial = $amortizacion->fecha;

                $fecha_pago_cliente = Carbon::parse($fecha_pago_cliente_inicial);

                $pago_cliente_table = new PagoCliente;

                $pago_cliente_table->contrato_id = $contrato_id;
                $pago_cliente_table->serie = ($i + 1);
                $pago_cliente_table->fecha_pago = $fecha_pago_cliente;
                $pago_cliente_table->pago = $pago_cliente;
                $pago_cliente_table->status = "Pendiente";
                $pago_cliente_table->tipo_pago = "Pendiente";

                $pago_cliente_table->save();
            } elseif ($tipo_contrato[0]->tipo == "Rendimiento mensual") {
                $fecha_pago_cliente = Carbon::parse($fecha_inicio);

                for ($i = 0; $i < $periodo; $i++) {
                    if ($fecha_limite == "") {
                        $fecha_pago->addMonth()->endOfMonth();
                        $fecha_pago->format('Y-m-d');
                    } else {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                    }

                    $fecha_limite = Carbon::parse($fecha_pago);
                    $fecha_limite->setDay(10)->addMonth();

                    $fecha_limite->format('Y-m-d');
                    if ($i == 0) {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato_id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = floatval(number_format(($pago * $capertura), 2));
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión por apertura';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();

                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato_id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = floatval(number_format(($pago * $cmensual), 2));
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    } else {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato_id;
                        $pagops->serie = 12;
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = floatval(number_format(($pago * $cmensual), 2));
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    }

                    $amortizacion = new Amortizacion;

                    $amortizacion->contrato_id = $contrato_id;
                    $amortizacion->serie = ($i + 1);
                    
                    $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                    $fecha_dia = $fecha_nueva->format('d');
                    $fecha_mes = $fechaFeb->format('m');
                    $fecha_anio = $fechaFeb->format('Y');

                    if ($fecha_mes == 2){
                        if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                            $amortizacion->fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                        }else{
                            $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
                    }else if ($fecha_dia == 31){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else if($fecha_dia == 29 || $fecha_dia == 30){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else{
                        $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                    }

                    $amortizacion->monto = $monto;
                    $redito = $monto * $rendimiento;
                    $amortizacion->redito = $redito;
                    $amortizacion->saldo_con_redito = ($monto + $redito);

                    $amortizacion->save();

                    $pago_cliente_table = new PagoCliente;

                    $pago_cliente_table->contrato_id = $contrato_id;
                    $pago_cliente_table->serie = ($i + 1);
                    
                    if ($fecha_mes == 2){
                        if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                            $pago_cliente_table->fecha_pago = $fecha_pago_cliente->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                        }else{
                            $pago_cliente_table->fecha_pago = $fecha_pago_cliente->addMonth()->format('Y-m-d');
                        }
                    }else if ($fecha_dia == 31){
                        $fecha_pago_cliente = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                        $pago_cliente_table->fecha_pago = $fecha_pago_cliente->format('Y-m-d');
                    }else if($fecha_dia == 29 || $fecha_dia == 30){
                        $fecha_pago_cliente = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                        $pago_cliente_table->fecha_pago = $fecha_pago_cliente->format('Y-m-d');
                    }else{
                        $pago_cliente_table->fecha_pago = $fecha_pago_cliente->addMonth()->format('Y-m-d');
                    }
                    
                    $pago_cliente_table->pago = $redito;
                    $pago_cliente_table->status = "Pendiente";
                    $pago_cliente_table->tipo_pago = "Pendiente";

                    $pago_cliente_table->save();
                }
            }

            return response($contrato);
        }
    }

    public function editContrato(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'operador' => 'required',
                'operador_ine' => 'required',
                'contrato' => 'required',
                'lugar_firma' => 'required',
                'fechainicio' => 'required|date',
                'periodo' => 'required',
                'fecha_renovacion' => 'required|date',
                'fecha_pago' => 'required|date',
                'fecha_limite' => 'required|date',
                'folio' => 'required',
                'tipo_cambio' => 'required',
                'porcentaje' => 'required',
                'inversion' => 'required',
                'inversion_us' => 'required',
                'inversion_letra' => 'required',
                'inversion_letra_us' => 'required',
                'fecha_reintegro' => 'required|date',
            ]);

            $contrato = Contrato::find($request->id);
            
            $lugar = mb_convert_encoding(ucwords(strtolower($request->lugar_firma)), 'UTF-8', 'UTF-8');
            $lugar = str_replace('?', 'é', $lugar);

            $contrato->folio = $request->input('folio');
            $contrato->operador = strtoupper($request->input('operador'));
            $contrato->operador_ine = $request->input('operador_ine');
            $contrato->lugar_firma =  $lugar;
            $contrato->fecha = $request->input('fechainicio');
            $contrato->fecha_renovacion = $request->input('fecha_renovacion');
            $contrato->fecha_pago = $request->input('fecha_pago');
            $contrato->fecha_limite = $request->input('fecha_limite');
            $contrato->periodo = strtoupper($request->input('periodo'));
            $contrato->contrato = strtoupper($request->input('contrato'));
            $contrato->ps_id = $request->input('ps_id');
            // $contrato->cliente_id = $request->input('cliente_id');
            $contrato->tipo_id = $request->input('tipo_id');
            $contrato->porcentaje = $request->input('porcentaje');
            $contrato->tipo_cambio = $request->input('tipo_cambio');
            $contrato->inversion = $request->input('inversion');
            $contrato->inversion_us = $request->input('inversion_us');
            $contrato->inversion_letra = $request->input('inversion_letra');
            $contrato->inversion_letra_us = $request->input('inversion_letra_us');
            $contrato->fecha_reintegro = $request->input('fecha_reintegro');
            $contrato->status_reintegro = $request->input('status_reintegro');
            $contrato->memo_reintegro = strtoupper($request->input('memo_reintegro'));
            $contrato->memo_status = $request->input('memo_status');
            if ($request->status == "Refrendado") {
                $contrato->status = "Activado";
                $contratoAct = explode("-", $request->contrato);
                $contratoRef = intval($contratoAct[2]) + 1;
                $contratoRef = str_pad($contratoRef, 2, "0", STR_PAD_LEFT);
                $contratoRef = $contratoAct[0] . "-" . $contratoAct[1] . "-" . $contratoRef;
                $contrato->contrato = strtoupper($contratoRef);
            } else {
                $contrato->contrato = strtoupper($request->input('contrato'));
                $contrato->status = $request->input('status');
            }

            if (gettype($request->tipo_pago) != 'NULL'){
                $tipos_pagos = "";
                foreach ($request->tipo_pago as $tipo_pago) {
                    $tipos_pagos .= $tipo_pago.',';
                }
                $contrato->tipo_pago = $tipos_pagos;
            }

            if(count($request->monto_pago) > 0 ){
                $montos_pagos = "";
                foreach ($request->monto_pago as $monto_pago) {
                    if($monto_pago > 0){
                        $montos_pagos .= $monto_pago.',';
                    }
                }
                $contrato->monto_pago = $montos_pagos;
            }

            if (is_file(public_path("documentos/comprobantes_pagos/$request->contrato/") . $request->contrato.'.zip')) {
                chmod(public_path("documentos/comprobantes_pagos/$request->contrato/") . $request->contrato.'.zip', 0777);
                unlink(public_path("documentos/comprobantes_pagos/$request->contrato/") . $request->contrato.'.zip');
            }

            if ($request->hasFile('comprobante_pago')) {

                $comprobantes_pagos = "";
                $tipo = explode(",", $tipos_pagos);
                $i = 0;
                foreach($request->file('comprobante_pago') as $key => $comprobante_pago){
                    $ext = $comprobante_pago->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    
                    if(strlen($tipo[$i]) > 0){
                        $filename = $request->contrato . "_comprobante_" . $tipo[$i] . $ext;
                    }else{
                        $filename = $request->contrato . "_comprobante_" . $i . $ext;
                    }

                    if (is_file(public_path("documentos/comprobantes_pagos/$request->contrato/") . $filename)) {
                        chmod(public_path("documentos/comprobantes_pagos/$request->contrato/") . $filename, 0777);
                        unlink(public_path("documentos/comprobantes_pagos/$request->contrato/") . $filename);
                    }

                    $comprobante_pago->move(public_path("documentos/comprobantes_pagos/$request->contrato/"), $filename);
                    $comprobantes_pagos .= $filename.',';

                    $public_dir = public_path("documentos/comprobantes_pagos/$request->contrato");
                    $zipFileName = $request->contrato.'.zip';
                    $zip = new ZipArchive;
    
                    if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
                        $zip->addFile($public_dir . '/'.$filename, $filename);
                        $zip->close();
                    }

                    $i++;
                }

                $contrato->comprobante_pago = $comprobantes_pagos;
            }

            if (!empty($request->input('pendiente_id'))) {
                $contrato->pendiente_id = $request->input('pendiente_id');
            }

            $contrato_id = $contrato->id;

            DB::table('amortizacion')->where('contrato_id', '=', $contrato_id)->delete();
            DB::table('beneficiario')->where('contrato_id', '=', $contrato_id)->delete();
            DB::table('pago_ps')->where('contrato_id', '=', $contrato_id)->delete();
            DB::table('pago_cliente')->where('contrato_id', '=', $contrato_id)->delete();
            if ($request->input("redito-reintegro1") > 0) {
                DB::table('amortizacion')->where('contrato_id', '=', $contrato_id)->delete();
            }

            $periodo = $request->input('periodo');

            for ($i = 0; $i <= 3; $i++) {
                if ($request->input('nombre-ben' . $i)) {
                    $nombre = 'nombre-ben' . ($i);
                    $porcentaje = 'porcentaje-ben' . ($i);
                    $telefono = 'telefono-ben' . ($i);
                    $correo_electronico = 'correo-ben' . ($i);
                    $curp = 'curp-ben' . ($i);

                    $beneficiario = new Beneficiario;

                    $beneficiario->contrato_id = $contrato_id;
                    $beneficiario->nombre = strtoupper($request->input($nombre));
                    $beneficiario->porcentaje = $request->input($porcentaje);
                    $beneficiario->telefono = $request->input($telefono);
                    $beneficiario->correo_electronico = strtoupper($request->input($correo_electronico));
                    $beneficiario->curp = strtoupper($request->input($curp));

                    $beneficiario->save();
                }
            }

            $tipo_id = $request->tipo_id;

            $tipo_contrato = DB::table('tipo_contrato')
                ->where('id', $tipo_id)
                ->get();

            $fecha_inicio = $contrato->fecha;
            $fecha_pago = Carbon::parse($fecha_inicio);
            $fecha_amortizacion = Carbon::parse($fecha_inicio);
            $fecha_feb = Carbon::parse($fecha_inicio);
            $fecha_nueva = Carbon::parse($fecha_inicio);
            $fechaFeb = Carbon::parse($fecha_inicio);

            $fecha_limite = "";

            $capertura = $tipo_contrato[0]->capertura;
            $capertura = $capertura * .01;

            $cmensual = $tipo_contrato[0]->cmensual;
            $cmensual = $cmensual * .001;

            $rendimiento = $contrato->porcentaje;
            $rendimiento = $rendimiento * .01;

            $monto = $contrato->inversion_us;

            if ($tipo_contrato[0]->tipo == "Rendimiento compuesto") {
                for ($i = 0; $i < $periodo; $i++) {
                    if ($fecha_limite == "") {
                        $fecha_pago->addMonth()->endOfMonth();
                        $fecha_pago->format('Y-m-d');
                    } else {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                    }

                    $fecha_limite = Carbon::parse($fecha_pago);
                    $fecha_limite->setDay(10)->addMonth();

                    $fecha_limite->format('Y-m-d');
                    if ($i == 0) {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $capertura), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión por apertura';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();

                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $cmensual), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    } else {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $cmensual), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    }

                    $amortizacion = new Amortizacion;

                    $amortizacion->contrato_id = $contrato->id;
                    $amortizacion->serie = ($i + 1);
                    
                    $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                    $fecha_dia = $fecha_nueva->format('d');
                    $fecha_mes = $fechaFeb->format('m');
                    $fecha_anio = $fechaFeb->format('Y');            

                    if ($fecha_mes == 2){
                        if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                            $amortizacion->fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                        }else{
                            $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
                    }else if ($fecha_dia == 31){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else if($fecha_dia == 29 || $fecha_dia == 30){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else{
                        $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                    }

                    $amortizacion->monto = round($monto, 2);
                    $redito = $monto * $rendimiento;
                    $amortizacion->redito = round($redito, 2);
                    $amortizacion->saldo_con_redito = round(($monto + $redito), 2);
                    $monto = ($monto + $redito);

                    $amortizacion->save();
                }

                $pago_cliente = $amortizacion->saldo_con_redito;
                $fecha_pago_cliente_inicial = $amortizacion->fecha;

                $fecha_pago_cliente = Carbon::parse($fecha_pago_cliente_inicial);

                $pago_cliente_table = new PagoCliente;

                $pago_cliente_table->contrato_id = $contrato_id;
                $pago_cliente_table->serie = ($i + 1);
                $pago_cliente_table->fecha_pago = $fecha_pago_cliente;
                $pago_cliente_table->pago = $pago_cliente;
                $pago_cliente_table->status = "Pendiente";
                $pago_cliente_table->tipo_pago = "Pendiente";

                $pago_cliente_table->save();
            } elseif ($tipo_contrato[0]->tipo == "Rendimiento mensual") {
                $fecha_pago_cliente = Carbon::parse($fecha_inicio);

                for ($i = 0; $i < $periodo; $i++) {
                    if ($fecha_limite == "") {
                        $fecha_pago->addMonth()->endOfMonth();
                        $fecha_pago->format('Y-m-d');
                    } else {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                    }

                    $fecha_limite = Carbon::parse($fecha_pago);
                    $fecha_limite->setDay(10)->addMonth();

                    $fecha_limite->format('Y-m-d');
                    if ($i == 0) {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato_id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $capertura), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión por apertura';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();

                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $cmensual), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    } else {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $cmensual), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    }                    

                    $amortizacion = new Amortizacion;

                    $amortizacion->contrato_id = $contrato->id;
                    $amortizacion->serie = ($i + 1);

                    $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                    $fecha_dia = $fecha_nueva->format('d');
                    $fecha_mes = $fechaFeb->format('m');
                    $fecha_anio = $fechaFeb->format('Y');

                    if ($fecha_mes == 2){
                        if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                            $amortizacion->fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                        }else{
                            $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
                    }else if ($fecha_dia == 31){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else if($fecha_dia == 29 || $fecha_dia == 30){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else{
                        $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                    }

                    $amortizacion->monto = round($monto, 2);
                    $redito = $monto * $rendimiento;
                    $amortizacion->redito = round($redito, 2);
                    $amortizacion->saldo_con_redito = round(($monto + $redito), 2);

                    $amortizacion->save();

                    $pago_cliente_table = new PagoCliente;

                    $pago_cliente_table->contrato_id = $contrato->id;
                    $pago_cliente_table->serie = ($i + 1);

                    if ($fecha_mes == 2){
                        if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                            $pago_cliente_table->fecha_pago = $fecha_pago_cliente->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                        }else{
                            $pago_cliente_table->fecha_pago = $fecha_pago_cliente->addMonth()->format('Y-m-d');
                        }
                    }else if ($fecha_dia == 31){
                        $fecha_pago_cliente = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                        $pago_cliente_table->fecha_pago = $fecha_pago_cliente->format('Y-m-d');
                    }else if($fecha_dia == 29 || $fecha_dia == 30){
                        $fecha_pago_cliente = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                        $pago_cliente_table->fecha_pago = $fecha_pago_cliente->format('Y-m-d');
                    }else{
                        $pago_cliente_table->fecha_pago = $fecha_pago_cliente->addMonth()->format('Y-m-d');
                    }

                    $pago_cliente_table->pago = round($redito, 2);
                    $pago_cliente_table->status = "Pendiente";
                    $pago_cliente_table->tipo_pago = "Pendiente";

                    $pago_cliente_table->save();
                }
            }


            $contrato->update();

            $contrato_id = $contrato->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Contrato";
            $log->id_tabla = $contrato_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();


            return response($contrato);
        }
    }

    public function deleteContrato(Request $request)
    {
        $contrato_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Contrato";
        $log->id_tabla = $contrato_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            if ($request->ajax()) {
                Contrato::destroy($request->id);
            }
        }
    }

    public function getBeneficiarios(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $beneficiarios = DB::table("beneficiario")
                ->where("contrato_id", "=", $id)
                ->get();

            $countBeneficiarios = DB::table("beneficiario")
                ->where("contrato_id", "=", $id)
                ->count();

            return response(["beneficiarios" => $beneficiarios, "countBeneficiarios" => $countBeneficiarios]);
        }
    }

    public function getClave(Request $request)
    {
        $clave = DB::table('users')->where("id", "=", auth()->user()->id)->first();
        $id_user = auth()->user()->id;

            if (\Hash::check($request->clave, $clave->password)) {
                if($request->status == "Activado"){
                    $contrato = Contrato::find($request->id);
                    $contrato->memo_status = "Contrato activado por id:$id_user";
                    $contrato->save();
                }elseif($request->status == "Pendiente de activación"){
                    $contrato = Contrato::find($request->id);
                    $contrato->memo_status = "Contrato desactivado por id:$id_user";
                    $contrato->save();
                }elseif($request->status == "Finiquitado"){
                    $contrato = Contrato::find($request->id);
                    $contrato->memo_status = "Contrato finiquitado por id:$id_user";
                    $contrato->save();
                }elseif($request->status == "Refrendado"){
                    $contrato = Contrato::find($request->id);
                    $contrato->memo_status = "Contrato refrendado por id:$id_user";
                    $contrato->save();
                }
                return response("success");
            }else{
                return response("error");
            }
    }

    public function getPendientes(Request $request)
    {
        $cliente = DB::table('cliente')
            ->select(DB::raw("nombre, apellido_p, apellido_m"))
            ->where("id", $request->id)
            ->get();

        $pendientes = DB::table('pendiente')
            ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
            ->select(DB::raw("pendiente.id, pendiente.memo_nombre AS nombre, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre"))
            ->where("memo_nombre", "like", "%" . $cliente[0]->nombre . "%")
            ->orWhere('memo_nombre', 'like', "%" . $cliente[0]->apellido_p . ' ' . $cliente[0]->apellido_m . "%")
            ->get();

        return response($pendientes);
    }

    public function getPendiente(Request $request)
    {
        $pendientes = DB::table('pendiente')
            ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
            ->select(DB::raw("pendiente.id, pendiente.memo_nombre AS nombre, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre"))
            ->where("pendiente.id", "=", $request->id)
            ->get();

        return response($pendientes);
    }

    public function getNumCliente(Request $request)
    {
        //obtener el numero del ciente
        $cliente = Contrato::select("contrato")->where("cliente_id", $request->id)->orderBy('contrato', 'desc')->first();
        if (!empty($cliente)) {
            $cliente = explode("-", $cliente->contrato);
            $numeroContratos = str_pad(intval($cliente[1]) + 1, 3, "0", STR_PAD_LEFT);
            $numeroContratos = "$cliente[0]-$numeroContratos-00";
        } else {
            $cliente = cliente::select("codigoCliente")->where("id", $request->id)->orderBy('codigoCliente', 'desc')->first();
            $cliente = explode("-", $cliente->codigoCliente);
            $numeroContratos = str_pad(intval($cliente[3]) + 1, 3, "0", STR_PAD_LEFT);
            $numeroContratos = "$cliente[2]-$numeroContratos-00";
        }

        return response($numeroContratos);
    }

    public function editStatus(Request $request)
    {
        $contrato = Contrato::find($request->id);

        $contrato->status = $request->status;

        $contrato->update();

        return response($contrato);
    }
}
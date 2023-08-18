<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Oficina;
use App\Models\PagoCliente;
use App\Models\TipoCambio;
use App\Models\Log;
use App\Models\Pago;
use App\Exports\PagosClienteExport;
use App\Exports\TiposPagos;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class ReportePagoClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_diamond){        
            return View('reportepagocliente.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getResumenPagoClienteMensual(Request $request)
    {
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, cliente.celular AS clientenumero, pago_cliente.id as pagoid, pago_cliente.pago, pago_cliente.serie as serie_pago, pago_cliente.fecha_pago as fecha, pago_cliente.status, contrato.tipo_id, contrato.inversion_us, contrato.fecha as fecha_contrato, cliente.tipo_pago, contrato.moneda, contrato.inversion_eur, contrato.inversion_chf"))
            ->whereBetween('pago_cliente.fecha_pago', [$request->fecha_inicio, $request->fecha_fin])
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where(function ($query) {
                $query->where("contrato.status", "Activado")
                ->orWhere("contrato.status", "Finiquitado");
            })
            ->where("contrato.tipo_id", 1)
            ->distinct("contrato.id")
            ->orderBy('contrato.id', 'DESC')
            ->get();

        $data = array(
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
            "resumenes_contrato" => $resumenContrato,
            "reporte" => "mensual",
            "efectivo" => 0,
            "transferencia" => 0,
            "transferenciaSwiss" => 0,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function getResumenPagoClienteDiaMensual(Request $request)
    {
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');
        
        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, cliente.celular AS clientenumero, pago_cliente.id as pagoid, pago_cliente.pago, pago_cliente.serie as serie_pago, pago_cliente.fecha_pago as fecha, pago_cliente.status, contrato.tipo_id, contrato.inversion_us, contrato.fecha as fecha_contrato, cliente.tipo_pago, contrato.moneda, contrato.inversion_eur, contrato.inversion_chf"))
            ->where('pago_cliente.fecha_pago', $request->fecha)
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where(function ($query) {
                $query->where("contrato.status", "Activado")
                ->orWhere("contrato.status", "Finiquitado");
            })
            ->where("contrato.tipo_id", 1)
            ->orderBy('contrato.id', 'DESC')
            ->distinct()
            ->get();

        $data = array(
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
            "resumenes_contrato" => $resumenContrato,
            "reporte" => "mensual",
            "efectivo" => 0,
            "transferencia" => 0,
            "transferenciaSwiss" => 0,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function getResumenPagoClienteCompuesto(Request $request)
    {
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, cliente.celular AS clientenumero, pago_cliente.id as pagoid, pago_cliente.pago, pago_cliente.serie as serie_pago, pago_cliente.fecha_pago as fecha, pago_cliente.status, contrato.tipo_id, contrato.inversion_us, contrato.fecha as fecha_contrato, cliente.tipo_pago, contrato.moneda, contrato.inversion_eur, contrato.inversion_chf"))
            ->whereBetween('pago_cliente.fecha_pago', [$request->fecha_inicio, $request->fecha_fin])
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where(function ($query) {
                $query->where("contrato.status", "Activado")
                ->orWhere("contrato.status", "Finiquitado");
            })
            ->where("contrato.tipo_id", 2)
            ->orderBy('contrato.id', 'DESC')
            ->distinct()
            ->get();

        $data = array(
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
            "resumenes_contrato" => $resumenContrato,
            "efectivo" => 0,
            "transferencia" => 0,
            "transferenciaSwiss" => 0,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function getResumenPagoClienteDiaCompuesto(Request $request)
    {
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');
        
        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, cliente.celular AS clientenumero, pago_cliente.id as pagoid, pago_cliente.pago, pago_cliente.serie as serie_pago, pago_cliente.fecha_pago as fecha, pago_cliente.status, contrato.tipo_id, contrato.inversion_us, contrato.fecha as fecha_contrato, cliente.tipo_pago, contrato.moneda, contrato.inversion_eur, contrato.inversion_chf"))
            ->where('pago_cliente.fecha_pago', $request->fecha)
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where("contrato.tipo_id", 2)
            ->where(function ($query) {
                $query->where("contrato.status", "Activado")
                ->orWhere("contrato.status", "Finiquitado");
            })
            ->orderBy('contrato.id', 'DESC')
            ->distinct()
            ->get();

        $data = array(
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
            "resumenes_contrato" => $resumenContrato,
            "efectivo" => 0,
            "transferencia" => 0,
            "transferenciaSwiss" => 0,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function getResumenPagoClienteLiquidacion(Request $request)
    {
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, cliente.celular AS clientenumero, pago_cliente.id as pagoid, pago_cliente.pago, pago_cliente.serie as serie_pago, pago_cliente.fecha_pago as fecha, pago_cliente.status, contrato.tipo_id, contrato.inversion_us, contrato.fecha as fecha_contrato, cliente.tipo_pago, contrato.moneda, contrato.inversion_eur, contrato.inversion_chf"))
            ->whereBetween('pago_cliente.fecha_pago', [$request->fecha_inicio, $request->fecha_fin])
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where(function ($query) {
                $query->where("contrato.status", "Activado")
                ->orWhere("contrato.status", "Finiquitado");
            })
            ->where("contrato.tipo_id", 1)
            ->where("pago_cliente.serie", 12)
            ->distinct("contrato.id")
            ->orderBy('contrato.id', 'DESC')
            ->get();

        $data = array(
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
            "resumenes_contrato" => $resumenContrato,
            "reporte" => "liquidacion",
            "efectivo" => 0,
            "transferencia" => 0,
            "transferenciaSwiss" => 0,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function getResumenPagoClienteDiaLiquidacion(Request $request)
    {
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');
        
        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, cliente.celular AS clientenumero, pago_cliente.id as pagoid, pago_cliente.pago, pago_cliente.serie as serie_pago, pago_cliente.fecha_pago as fecha, pago_cliente.status, contrato.tipo_id, contrato.inversion_us, contrato.fecha as fecha_contrato, cliente.tipo_pago, contrato.moneda, contrato.inversion_eur, contrato.inversion_chf"))
            ->where('pago_cliente.fecha_pago', $request->fecha)
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where("pago_cliente.serie", 12)
            ->where(function ($query) {
                $query->where("contrato.status", "Activado")
                ->orWhere("contrato.status", "Finiquitado");
            })
            ->orderBy('contrato.id', 'DESC')
            ->distinct()
            ->get();

        $data = array(
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
            "resumenes_contrato" => $resumenContrato,
            "reporte" => "liquidacion",
            "efectivo" => 0,
            "transferencia" => 0,
            "transferenciaSwiss" => 0,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function imprimirResumenCliente(Request $request)
    {
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('amortizacion', 'amortizacion.contrato_id', '=', 'contrato.id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, pago_cliente.pago, amortizacion.memo, amortizacion.serie as serie_pago, amortizacion.fecha, contrato.tipo_id, contrato.moneda, contrato.inversion_eur, contrato.inversion_chf"))
            ->whereBetween('amortizacion.fecha', [$request->fecha_inicio, $request->fecha_fin])
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where(function ($query) {
                $query->where("contrato.status", "Activado")
                ->orWhere("contrato.status", "Finiquitado");
            })
            ->where("contrato.moneda", "dolares")
            ->distinct("clientenombre")
            ->orderBy('contrato.id', 'DESC')
            ->get();

        $resumenContrato_eur = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('amortizacion', 'amortizacion.contrato_id', '=', 'contrato.id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, pago_cliente.pago, amortizacion.memo, amortizacion.serie as serie_pago, amortizacion.fecha, contrato.tipo_id, contrato.moneda, contrato.inversion_eur, contrato.inversion_chf"))
            ->whereBetween('amortizacion.fecha', [$request->fecha_inicio, $request->fecha_fin])
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where(function ($query) {
                $query->where("contrato.status", "Activado")
                ->orWhere("contrato.status", "Finiquitado");
            })
            ->where("contrato.moneda", "euros")
            ->distinct("clientenombre")
            ->orderBy('contrato.id', 'DESC')
            ->get();

        $resumenContrato_chf = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('amortizacion', 'amortizacion.contrato_id', '=', 'contrato.id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, pago_cliente.pago, amortizacion.memo, amortizacion.serie as serie_pago, amortizacion.fecha, contrato.tipo_id, contrato.moneda, contrato.inversion_eur, contrato.inversion_chf"))
            ->whereBetween('amortizacion.fecha', [$request->fecha_inicio, $request->fecha_fin])
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where(function ($query) {
                $query->where("contrato.status", "Activado")
                ->orWhere("contrato.status", "Finiquitado");
            })
            ->where("contrato.moneda", "francos")
            ->distinct("clientenombre")
            ->orderBy('contrato.id', 'DESC')
            ->get();

        $data = array(
            "resumenes_contrato" => $resumenContrato,
            "resumenes_contrato_eur" => $resumenContrato_eur,
            "resumenes_contrato_chf" => $resumenContrato_chf,
            "fecha_inicio" => $request->fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
        );

        $inicio = \Carbon\Carbon::parse($request->fecha_inicio)->formatLocalized('%d de %B de %Y');
        $fin = \Carbon\Carbon::parse($request->fecha_fin)->formatLocalized('%d de %B de %Y');

        $pdf = PDF::loadView('reportepagocliente.imprimir', $data);
        $nombreDescarga = "Resumen de pagos a clientes de $inicio hasta $fin.pdf";
        return $pdf->stream($nombreDescarga);
    }    

    public function getReportePago(Request $request)
    {
        $fecha = \Carbon\Carbon::parse($request->fecha)->formatLocalized('%d de %B de %Y');
        $rendimiento = number_format($request->rendimiento, 2);
        $total_dolares = number_format($request->rendimiento_dolar, 2);
        
        $data = array(
            "pago" => $request->pago,
            "cliente" => $request->cliente,
            "rendimiento" => $rendimiento,
            "contrato" => $request->contrato,
            "fecha" => $fecha,
            "letra" => $request->letra,
            "fecha_imprimir" => $request->fecha_imprimir,
            "tipo" => $request->tipo,
            "total_dolares" => $total_dolares,
            "letra_total" => $request->letra_dolares,
            "contratoid" => $request->contratoid,
            "dolares" => $request->dolar,
            "reporte" => $request->reporte,
            "moneda" => $request->moneda,
        );

        $pdf = PDF::loadView('reportepagocliente.reporte', $data);
        $nombreDescarga = "Reporte del pago de $request->cliente numero $request->pago con fecha de $fecha.pdf";
        return $pdf->stream($nombreDescarga);
    }

    public function export(Request $request)
    {
        $fecha_inicio = \Carbon\Carbon::parse($request->fecha_inicio)->formatLocalized('%d de %B de %Y');
        $fecha_fin = \Carbon\Carbon::parse($request->fecha_fin)->formatLocalized('%d de %B de %Y');

        return Excel::download(new PagosClienteExport($request->fecha_inicio, $request->fecha_fin, $request->dolar, $request->euro, $request->franco), "pagos a clientes del día $fecha_inicio a $fecha_fin.xlsx");
    }

    public function tiposPagosClientes(Request $request)
    {
        $psid = session('psid');
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        $resumenContrato = DB::table('contrato')
        ->join('ps', 'ps.id', '=', 'contrato.ps_id')
        ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
        ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
        ->join('amortizacion', 'amortizacion.contrato_id', '=', 'contrato.id')
        ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
        ->select(DB::raw("CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, cliente.tipo_pago"))
        ->whereBetween('amortizacion.fecha', [$request->fecha_inicio, $request->fecha_fin])
        ->where(function ($query) use ($psid, $clienteid) {
            $query->where("contrato.ps_id", "like", $psid)
            ->orWhere("contrato.cliente_id", "like", $clienteid);
        })
        ->where("oficina.codigo_oficina", "like", $codigo)
        ->where("contrato.status", "Activado")
        ->distinct("clientenombre")
        ->orderBy('contrato.id', 'DESC')
        ->get();

        $data = array(
            "resumenes_contrato" => $resumenContrato,
            "fecha_inicio" => $request->fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
        );

        $inicio = \Carbon\Carbon::parse($request->fecha_inicio)->formatLocalized('%d de %B de %Y');
        $fin = \Carbon\Carbon::parse($request->fecha_fin)->formatLocalized('%d de %B de %Y');

        $pdf = PDF::loadView('reportepagocliente.pagos', $data);
        $nombreDescarga = "Forma de pagos a clientes de $inicio hasta $fin.pdf";
        return $pdf->stream($nombreDescarga);
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

    public function editStatus(Request $request)
    {
        $pago_cliente = PagoCliente::find($request->id);

        if($request->status == "Pagado"){
            $pago_cliente->fecha_pagado = Carbon::now()->format('Y-m-d');

            $tipo_cambio = new TipoCambio;
            $tipo_cambio->valor = number_format($request->dolar, 2);
            $tipo_cambio->contrato_id = $request->contratoid;
            $tipo_cambio->memo = "Pago de rendimiento ($request->pago)";
            $tipo_cambio->save();

            $log = new Log;
            $log->tipo_accion = "Actualización";
            $log->tabla = "Pago de cliente";
            $log->id_tabla = $request->id;
            $log->bitacora_id = session('bitacora_id');
            $log->save();
        }else{
            $pago_cliente->fecha_pagado = NULL;
        }
        $pago_cliente->status = $request->status;
        $pago_cliente->update();

        return response($pago_cliente);
    }

    public function guardarPago(Request $request)
    {

        DB::table('pagos')->where("id_contrato", $request->contrato_id)->where('memo', $request->memo)->delete();

        $pago = new Pago;
        $pago->id_contrato = $request->contrato_id;
        $pago->memo = $request->memo;
        $pago->tipo_cambio = $request->dolar;
        if (gettype($request->tipo_pago) != 'NULL'){
            $tipos_pagos = "";
            foreach ($request->tipo_pago as $tipo_pago) {
                if($tipo_pago != ""){
                    $tipos_pagos .= $tipo_pago.',';
                }
            }
            $pago->tipo_pago = $tipos_pagos;
        }
        if(count($request->monto) > 0 ){
            $montos = "";
            foreach ($request->monto as $monto) {
                if($monto > 0){
                    $montos .= $monto.',';
                }
            }
            $pago->monto = $montos;
        }
        $pago->save();

        $pago_cliente = PagoCliente::find($request->id);
        $pago_cliente->fecha_pagado = Carbon::now()->format('Y-m-d');
        $pago_cliente->status = "Pagado";
        $pago_cliente->update();

        $tipo_cambio = new TipoCambio;
        $tipo_cambio->valor = number_format($request->dolar, 2);
        $tipo_cambio->contrato_id = $request->contrato_id;
        $tipo_cambio->memo = "Pago de rendimiento ($request->pago)";
        $tipo_cambio->save();

        $log = new Log;
        $log->tipo_accion = "Actualización";
        $log->tabla = "Pago de cliente";
        $log->id_tabla = $request->id;
        $log->bitacora_id = session('bitacora_id');
        $log->save();

        return response($pago);
    }
}

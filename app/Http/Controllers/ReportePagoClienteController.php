<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Oficina;
use App\Models\TipoCambio;
use App\Exports\PagosClienteExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportePagoClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos){        
            return View('reportepagocliente.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getResumenPagoCliente(Request $request)
    {
        $resumenContrato = DB::table('contrato')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('amortizacion', 'amortizacion.contrato_id', '=', 'contrato.id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, pago_cliente.pago, amortizacion.memo, amortizacion.serie as serie_pago, amortizacion.fecha, contrato.tipo_id"))
            ->whereBetween('amortizacion.fecha', [$request->fecha_inicio, $request->fecha_fin])
            ->distinct("clientenombre")
            ->orderBy('contrato.id', 'DESC')
            ->get();

        $data = array(
            "dolar" => $request->dolar,
            "resumenes_contrato" => $resumenContrato,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function imprimirResumenCliente(Request $request)
    {
        $resumenContrato = DB::table('contrato')
        ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
        ->join('amortizacion', 'amortizacion.contrato_id', '=', 'contrato.id')
        ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
        ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, pago_cliente.pago, amortizacion.memo, amortizacion.serie as serie_pago, amortizacion.fecha, contrato.tipo_id"))
        ->whereBetween('amortizacion.fecha', [$request->fecha_inicio, $request->fecha_fin])
        ->distinct("clientenombre")
        ->orderBy('contrato.id', 'DESC')
        ->get();

        $data = array(
            "resumenes_contrato" => $resumenContrato,
            "fecha_inicio" => $request->fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
            "dolar" => $request->dolar,
        );

        $inicio = \Carbon\Carbon::parse($request->fecha_inicio)->formatLocalized('%d de %B de %Y');
        $fin = \Carbon\Carbon::parse($request->fecha_fin)->formatLocalized('%d de %B de %Y');

        $pdf = PDF::loadView('reportepagocliente.imprimir', $data);
        $nombreDescarga = "Resumen de pagos a clientes de $inicio hasta $fin.pdf";
        return $pdf->stream($nombreDescarga);
    }

    public function getResumenPagoClienteDia(Request $request)
    {
        $resumenContrato = DB::table('contrato')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('amortizacion', 'amortizacion.contrato_id', '=', 'contrato.id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, pago_cliente.pago, amortizacion.memo, amortizacion.serie as serie_pago, amortizacion.fecha, contrato.tipo_id"))
            ->where('amortizacion.fecha', $request->fecha)
            ->distinct("clientenombre")
            ->orderBy('contrato.id', 'DESC')
            ->get();

        $data = array(
            "dolar" => $request->dolar,
            "resumenes_contrato" => $resumenContrato,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function getReportePago(Request $request)
    {
        $fecha = \Carbon\Carbon::parse($request->fecha)->formatLocalized('%d de %B de %Y');
        $rendimiento = number_format($request->rendimiento, 2);
        
        $data = array(
            "pago" => $request->pago,
            "cliente" => $request->cliente,
            "rendimiento" => $rendimiento,
            "contrato" => $request->contrato,
            "fecha" => $fecha,
            "letra" => $request->letra,
        );

        $tipo_cambio = new TipoCambio;
        $tipo_cambio->valor = $request->dolar;
        $tipo_cambio->contrato_id = $request->contratoid;
        $tipo_cambio->memo = "Pago de rendimiento mensual ($request->pago)";
        $tipo_cambio->save();

        $pdf = PDF::loadView('reportepagocliente.reporte', $data);
        $nombreDescarga = "Reporte del pago de $request->cliente numero $request->pago con fecha de $fecha";
        return $pdf->stream($nombreDescarga);
    }

    public function export(Request $request)
    {
        $fecha_inicio = \Carbon\Carbon::parse($request->fecha_inicio)->formatLocalized('%d de %B de %Y');
        $fecha_fin = \Carbon\Carbon::parse($request->fecha_fin)->formatLocalized('%d de %B de %Y');

        return Excel::download(new PagosClienteExport($request->fecha_inicio, $request->fecha_fin, $request->dolar), "pagos a clientes del día $fecha_inicio a $fecha_fin.xlsx");
    }

}
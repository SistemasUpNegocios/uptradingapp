<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Oficina;
use App\Exports\PagosClienteExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportePagoClienteController extends Controller
{
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
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, pago_cliente.pago, pago_cliente.memo, pago_cliente.serie"))
            ->whereBetween('pago_cliente.fecha_pago', [$request->fecha_inicio, $request->fecha_fin])
            ->orderBy('contrato.id', 'DESC')
            ->get();

        $data = array(
            "resumenes_contrato" => $resumenContrato,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function imprimirResumenCliente(Request $request)
    {
        $resumenContrato = DB::table('contrato')
        ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
        ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
        ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, pago_cliente.pago, pago_cliente.memo, pago_cliente.serie"))
        ->whereBetween('pago_cliente.fecha_pago', [$request->fecha_inicio, $request->fecha_fin])
        ->orderBy('contrato.id', 'DESC')
        ->get();

        $data = array(
            "resumenes_contrato" => $resumenContrato,
            "fecha_inicio" => $request->fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
        );

        $inicio = Carbon::parse($request->fecha_inicio)->formatLocalized('%d de %B de %Y');
        $fin = Carbon::parse($request->fecha_fin)->formatLocalized('%d de %B de %Y');

        $pdf = PDF::loadView('reportepagocliente.imprimir', $data);
        $nombreDescarga = "Resumen de pagos a clientes de $inicio hasta $fin.pdf";
        return $pdf->stream($nombreDescarga);
    }

    public function getResumenPagoClienteDia(Request $request)
    {
        $resumenContrato = DB::table('contrato')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, pago_cliente.pago, pago_cliente.memo, pago_cliente.serie"))
            ->where('pago_cliente.fecha_pago', $request->fecha)
            ->orderBy('contrato.id', 'DESC')
            ->get();

        $data = array(
            "resumenes_contrato" => $resumenContrato,
        );

        return response()->view('reportepagocliente.tabla', $data, 200);
    }

    public function export(Request $request){
        return Excel::download(new PagosClienteExport($request->fecha_inicio, $request->fecha_fin), 'pagos a clientes.xlsx');
    }

}
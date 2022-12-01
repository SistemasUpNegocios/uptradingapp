<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Oficina;
use Carbon\Carbon;

class ReportePagoClienteOficinaController extends Controller
{
    public function index()
    {
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos){                   
            return response()->view('reportepagoclienteoficina.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getResumenClienteOficina(Request $request)
    {

        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('oficina', 'oficina.id', '=', 'ps.oficina_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("oficina.id, oficina.ciudad, oficina.codigo_oficina"))
            ->whereBetween('pago_cliente.fecha_pago', [$request->fecha_inicio, $request->fecha_fin])
            ->distinct('oficina.ciudad')
            ->get();

        $data = array(
            "lista_oficinas" => $resumenContrato,
        );

        return response()->view('reportepagoclienteoficina.oficinas', $data, 200);
    }

    public function imprimirResumenClienteOficina(Request $request)
    {
        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, pago_cliente.pago, pago_cliente.memo, pago_cliente.serie"))
            ->whereBetween('pago_cliente.fecha_pago', [$request->fecha_inicio, $request->fecha_fin])
            ->where('ps.oficina_id', $request->oficina)
            ->get();

        $oficina = DB::table('oficina')->where('id', $request->oficina)->first();

        $data = array(
            "resumenes_contrato" => $resumenContrato,
            "fecha_inicio" => $request->fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
            "oficina" => $oficina->ciudad
        );

        $inicio = Carbon::parse($request->fecha_inicio)->formatLocalized('%d de %B de %Y');
        $fin = Carbon::parse($request->fecha_fin)->formatLocalized('%d de %B de %Y');

        $pdf = PDF::loadView('reportepagoclienteoficina.imprimir', $data);
        $nombreDescarga = "Resumen de pagos por oficina de $inicio hasta $fin.pdf";
        return $pdf->stream($nombreDescarga);
    }
}
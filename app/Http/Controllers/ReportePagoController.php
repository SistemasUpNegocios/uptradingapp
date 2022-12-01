<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportePagoController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function ReporteMesPagoPSView()
    {
        $primer_fecha = DB::table("pago_ps")
        ->select("fecha_pago")
        ->orderBy("fecha_pago","asc")
        ->get();

        $ultima_fecha = DB::table("pago_ps")
        ->select("fecha_pago")
        ->orderBy("fecha_pago","desc")
        ->get();

        $primer_fecha = $primer_fecha[0]->fecha_pago;
        $ultima_fecha = $ultima_fecha[0]->fecha_pago;

        $data = array(
            "primer_fecha" => $primer_fecha,
            "ultima_fecha" => $ultima_fecha,
        );

        return response()->view('reportepago.showps', $data, 200);
    }

    public function ReporteFiltroPagoPSView()
    {
        return response()->view('reportepago.showpsfiltro');
    }

    public function pdfReporteMesPagoPS(Request $request)
    {
        if ($request->isMethod('get')) {
            $fecha = $request->fecha;

            $data = [
                'fecha' => $fecha,
            ];

            $pdf = PDF::loadView('reportepago.pdfps', $data);

            $nombreDescarga = "Reporte mensual pagos PS.pdf";
            return $pdf->stream($nombreDescarga);
        }
    }

    public function pdfReporteFiltroPagoPS(Request $request)
    {
        if ($request->isMethod('get')) {
            $fechadesde = $request->fechadesde;
            $fechahasta = $request->fechahasta;

            $data = [
                'fechadesde' => $fechadesde,
                'fechahasta' => $fechahasta
            ];

            $pdf = PDF::loadView('reportepago.pdfpsfiltro', $data);

            $nombreDescarga = "Reporte pagos a PS.pdf";
            return $pdf->stream($nombreDescarga);
        }
    }
}
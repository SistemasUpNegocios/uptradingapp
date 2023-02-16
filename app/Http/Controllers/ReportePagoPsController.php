<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Oficina;
use App\Models\Ps;
use App\Models\TipoCambio;
use App\Exports\PagosPsExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportePagoPsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_diamond){        
            return View('reportepagops.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getResumenPagoPs(Request $request)
    {

        $psid = session('psid');    
        $ps = Ps::all();

        $data = array(
            "fecha" => $request->fecha,
            "lista_ps" => $ps,
            "dolar" => $request->dolar,
        );

        return response()->view('reportepagops.tabla', $data, 200);
    }

    public function getReportePagoPs(Request $request)
    {
        $comision = number_format($request->comision, 2);
        $comision_dolares = number_format($request->comision_dolares, 2);

        // Pesos mexicanos
        $centavos = strval($comision);
        $resultCentavos = explode(".", $centavos);
        if (next($resultCentavos)) {
            if (strlen($resultCentavos[1]) == 1) {
                $centavos_num = substr($resultCentavos[1], 0, 2) . "0".'/100 M.N.';
            } else {
                $centavos_num = substr($resultCentavos[1], 0, 2).'/100 M.N.';
            }
        } else {
            $centavos_num = "00/100 M.N";
        }

        $posCON = strrpos($request->letra, "con");
        if($posCON === false){
            $letra = 'son '.$request->letra;
        }else{
            $letra = 'son '.substr_replace($request->letra, "", $posCON);
        }

        // dólares
        $centavos_dolares = strval($comision_dolares);
        $resultCentavos_dolares = explode(".", $centavos_dolares);
        if (next($resultCentavos_dolares)) {
            if (strlen($resultCentavos_dolares[1]) == 1) {
                $centavos_num_dolares = substr($resultCentavos_dolares[1], 0, 2) . "0".'/100 M.N.';
            } else {
                $centavos_num_dolares = substr($resultCentavos_dolares[1], 0, 2).'/100 M.N.';
            }
        } else {
            $centavos_num_dolares = "00/100 M.N";
        }
        $posCON_dolares = strrpos($request->letra_dolares, "con");
        if($posCON_dolares === false){
            $letra_dolares = 'son '.$request->letra_dolares;
        }else{
            $letra_dolares = 'son '.substr_replace($request->letra_dolares, "", $posCON_dolares);
        }
        
        $data = array(
            "ps" => $request->ps,
            "comision" => $comision,
            "comision_dolares" => $comision_dolares,
            "letra" => $letra,
            "letra_dolares" => $letra_dolares,
            "centavos_dolares" => $centavos_num_dolares,
            "centavos" => $centavos_num,
            "fecha_imprimir" => $request->fecha_imprimir,
        );        

        $pdf = PDF::loadView('reportepagops.reporte', $data);
        $fecha_descarga = \Carbon\Carbon::parse($request->fecha_mes)->formatLocalized('%B');
        $nombreDescarga = "Reporte del pago de comisión del PS $request->ps del mes de $fecha_descarga.pdf";
        return $pdf->stream($nombreDescarga);
    }

    public function exportPs(Request $request)
    {
        $fecha = \Carbon\Carbon::parse($request->fecha)->formatLocalized('%B');
        return Excel::download(new PagosPsExport($request->fecha, $request->dolar), "pagos de comisiones del mes de $fecha.xlsx");
    }

}
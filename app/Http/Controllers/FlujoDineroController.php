<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ps;
use Illuminate\Support\Facades\DB;
use App\Models\Contrato;
use App\Models\Cliente;
use App\Models\Log;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class FlujoDineroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_root){            
            return response()->view('flujodinero.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getFlujoDinero(Request $request)
    {

        $flujodinero = Contrato::join('cliente', 'cliente.id', '=', 'contrato.cliente_id')        
            ->join('ps', 'ps.id', 'contrato.ps_id')
            ->select(DB::raw("contrato.contrato, contrato.fecha, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, contrato.tipo_pago, contrato.monto_pago"))
            ->where('contrato.tipo_pago', "!=", NULL)
            ->where('fecha', "like", "$request->fecha%")
            ->orderBy("contrato.fecha", "DESC")
            ->get();
            
        return datatables()->of($flujodinero)->addColumn('btn', 'flujodinero.buttons')->rawColumns(['btn'])->toJson();
    }

    public function getTotalMes(Request $request)
    {
        $flujodinero = Contrato::select(DB::raw("contrato, tipo_pago, monto_pago"))
        ->where('tipo_pago', "!=", NULL)
        ->where('fecha', "like", "$request->fecha%")
        ->orderBy("fecha", "DESC")
        ->get();

        $total_swiss_pool = 0;
        $total_rendimientos = 0;
        $total_renovacion = 0;
        $total_comisiones = 0;
        $total_mx_pool = 0;
        $total_efectivo = 0;
        $total_ci_bank = 0;
        $total_HSBC = 0;
        $total_final = 0;

        foreach ($flujodinero as $flujo) {
            $tipo_pago = explode(",", $flujo->tipo_pago);
            $monto_pago = explode(",", $flujo->monto_pago);

            for ($i=0; $i < sizeof($tipo_pago); $i++) { 
                if ($tipo_pago[$i] == "transferencia_swiss_pool") {
                    $total_swiss_pool += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "rendimientos") {
                    $total_rendimientos += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "renovacion") {
                    $total_renovacion += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "comisiones") {
                    $total_comisiones += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "transferencia_mx_pool") {
                    $total_mx_pool += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "efectivo") {
                    $total_efectivo += floatval($monto_pago[$i]);//x
                }elseif ($tipo_pago[$i] == "ci_bank") {
                    $total_ci_bank += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "HSBC") {
                    $total_HSBC += floatval($monto_pago[$i]);
                }
            }
        }

        $total_final = $total_swiss_pool + $total_rendimientos + $total_renovacion + $total_comisiones + $total_mx_pool + $total_efectivo + $total_ci_bank + $total_HSBC;

        $data = array(
            "total_swiss_pool" => number_format($total_swiss_pool, 2),
            "total_rendimientos" => number_format($total_rendimientos, 2),
            "total_renovacion" => number_format($total_renovacion, 2),
            "total_comisiones" => number_format($total_comisiones, 2),
            "total_mx_pool" => number_format($total_mx_pool, 2),
            "total_efectivo" => number_format($total_efectivo, 2),
            "total_ci_bank" => number_format($total_ci_bank, 2),
            "total_HSBC" => number_format($total_HSBC, 2),
            "total_final" => number_format($total_final, 2)
        );

        return response()->view('flujodinero.total', $data, 200);
    }

    public function imprimirReporte(Request $request)
    {
        $flujodinero = Contrato::join('cliente', 'cliente.id', '=', 'contrato.cliente_id')        
            ->join('ps', 'ps.id', 'contrato.ps_id')
            ->select(DB::raw("contrato.contrato, contrato.fecha, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, contrato.tipo_pago, contrato.monto_pago"))
            ->where('contrato.tipo_pago', "!=", NULL)
            ->where('contrato.fecha', "like", "$request->fecha%")
            ->orderBy("contrato.fecha", "DESC")
            ->get();

        $total_swiss_pool = 0;
        $total_rendimientos = 0;
        $total_renovacion = 0;
        $total_comisiones = 0;
        $total_mx_pool = 0;
        $total_efectivo = 0;
        $total_ci_bank = 0;
        $total_HSBC = 0;
        $total_final = 0;

        foreach ($flujodinero as $flujo) {
            $tipo_pago = explode(",", $flujo->tipo_pago);
            $monto_pago = explode(",", $flujo->monto_pago);

            for ($i=0; $i < sizeof($tipo_pago); $i++) { 
                if ($tipo_pago[$i] == "transferencia_swiss_pool") {
                    $total_swiss_pool += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "rendimientos") {
                    $total_rendimientos += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "renovacion") {
                    $total_renovacion += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "comisiones") {
                    $total_comisiones += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "transferencia_mx_pool") {
                    $total_mx_pool += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "efectivo") {
                    $total_efectivo += floatval($monto_pago[$i]);//x
                }elseif ($tipo_pago[$i] == "ci_bank") {
                    $total_ci_bank += floatval($monto_pago[$i]);
                }elseif ($tipo_pago[$i] == "HSBC") {
                    $total_HSBC += floatval($monto_pago[$i]);
                }
            }
        }

        $total_final = $total_swiss_pool + $total_rendimientos + $total_renovacion + $total_comisiones + $total_mx_pool + $total_efectivo + $total_ci_bank + $total_HSBC;

        $data = array(
            "flujodinero" => $flujodinero,
            "fecha" => $request->fecha,
            "total_swiss_pool" => number_format($total_swiss_pool, 2),
            "total_rendimientos" => number_format($total_rendimientos, 2),
            "total_renovacion" => number_format($total_renovacion, 2),
            "total_comisiones" => number_format($total_comisiones, 2),
            "total_mx_pool" => number_format($total_mx_pool, 2),
            "total_efectivo" => number_format($total_efectivo, 2),
            "total_ci_bank" => number_format($total_ci_bank, 2),
            "total_HSBC" => number_format($total_HSBC, 2),
            "total_final" => number_format($total_final, 2)
        );
        
        $pdf = PDF::loadView('flujodinero.imprimir', $data)->setPaper('letter', 'landscape');

        if (strlen($request->fecha) > 0) {
            $mes = Carbon::parse("$request->fecha-01")->formatLocalized('%B');
            $nombreDescarga = "Reporte de flujo de dinero del mes de $mes.pdf";
        }else{
            $nombreDescarga = "Reporte de flujo de dinero total.pdf";
        }
        return $pdf->stream($nombreDescarga);
    }
}
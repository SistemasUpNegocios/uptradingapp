<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class imprimirController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index(Request $request)
    {
        $contratos = DB::table('contrato')
        ->select(DB::raw("id, contrato"))
        ->where('id', '=', $request->id)
        ->first();

        return view('imprimir.show', compact('contratos'));

    }

    public function imprimir(Request $request)
    {
        $contratos = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
            ->join('modelo_contrato', 'modelo_contrato.id', '=', 'tipo_contrato.modelo_id')
            ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id, contrato.folio, contrato.operador, contrato.operador_ine, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.fecha_renovacion, contrato.fecha_pago, contrato.contrato, ps.id AS psid, contrato.porcentaje, contrato.inversion_us, contrato.inversion_letra_us, contrato.inversion, contrato.inversion_letra, contrato.memo_status, cliente.id AS clienteid,  CONCAT(cliente.nombre,' ',cliente.apellido_p,' ',cliente.apellido_m) AS clientenombre, CONCAT(cliente.nombre,' ',cliente.apellido_p,' ',cliente.apellido_m) AS clientenombrePDF, CONCAT(cliente.direccion, ' ', cliente.colonia) AS clientedomicilio, cliente.cp AS codigopostal, cliente.ine AS clienteine, cliente.pasaporte AS clientepasaporte, cliente.celular AS clientecelular, cliente.correo_personal AS clientecorreo, tipo_contrato.id AS tipoid, tipo_contrato.tipo AS tipocontrato, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, tipo_contrato.rendimiento, contrato.porcentaje, modelo_contrato.id AS modeloid, contrato.inversion, contrato.tipo_cambio, tipo_contrato.tabla, contrato.status, pago_ps.fecha_pago AS fecha_pago_ps, pago_ps.pago AS pago_ps, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, contrato.fecha_carga, contrato.moneda, contrato.inversion_eur, contrato.inversion_letra_eur, contrato.inversion_chf, contrato.inversion_letra_chf, contrato.firma_electronica"))
            ->where('contrato.id', '=', $request->id)
            ->get();

        $pagos_ps = DB::table('pago_ps')
            ->join('contrato', 'contrato.id', '=', 'pago_ps.contrato_id')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
            ->select(DB::raw("contrato.id, contrato.inversion_us, tipo_contrato.rendimiento, pago_ps.fecha_pago AS fecha_pago_ps, pago_ps.pago AS pago_ps"))
            ->where('pago_ps.contrato_id', '=', $request->id)
            ->get();

        $beneficiarios = DB::table('beneficiario')
            ->join('contrato', 'contrato.id', '=', 'beneficiario.contrato_id')
            ->select(DB::raw("beneficiario.id, beneficiario.contrato_id, beneficiario.nombre, beneficiario.porcentaje, beneficiario.telefono, beneficiario.correo_electronico"))
            ->where('beneficiario.contrato_id', '=', $request->id)
            ->get();

        $clausulas = DB::table('clausula')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'clausula.tipo_id')
            ->join('contrato', 'contrato.tipo_id', '=', 'clausula.tipo_id')
            ->select(DB::raw("clausula.id, clausula.redaccion, clausula.tipo_id AS tipo_id"))
            ->where('contrato.id', '=', $request->id)
            ->get();

        $amortizaciones = DB::table('amortizacion')
            ->join('contrato', 'contrato.id', '=', 'amortizacion.contrato_id')
            ->select(DB::raw("amortizacion.serie, amortizacion.fecha, amortizacion.monto, amortizacion.redito, amortizacion.saldo_con_redito"))
            ->where('amortizacion.contrato_id', '=', $request->id)
            ->get();

        if(!empty($contratos[0]->fecha_carga)){
            $holograma_fecha = strtotime($contratos[0]->fecha_carga);            
            $holograma = $holograma_fecha."U".$contratos[0]->inversion_us;            
        }else{
            $holograma = "";
        }

        if(!empty($contratos[0]->fecha_carga)){
            if(!empty($contratos[0]->memo_status)){
                $memo = explode(":", $contratos[0]->memo_status);

                if (isset($memo[1])) {
                    $holograma2 = $holograma_fecha."U".$contratos[0]->inversion_us."P".$memo[1];
                }else{
                    $holograma2 = "";
                }

            }else{
                $holograma2 = "";
            }
        }else{
            $holograma2 = "";
        }

        $pdf = PDF::loadView('imprimir.showanverso', ['contratos' => $contratos, 'pagos_ps' => $pagos_ps, 'beneficiarios' => $beneficiarios, 'clausulas' => $clausulas, 'amortizaciones' => $amortizaciones, "holograma" => $holograma, "holograma2" => $holograma2]);

        $fecha_hoy = Carbon::now();
        $nombreDescarga = $contratos[0]->contrato.'_'.$contratos[0]->clientenombrePDF.'_'.$fecha_hoy->format('d-m-Y').'.pdf';
        
        $visualizacion = $pdf->stream($nombreDescarga);
        Storage::disk('contratos')->put($nombreDescarga, $visualizacion);

        return $visualizacion;
    }
}

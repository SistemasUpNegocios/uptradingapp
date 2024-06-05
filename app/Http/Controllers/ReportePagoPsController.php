<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\Oficina;
use App\Models\Ps;
use App\Models\Pago;
use App\Models\PagoPS;
use App\Models\PagoPSConvenio;
use App\Models\Log;
use App\Exports\PagosPsExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

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
        $ps = Ps::orderBy("id", "DESC")->get();

        $data = array(
            "fecha" => $request->fecha,
            "lista_ps" => $ps,
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
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
                $centavos_num_dolares = substr($resultCentavos_dolares[1], 0, 2) . "0".'/100';
            } else {
                $centavos_num_dolares = substr($resultCentavos_dolares[1], 0, 2).'/100';
            }
        } else {
            $centavos_num_dolares = "00/100";
        }
        $posCON_dolares = strrpos($request->letra_dolares, "con");
        if($posCON_dolares === false){
            $letra_dolares = 'son '.$request->letra_dolares;
        }else{
            $letra_dolares = 'son '.substr_replace($request->letra_dolares, "", $posCON_dolares);
        }

        $mes_pago = Carbon::parse($request->fecha_mes)->formatLocalized('%B');
        
        $data = array(
            "ps" => $request->ps,
            "comision" => $comision,
            "comision_dolares" => $comision_dolares,
            "letra" => $letra,
            "letra_dolares" => $letra_dolares,
            "centavos_dolares" => $centavos_num_dolares,
            "centavos" => $centavos_num,
            "fecha_imprimir" => $request->fecha_imprimir,
            "dolar" => $request->dolar,
            "euro" => $request->euro,
            "franco" => $request->franco,
            "mes" => $mes_pago,
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

        $id_arr = explode(',', $request->id);

        foreach ($id_arr as $id) {
            $pago_ps = PagoPS::find($id);

            if(strlen($pago_ps) > 0){
                if($request->status == "Pagado"){
                    $fecha = Carbon::now()->format('Y-m');
                    $pago_ps->fecha_pagado = $fecha."-10";

                    $serie = str_pad($pago_ps->serie, 2, "0", STR_PAD_LEFT);

                    $pago = new Pago;
                    $pago->id_contrato = $pago_ps->contrato_id;
                    $pago->memo = "Pago a PS ($serie/12)";
                    $pago->monto = $pago_ps->pago;
                    $pago->tipo_pago = "efectivo,";
                    $pago->tipo_cambio = $request->dolar;
                    $pago->save();

                    $log = new Log;
                    $log->tipo_accion = "Actualización";
                    $log->tabla = "Pago de PS por el contrato $pago_ps->contrato_id";
                    $log->id_tabla = $id;
                    $log->bitacora_id = session('bitacora_id');
                    $log->save();
                }else{
                    $pago_ps->fecha_pagado = NULL;
                }
    
                $pago_ps->status = $request->status;
                $pago_ps->update();
            }
        }

        return response('success');
    }

    public function guardarPago(Request $request)
    {
        $id_arr = explode(',', $request->id);
        $id_convenio_arr = explode(',', $request->id_convenio);

        $numero_pago_arr = explode(',', $request->numero_pago);
        $numero_pago_convenio_arr = explode(',', $request->numero_pago_convenio);

        if(count($id_arr) > 0){
            for ($i=0; $i < count($id_arr); $i++) { 
                $pago_ps = PagoPS::find($id_arr[$i]);

                if(strlen($pago_ps) > 0){
                    $fecha = Carbon::now()->format('Y-m');
                    $pago_ps->fecha_pagado = $fecha."-10";
                    $pago_ps->status = "Pagado";

                    $tipo_pago_if = $request->tipo_pago[0];
                    if ($tipo_pago_if == "transferencia") {
                        $tipo_pago_if = "Transferencia MX";
                    }elseif($tipo_pago_if == "transferenciaSwiss") {
                        $tipo_pago_if = "Transferencia Swissquote";
                    }elseif($tipo_pago_if == "efectivo") {
                        $tipo_pago_if = "Efectivo";
                    }else{
                        $tipo_pago_if = "Pendiente";
                    }
                    $pago_ps->tipo_pago = $tipo_pago_if;
                    $pago_ps->update();

                    // DB::table('pagos')->where("id_contrato", $id_arr[$i])->where('memo', "Pago de comisión ($numero_pago_arr[$i])")->delete();

                    $pago = new Pago;
                    $pago->id_contrato = $pago_ps->contrato_id;
                    $pago->memo = "Pago de comisión ($numero_pago_arr[$i])";
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

                    $log = new Log;
                    $log->tipo_accion = "Actualización";
                    $log->tabla = "Pago de PS";
                    $log->id_tabla = $id_arr[$i];
                    $log->bitacora_id = session('bitacora_id');
                    $log->save();
                }
            }
        }

        if(count($id_convenio_arr) > 0){
            for ($i=0; $i < count($id_convenio_arr); $i++) { 
                $pago_convenio_ps = PagoPSConvenio::find($id_convenio_arr[$i]);

                if(strlen($pago_convenio_ps) > 0){
                    $fecha = Carbon::now()->format('Y-m');
                    $pago_convenio_ps->fecha_pagado = $fecha."-10";
                    $pago_convenio_ps->status = "Pagado";
                    $pago_convenio_ps->update();

                    // DB::table('pagos')->where('memo', "Pago de comisión ($numero_pago_convenio_arr[$i])")->delete();

                    $pago = new Pago;
                    $pago->id_contrato = $pago_convenio_ps->convenio_id;
                    $pago->memo = "Pago de comisión ($numero_pago_convenio_arr[$i]) CONVENIO";
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

                    $log = new Log;
                    $log->tipo_accion = "Actualización";
                    $log->tabla = "Pago de PS";
                    $log->id_tabla = $id_convenio_arr[$i];
                    $log->bitacora_id = session('bitacora_id');
                    $log->save();
                }
            }
        }


        return response('success');
    }

}

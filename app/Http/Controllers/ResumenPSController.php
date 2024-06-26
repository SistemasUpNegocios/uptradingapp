<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Models\Oficina;
use App\Models\Ps;
use Carbon\Carbon;

class ResumenPSController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_diamond){
            return response()->view('resumenps.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getOficinas()
    {
        $codigo = session('codigo_oficina');
        
        $oficinas = Oficina::select()->where("codigo_oficina", "like", $codigo)->get();

        $data = array(
            "lista_oficinas" => $oficinas,
        );

        return response()->view('resumenps.oficinas', $data, 200);
    }

    public function getListaPS(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            $ps = DB::table("ps")
                ->where("oficina_id", "=", $id)
                ->get();

            $data = array(
                "lista_ps" => $ps,
            );
            if (!$ps->isEmpty()) {
                return response()->view('resumenps.listaps', $data, 200);
            } else {
                return response()->view('resumenps.listaps', ['status' => 'NoPS'], 200);
            }
        }
    }

    public function getForaneos()
    {
        $ps = DB::table("ps")->where("oficina_id", "!=", 1)->get();
        $data = array(
            "lista_ps" => $ps,
        );
        if (!$ps->isEmpty()) {
            return response()->view('resumenps.listaps', $data, 200);
        } else {
            return response()->view('resumenps.listaps', ['status' => 'NoPS'], 200);
        }
    }

    public function getResumen(Request $request)
    {
        $fecha = $request->fecha;
        $fecha = explode("-", $fecha);
        $anio = $fecha[0];
        $mes = $fecha[1];
        $pago_total = 0;

        $ps = Ps::find($request->id);

        $date1 = Carbon::now()->subMonth();
        $date2 = Carbon::parse("$anio-$mes-10");

        if($date2->lte($date1)){
            $resumenContrato = DB::table('contrato')
                ->join('ps', 'ps.id', '=', 'contrato.ps_id')
                ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
                ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
                ->select(DB::raw("contrato.id as contratoid, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.correo_institucional as correocliente, pago_ps.pago, pago_ps.memo, pago_ps.serie"))
                ->where("contrato.ps_id", "=", $request->id)
                ->where("pago_ps.fecha_limite", 'like', "$anio-$mes%")
                ->where("contrato.status", "!=", "Nuevo contrato")
                ->orderBy('contrato.id', 'DESC')
                ->get();

            foreach ($resumenContrato as $pago) {
                $pago_total += $pago->pago;
            }

            if ($mes < 4) {
                $resumenConvenio = DB::table('convenio')
                    ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                    ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                    ->join('pago_ps_convenio', 'pago_ps_convenio.convenio_id', '=', 'convenio.id')
                    ->select(DB::raw("convenio.id as convenioid, convenio.folio, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.correo_institucional as correocliente, pago_ps_convenio.pago, pago_ps_convenio.memo, pago_ps_convenio.serie"))
                    ->where("convenio.ps_id", "=", $request->id)
                    ->where("pago_ps_convenio.fecha_limite", 'like', "$anio-$mes%")
                    ->where("convenio.status", "!=", "Nuevo convenio")
                    ->orderBy('convenio.id', 'DESC')
                    ->get();
    
                foreach ($resumenConvenio as $pago) {
                    $pago_total += $pago->pago;
                }
            }else{
                $resumenConvenio = array();
            }
        }else{
            $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.correo_institucional as correocliente, pago_ps.pago, pago_ps.memo, pago_ps.serie"))
            ->where("contrato.ps_id", "=", $request->id)
            ->where("pago_ps.fecha_limite", 'like', "$anio-$mes%")
            ->where("contrato.status", "Activado")
            ->orderBy('contrato.id', 'DESC')
            ->get();

            foreach ($resumenContrato as $pago) {
                $pago_total += $pago->pago;
            }

            if ($mes < 4) {
                $resumenConvenio = DB::table('convenio')
                    ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                    ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                    ->join('pago_ps_convenio', 'pago_ps_convenio.convenio_id', '=', 'convenio.id')
                    ->select(DB::raw("convenio.id as convenioid, convenio.folio, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.correo_institucional as correocliente, pago_ps_convenio.pago, pago_ps_convenio.memo, pago_ps_convenio.serie"))
                    ->where("convenio.ps_id", "=", $request->id)
                    ->where("pago_ps_convenio.fecha_limite", 'like', "$anio-$mes%")
                    ->where("convenio.status", "Activado")
                    ->orderBy('convenio.id', 'DESC')
                    ->get();

                foreach ($resumenConvenio as $pago) {
                    $pago_total += $pago->pago;
                }
            }else{
                $resumenConvenio = array();
            }
        }
        
        $data = array(
            "resumenes_contrato" => $resumenContrato,
            "resumenes_convenio" => $resumenConvenio,
            "total" => number_format($pago_total, 2),
            "fecha" => $anio.'-'.$mes,
            "ps" => $ps,
            "dolar" => $request->dolar
        );
    
        return response()->view('resumenps.resumen', $data, 200);
    }

    public function imprimirResumen(Request $request)
    {

        $mes_num = explode("-", $request->fecha);
        $mes_num = $mes_num[1];
        
        $pago_total = 0;

        $ps = Ps::find($request->id);

        $date1 = Carbon::now()->subMonth();
        $date2 = Carbon::parse("$request->fecha-10");

        if($date2->lte($date1)){
            $resumenContrato_pasado = DB::table('contrato')
                ->join('ps', 'ps.id', '=', 'contrato.ps_id')
                ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
                ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
                ->select(DB::raw("contrato.id as contratoid, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.correo_institucional as correocliente, pago_ps.pago, pago_ps.memo, pago_ps.serie"))
                ->where("contrato.ps_id", "=", $request->id)
                ->where("pago_ps.fecha_limite", 'like', "$request->fecha%")
                ->where("contrato.status", "Finiquitado")
                ->orderBy('contrato.id', 'DESC')
                ->get();

            foreach ($resumenContrato_pasado as $pago) {
                $pago_total += $pago->pago;
            }

            if ($mes_num < 4) {
                $resumenConvenio_pasado = DB::table('convenio')
                    ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                    ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                    ->join('pago_ps_convenio', 'pago_ps_convenio.convenio_id', '=', 'convenio.id')
                    ->select(DB::raw("convenio.id as convenioid, convenio.folio, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.correo_institucional as correocliente, pago_ps_convenio.pago, pago_ps_convenio.memo, pago_ps_convenio.serie"))
                    ->where("convenio.ps_id", "=", $request->id)
                    ->where("pago_ps_convenio.fecha_limite", 'like', "$request->fecha%")
                    ->where("convenio.status", "Finiquitado")
                    ->orderBy('convenio.id', 'DESC')
                    ->get();

                foreach ($resumenConvenio_pasado as $pago) {
                    $pago_total += $pago->pago;
                }
            }
        }
        
        $resumenContrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('pago_ps', 'pago_ps.contrato_id', '=', 'contrato.id')
            ->select(DB::raw("contrato.id as contratoid, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.correo_institucional as correocliente, pago_ps.pago, pago_ps.memo, pago_ps.serie"))
            ->where("contrato.ps_id", "=", $request->id)
            ->where("pago_ps.fecha_limite", 'like', "$request->fecha%")
            ->where("contrato.status", "Activado")
            ->orderBy('contrato.id', 'DESC')
            ->get();
        
        foreach ($resumenContrato as $pago) {
            $pago_total += $pago->pago;
        }

        if ($mes_num < 4) {
            $resumenConvenio = DB::table('convenio')
                ->join('ps', 'ps.id', '=', 'convenio.ps_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('pago_ps_convenio', 'pago_ps_convenio.convenio_id', '=', 'convenio.id')
                ->select(DB::raw("convenio.id as convenioid, convenio.folio, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.correo_institucional as correocliente, pago_ps_convenio.pago, pago_ps_convenio.memo, pago_ps_convenio.serie"))
                ->where("convenio.ps_id", "=", $request->id)
                ->where("pago_ps_convenio.fecha_limite", 'like', "$request->fecha%")
                ->where("convenio.status", "Activado")
                ->orderBy('convenio.id', 'DESC')
                ->get();

            foreach ($resumenConvenio as $pago) {
                $pago_total += $pago->pago;
            }
        }else{
            $resumenConvenio = array();
        }

        $data = array(
            "resumenes_contrato" => $resumenContrato,
            "resumenes_convenio" => $resumenConvenio,
            "total" => number_format($pago_total, 2),
            "fecha" => $request->fecha,
            "ps" => $ps
        );
        
        $mes = Carbon::parse("$request->fecha-10")->formatLocalized('%B');
        
        $pdf = PDF::loadView('resumenps.imprimir', $data);
        $nombreDescarga = "Pago a PS $ps->nombre $ps->apellido_p $ps->apellido_m del mes de $mes.pdf";
        return $pdf->stream($nombreDescarga);
    }

    public function imprimirResumenOficina(Request $request)
    {
        $mes_num = explode("-", $request->fecha);
        $mes_num = $mes_num[1];

        if(!empty($request->id)){
            $ps = Ps::where('oficina_id', $request->id)->get();
            $oficina = Oficina::find($request->id);

            $data = array(
                "lista_ps" => $ps,
                "oficina"  => $oficina->ciudad,
                "fecha"    => $request->fecha,
                "dolar"    => $request->dolar,
                "mes_num"  => $mes_num,
                "total"    => 0
            );
        }else{
            $ps = Ps::where('oficina_id', "!=", 1)->get();
            $oficina = Oficina::where('id', "!=", 1)->get();
            
            $data = array(
                "lista_ps" => $ps,
                "oficina"  => "Foranea",
                "fecha"    => $request->fecha,
                "dolar"    => $request->dolar,
                "mes_num"  => $mes_num,
                "total"    => 0
            );
        }
        
        $mes = Carbon::parse("$request->fecha-10")->formatLocalized('%B');

        $pdf = PDF::loadView('resumenps.imprimir_oficina', $data);
        if(!empty($request->id)){
            $nombreDescarga = "Pagos a PS de la oficina de $oficina->ciudad del mes de $mes.pdf";
        }else{
            $nombreDescarga = "Pagos a PS foraneos del mes de $mes.pdf";
        }
        return $pdf->stream($nombreDescarga);
    }
}

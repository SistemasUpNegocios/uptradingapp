<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Convenio;
use App\Models\IncrementoConvenio;
use App\Models\Oficina;
use App\Models\Formulario;
use App\Models\Amortizacion;
use App\Models\Ps;
use App\Models\PSMovil;
use App\Models\PagoPS;
use App\Models\Agenda;
use App\Models\PagoPSConvenio;
use App\Models\PagoCliente;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin');
    }
    
    public function index()
    {

        $clienteid = session("clienteid");
        $psid = session("psid");
        $codigo = session("codigo_oficina");

        if (auth()->user()->is_ps_gold || auth()->user()->is_ps_bronze) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
            $psid = $ps_cons->id;
        }

        if(auth()->user()->is_ps_diamond){
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
            $psid = $ps_cons->id;
            
            $codigo = Oficina::select()->where("id", $ps_cons->oficina_id)->first()->codigo_oficina;
        }
        $clientesCountBronze = Cliente::where("codigoCliente", "like", "MXN-$codigo%")->count();

        $ps = Ps::where('codigoPS', 'like', "$codigo%")->count();
        $clientesCount = Cliente::where("codigoCliente", "like", "MXN-$codigo%")->count();

        $cliente_con = Cliente::select()->where("correo_institucional", auth()->user()->correo)->first();
        if (strlen($cliente_con) > 0) {
            $clienteid = $cliente_con->id;

            $contratos_compuestos = Contrato::join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })        
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where('status', 'Activado')
            ->where('tipo_id', 2)
            ->count();

            $contratos_mensuales = Contrato::join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })        
            ->where("oficina.codigo_oficina", "like", $codigo)        
            ->where('status', 'Activado')
            ->where('tipo_id', 1)
            ->count();

            $contratos = Contrato::join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("contrato.ps_id", "like", $psid)
                ->orWhere("contrato.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where('status', 'Activado')
            ->count();
            
            $convenios = Convenio::join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("convenio.ps_id", "like", $psid)
                ->orWhere("convenio.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where('status', 'Activado')
            ->count();

            $convenio_incremento = IncrementoConvenio::join("convenio", "convenio.id", "=", "incremento_convenio.convenio_id")
            ->join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where(function ($query) use ($psid, $clienteid) {
                $query->where("convenio.ps_id", "like", $psid)
                ->orWhere("convenio.cliente_id", "like", $clienteid);
            })
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where('incremento_convenio.status', 'Activado')
            ->count();
            
        }else{
            $contratos_compuestos = Contrato::join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where("contrato.ps_id", "like", $psid)
            ->where("contrato.cliente_id", "like", $clienteid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where('status', 'Activado')
            ->where('tipo_id', 2)
            ->count();

            $contratos_mensuales = Contrato::join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where("contrato.ps_id", "like", $psid)
            ->where("contrato.cliente_id", "like", $clienteid)
            ->where("oficina.codigo_oficina", "like", $codigo)        
            ->where('status', 'Activado')
            ->where('tipo_id', 1)
            ->count();

            $contratos = Contrato::join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where("contrato.ps_id", "like", $psid)
            ->where("contrato.cliente_id", "like", $clienteid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where('status', 'Activado')
            ->count();
            
            $convenios = Convenio::join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where("convenio.ps_id", "like", $psid)
            ->where("convenio.cliente_id", "like", $clienteid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where('status', 'Activado')
            ->count();

            $convenio_incremento = IncrementoConvenio::join("convenio", "convenio.id", "=", "incremento_convenio.convenio_id")
            ->join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where("convenio.ps_id", "like", $psid)
            ->where("convenio.cliente_id", "like", $clienteid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where('incremento_convenio.status', 'Activado')
            ->count();
        }
        
        $fecha = Carbon::now()->format('Y-m-d');

        if(auth()->user()->is_admin || auth()->user()->is_procesos){
            $agenda = Agenda::join('users', 'users.id', 'agenda.asignado_a')
                ->whereDate('agenda.start', 'like', $fecha.'%')
                ->orderBy('agenda.start', 'ASC')
                ->get();
        }else{
            $agenda = Agenda::join('users', 'users.id', 'agenda.asignado_a')
                ->where('agenda.asignado_a', auth()->user()->id)
                ->whereDate('agenda.start', 'like', $fecha.'%')
                ->orderBy('agenda.start', 'ASC')
                ->get();
        }

        $data = array(
            "ps" => $ps,
            "clientesCount" => $clientesCount,
            "contratos_compuestos" => $contratos_compuestos,
            "contratos_mensuales" => $contratos_mensuales,

            "contratos" => $contratos,
            "convenios" => $convenios,
            
            "agenda" => $agenda,

            "clientesCountBronze" => $clientesCountBronze,
            "convenio_incremento" => $convenio_incremento,
        );

        return response()->view('dashboard.show', $data, 200);
    }

    public function getAlerta(Request $request)
    {
        $contrato = Contrato::where("fecha_renovacion", $request->fecha)->get();

        return response($contrato);
    }

    public function getContConvCount()
    {

        $inicio = Carbon::parse("2022-01-01");
        $fin = Carbon::parse("2023-12-31");

        for ($i = $inicio; $i <= $fin; $i->addMonth()) {
            $fecha = Carbon::parse($i)->format("Y-m-d");
            $fecha = explode("-", $fecha);
            $convenios = Convenio::where("fecha_inicio", "like", "$fecha[0]-$fecha[1]-%")->count();
            $contratosCount = Contrato::where("fecha", "like", "$fecha[0]-$fecha[1]-%")->count();

            $cont[] = array(
                "total" => $contratosCount,
            );

            $conv[] = array(
                "total" => $convenios,
            );
        }

        return response(compact("cont", "conv"));

    }

    public function getContMensCompCount()
    {
        $inicio = Carbon::parse("2022-01-01");
        $fin = Carbon::parse("2023-12-31");

        for ($i = $inicio; $i <= $fin; $i->addMonth()) {
            $fecha = Carbon::parse($i)->format("Y-m-d");
            $fecha = explode("-", $fecha);
            $contratosMens = Contrato::where("fecha", "like", "$fecha[0]-$fecha[1]-%")->where("tipo_id", 1)->count();
            $contratosComp = Contrato::where("fecha", "like", "$fecha[0]-$fecha[1]-%")->where("tipo_id", 2)->count();

            $mens[] = array(
                "total" => $contratosMens,
            );

            $comp[] = array(
                "total" => $contratosComp,
            );
        }

        return response(compact("mens", "comp"));
    }

    public function getFormClientCount()
    {
        $clientes = Cliente::count();
        $formulario = Formulario::count();

        return response(compact("clientes", "formulario"));
    }

    public function getPsPmCount()
    {
        $ps = Ps::count();
        $ps_movil = PSMovil::count();

        return response(compact("ps", "ps_movil"));
    }
}
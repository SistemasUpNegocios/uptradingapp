<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Convenio;
use App\Models\Amortizacion;
use App\Models\Ps;
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

        $ps = Ps::count();
        $clientesCount = Cliente::count();
        $clientes = Cliente::orderBy('apellido_p')->get();

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

        $pagospsContratos = PagoPS::join("contrato", "contrato.id", "=", "pago_ps.contrato_id")
        ->join('ps', 'ps.id', '=', 'contrato.ps_id')
        ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
        ->join('oficina', "oficina.id", "=", "ps.oficina_id")
        ->where("contrato.ps_id", "like", $psid)
        ->where("contrato.cliente_id", "like", $clienteid)
        ->where("oficina.codigo_oficina", "like", $codigo)
        ->count();
        $pagospsConvenios = PagoPSConvenio::join("convenio", "convenio.id", "=", "pago_ps_convenio.convenio_id")
        ->join('ps', 'ps.id', '=', 'convenio.ps_id')
        ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
        ->join('oficina', "oficina.id", "=", "ps.oficina_id")
        ->where("convenio.ps_id", "like", $psid)
        ->where("convenio.cliente_id", "like", $clienteid)
        ->where("oficina.codigo_oficina", "like", $codigo)
        ->count();
        $pagosCliente = PagoCliente::join("contrato", "contrato.id", "=", "pago_cliente.contrato_id")
        ->join('ps', 'ps.id', '=', 'contrato.ps_id')
        ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
        ->join('oficina', "oficina.id", "=", "ps.oficina_id")
        ->where("contrato.ps_id", "like", $psid)
        ->where("contrato.cliente_id", "like", $clienteid)
        ->where("oficina.codigo_oficina", "like", $codigo)
        ->count();

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
            "clientes" => $clientes,
            "contratos_compuestos" => $contratos_compuestos,
            "contratos_mensuales" => $contratos_mensuales,

            "contratos" => $contratos,
            "convenios" => $convenios,
            
            "pagospsContratos" => $pagospsContratos,
            "pagospsConvenios" => $pagospsConvenios,
            "pagosCliente" => $pagosCliente,

            "agenda" => $agenda
        );

        return response()->view('dashboard.show', $data, 200);
    }

}
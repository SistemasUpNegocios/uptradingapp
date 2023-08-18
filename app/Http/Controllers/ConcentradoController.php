<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Convenio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;

class ConcentradoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            $lista_clientes = Cliente::select()->orderBy("apellido_p", "ASC")->get();
            return view('concentrado.show', compact("lista_clientes"));
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getConcentrado(Request $request)
    {
        $cliente = Cliente::where("id", $request->id)->first();
        $contratos = Contrato::where("cliente_id", $request->id)->count();
        $contrato_mensual = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->count();
        $contrato_compuesto = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->count();
        $convenios = Convenio::where("cliente_id", $request->id)->count();

        $contratos_inv_mens = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->sum('inversion');
        $contratos_inv_comp = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->sum('inversion');

        $contratos_inv_dol_mens = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->where("moneda", "dolares")->sum('inversion_us');
        $contratos_inv_dol_comp = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->where("moneda", "dolares")->sum('inversion_us');

        $contratos_inv_eur_mens = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->where("moneda", "euros")->sum('inversion_eur');
        $contratos_inv_eur_comp = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->where("moneda", "euros")->sum('inversion_eur');

        $contratos_inv_chf_mens = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->where("moneda", "francos")->sum('inversion_chf');
        $contratos_inv_chf_comp = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->where("moneda", "francos")->sum('inversion_chf');

        $convenios_monto_dol = Convenio::where("cliente_id", $request->id)->sum('monto');
        $convenios_monto = $convenios_monto_dol * $request->dolar;

        $total_euros = $contratos_inv_eur_mens + $contratos_inv_eur_comp;
        $total_francos = $contratos_inv_chf_mens + $contratos_inv_chf_comp;
        $total_dolares = $contratos_inv_dol_mens + $contratos_inv_dol_comp + $convenios_monto_dol;
        $total_pesos = $contratos_inv_mens + $contratos_inv_comp + ($convenios_monto_dol * $request->dolar);

        $anio = Carbon::now()->format('Y');
        $mes = Carbon::now()->format('m');
        
        $contratos_men_tot = Contrato::join("pago_cliente", "pago_cliente.contrato_id", "contrato.id")
            ->select("contrato.contrato", "pago_cliente.serie", "contrato.tipo_id", "contrato.inversion", "contrato.inversion_us", "contrato.inversion_eur", "contrato.inversion_chf", "contrato.moneda")
            ->where("contrato.cliente_id", $request->id)
            ->where("contrato.tipo_id", 1)
            ->where("pago_cliente.fecha_pago", "like", "$anio-$mes%")
            ->orderBy("tipo_id", "ASC")
            ->distinct("contrato.contrato")
            ->get();

        $contratos_comp_tot = Contrato::join("pago_cliente", "pago_cliente.contrato_id", "contrato.id")
            ->select("contrato.contrato", "pago_cliente.fecha_pago", "contrato.tipo_id", "contrato.inversion", "contrato.inversion_us", "contrato.inversion_eur", "contrato.inversion_chf", "contrato.moneda")
            ->where("contrato.cliente_id", $request->id)
            ->where("contrato.tipo_id", 2)
            ->orderBy("tipo_id", "ASC")
            ->distinct("contrato.contrato")
            ->get();

        $convenio_tot = Convenio::select("folio", "monto")->where("cliente_id", $request->id)->get();

        $dolar = $request->dolar;

        return view('concentrado.datos', compact("cliente", "contratos", "contrato_mensual", "contrato_compuesto", "contratos_inv_mens", "contratos_inv_dol_mens", "contratos_inv_comp", "contratos_inv_dol_comp", "contratos_inv_eur_mens", "contratos_inv_eur_comp", "contratos_inv_chf_mens", "contratos_inv_chf_comp", "contratos_men_tot", "contratos_comp_tot", "convenio_tot", "convenios", "convenios_monto_dol", "total_dolares", "total_pesos", "total_euros", "total_francos", "convenios_monto", "dolar"));
    }

    public function reporteConcentrado(Request $request)
    {
        $cliente = Cliente::where("id", $request->id)->first();
        $contratos = Contrato::where("cliente_id", $request->id)->count();
        $contrato_mensual = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->count();
        $contrato_compuesto = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->count();
        $convenios = Convenio::where("cliente_id", $request->id)->count();

        $contratos_inv_mens = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->sum('inversion');
        $contratos_inv_comp = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->sum('inversion');

        $contratos_inv_dol_mens = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->where("moneda", "dolares")->sum('inversion_us');
        $contratos_inv_dol_comp = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->where("moneda", "dolares")->sum('inversion_us');

        $contratos_inv_eur_mens = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->where("moneda", "euros")->sum('inversion_eur');
        $contratos_inv_eur_comp = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->where("moneda", "euros")->sum('inversion_eur');

        $contratos_inv_chf_mens = Contrato::where("cliente_id", $request->id)->where("tipo_id", 1)->where("moneda", "francos")->sum('inversion_chf');
        $contratos_inv_chf_comp = Contrato::where("cliente_id", $request->id)->where("tipo_id", 2)->where("moneda", "francos")->sum('inversion_chf');

        $convenios_monto_dol = Convenio::where("cliente_id", $request->id)->sum('monto');
        $convenios_monto = $convenios_monto_dol * $request->dolar;

        $total_euros = $contratos_inv_eur_mens + $contratos_inv_eur_comp;
        $total_francos = $contratos_inv_chf_mens + $contratos_inv_chf_comp;
        $total_dolares = $contratos_inv_dol_mens + $contratos_inv_dol_comp + $convenios_monto_dol;
        $total_pesos = $contratos_inv_mens + $contratos_inv_comp + ($convenios_monto_dol * $request->dolar);

        $anio = Carbon::now()->format('Y');
        $mes = Carbon::now()->format('m');
        
        $contratos_men_tot = Contrato::join("pago_cliente", "pago_cliente.contrato_id", "contrato.id")
            ->select("contrato.contrato", "pago_cliente.serie", "contrato.tipo_id", "contrato.inversion", "contrato.inversion_us", "contrato.inversion_eur", "contrato.inversion_chf", "contrato.moneda")
            ->where("contrato.cliente_id", $request->id)
            ->where("contrato.tipo_id", 1)            
            ->where("pago_cliente.fecha_pago", "like", "$anio-$mes%")
            ->orderBy("tipo_id", "ASC")
            ->distinct("contrato.contrato")
            ->get();

        $contratos_comp_tot = Contrato::join("pago_cliente", "pago_cliente.contrato_id", "contrato.id")
            ->select("contrato.contrato", "pago_cliente.fecha_pago", "contrato.tipo_id", "contrato.inversion", "contrato.inversion_us", "contrato.inversion_eur", "contrato.inversion_chf", "contrato.moneda")
            ->where("contrato.cliente_id", $request->id)
            ->where("contrato.tipo_id", 2)
            ->orderBy("tipo_id", "ASC")
            ->distinct("contrato.contrato")
            ->get();

        $convenio_tot = Convenio::select("folio", "monto")->where("cliente_id", $request->id)->get();

        $dolar = $request->dolar;

        $pdf = PDF::loadView('concentrado.reporte', compact("cliente", "contratos", "contrato_mensual", "contrato_compuesto", "contratos_inv_mens", "contratos_inv_dol_mens", "contratos_inv_comp", "contratos_inv_dol_comp", "contratos_inv_eur_mens", "contratos_inv_eur_comp", "contratos_inv_chf_mens", "contratos_inv_chf_comp", "contratos_men_tot", "contratos_comp_tot", "convenio_tot", "convenios", "convenios_monto_dol", "total_dolares", "total_pesos", "total_euros", "total_francos", "convenios_monto", "dolar"));
        $nombreDescarga = "Concentrado del cliente $cliente->nombre $cliente->apellido_p $cliente->apellido_m.pdf";
        return $pdf->stream($nombreDescarga);
    }

}

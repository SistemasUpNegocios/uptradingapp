<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ps;
use App\Models\TipoContrato;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContratoVencerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos){
            $codigo = session('codigo_oficina');
            $numeroCliente = "MXN-" . $codigo . "-";

            $ps = Ps::select()->where("codigoPS", "like", "$codigo%")->get();
            $clientes = Cliente::select()->orderBy("apellido_p")->where("codigoCliente", "like", "$numeroCliente%")->get();
            $tipos = TipoContrato::all();
            $pendientes = DB::table('pendiente')
                ->select()
                ->join('ps', 'ps.id', '=', 'pendiente.ps_id')
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->where('oficina.codigo_oficina', 'like', $codigo)
                ->get();

            $data = array(
                "lista_ps" => $ps,
                "lista_clientes" => $clientes,
                "lista_tipos" => $tipos,
                "lista_pendientes" => $pendientes,
            );

            return response()->view('contratosvencer.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getContratoVencer ()
    {
        $contrato = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("contrato.id, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.operador_ine, contrato.fecha_renovacion, contrato.fecha_pago, contrato.fecha_limite, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.celular, tipo_contrato.id AS tipoid, tipo_contrato.tipo, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, tipo_contrato.rendimiento, contrato.porcentaje, contrato.folio, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.fecha_reintegro, contrato.status_reintegro, contrato.memo_reintegro, contrato.status, contrato.pendiente_id AS pendienteid, contrato.tipo_pago, contrato.monto_pago, contrato.comprobante_pago"))
            ->where("contrato.status", "Activado")
            ->where("fecha_renovacion", "<=", Carbon::now()->addDays(15)->format('Y-m-d'))
            ->where("fecha_renovacion", ">=", Carbon::now()->format('Y-m-d'))
            ->orderBy("fecha_renovacion", "ASC")
            ->get();
       

        return datatables()->of($contrato)->addColumn('btn', 'contratosvencer.buttons')->rawColumns(['btn'])->toJson();
    }
}
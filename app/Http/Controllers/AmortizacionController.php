<?php

namespace App\Http\Controllers;

use App\Models\Amortizacion;
use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Modelo;
use App\Models\Ps;
use App\Models\TipoContrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

class AmortizacionController extends Controller
{
    public function __construct()
    {        
        $this->middleware('auth.admin');
    }

    public function index()
    {
        $contratos = Contrato::all();
        $ps = Ps::all();
        $clientes = Cliente::all();
        $tipos = TipoContrato::all();
        $modelos = Modelo::all();
        $data = array(
            "lista_contratos" => $contratos,
            "lista_ps" => $ps,
            "lista_clientes" => $clientes,
            "lista_tipos" => $tipos,
            "lista_modelos" => $modelos
        );
        return response()->view('amortizacion.show', $data, 200);
    }

    public function getContratos()
    {
        $clienteid = session('clienteid');
        $codigo = session('codigo_oficina');

        $contratos = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("contrato.id AS contratoid, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.fecha_renovacion, contrato.fecha_pago, contrato.contrato, ps.id AS psid, cliente.id AS clienteid,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS cliente_nombre, tipo_contrato.id AS tipoid, tipo_contrato.tipo AS tipoContrato, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, contrato.porcentaje, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.status"))
            ->where("contrato.cliente_id", "like", $clienteid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->where("cliente.codigoCliente", "like", "MXN-$codigo")
            ->get();

        return datatables()->of($contratos)->addColumn('enlace', 'amortizacion.enlace')->rawColumns(['enlace'])->toJson();
    }

    public function ifExists(Request $request)
    {
        if ($request->contratoid) {
            $id = $request->contratoid;

            $amortizaciones = DB::table("amortizacion")
                ->join('contrato', 'contrato.id', '=', 'amortizacion.contrato_id')
                ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
                ->where("contrato_id", "=", $id)
                ->get();

            if ($amortizaciones) {
                return "Success";
            }
        }
    }

    public function getAmortizaciones(Request $request)
    {
        if ($request->contratoid) {
            $id = $request->contratoid;

            $amortizaciones = DB::table('amortizacion')
                ->join('contrato', 'contrato.id', '=', 'amortizacion.contrato_id')
                ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
                ->select(DB::raw("contrato.contrato AS contrato, amortizacion.id, amortizacion.contrato_id AS contratoid, amortizacion.serie, amortizacion.fecha, amortizacion.monto, amortizacion.redito, amortizacion.saldo_con_redito AS saldoredito, amortizacion.memo, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS cliente_nombre"))
                ->where("contrato_id", "=", $id)
                ->get();

                if ($amortizaciones) {
                    return datatables()->of($amortizaciones)->addColumn('btn', 'amortizacion.buttons')->rawColumns(['btn'])->toJson();
                }
        }
    }

    public function pdfAmortizacion(Request $request)
    {

        $amortizaciones = DB::table('amortizacion')
            ->join('contrato', 'contrato.id', '=', 'amortizacion.contrato_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->select(DB::raw("contrato.contrato AS contrato, amortizacion.id, amortizacion.contrato_id AS contratoid, amortizacion.serie, amortizacion.fecha, amortizacion.monto, amortizacion.redito, amortizacion.saldo_con_redito AS saldoredito, amortizacion.memo, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS cliente_nombre"))
            ->where("amortizacion.id", "=", $request->id)->first();

        $pdf = PDF::loadView('amortizacion.pdf', ['amortizaciones' => $amortizaciones]);

        $nombreDescarga = "Pago al cliente.pdf";
        return $pdf->stream($nombreDescarga);

        //comision por apertura & comision mensual
    }
}

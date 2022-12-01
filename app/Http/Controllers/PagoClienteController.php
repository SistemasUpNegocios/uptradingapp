<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Modelo;
use App\Models\PagoCliente;
use App\Models\Ps;
use App\Models\TipoContrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagoClienteController extends Controller
{
    public function __construct(){
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
        return response()->view('pagocliente.show', $data, 200);
    }

    public function getCliente()
    {
        $cliente = DB::table('cliente')            
            ->select(DB::raw("codigoCliente, id AS clienteid, CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) AS clientenombre"))
            ->get();

        return datatables()->of($cliente)->addColumn('enlace', 'pagocliente.enlace')->rawColumns(['enlace'])->toJson();
    }

    public function getContratos(Request $request)
    {
        $clienteid = $request->clienteid;
        $codigo = session('codigo_oficina');

        $contratos = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
            ->join('modelo_contrato', 'modelo_contrato.id', '=', 'tipo_contrato.modelo_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("contrato.id AS contratoid, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.fecha_renovacion, contrato.fecha_pago, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, tipo_contrato.id AS tipoid, tipo_contrato.tipo AS tipoContrato, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, contrato.porcentaje, modelo_contrato.id AS modeloid, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.fecha_reintegro, contrato.status_reintegro, contrato.memo_reintegro, contrato.status"))
            ->where("cliente.id", "=", $clienteid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->get();

        return datatables()->of($contratos)->addColumn('buttons', 'pagocliente.buttons')->rawColumns(['buttons'])->toJson();
    }

    public function ifExists(Request $request)
    {        
        if ($request->contratoid) {
            $id = $request->contratoid;

            $pagocliente = DB::table("pago_cliente")
            ->join('contrato', "contrato.id", "=", "pago_cliente.contrato_id")
            ->join('cliente', "cliente.id", "=", "contrato.cliente_id")
            ->where("contrato_id", "=", $id)
            ->get();

            if ($pagocliente) {
                return "Success";
            }
        }
    }

    public function getPagosCliente(Request $request)
    {
        $id = $request->contratoid;

        $pagoscliente = DB::table('pago_cliente')
            ->join('contrato', 'contrato.id', '=', 'pago_cliente.contrato_id')
            ->join('ps', "ps.id", "=", "contrato.ps_id")
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->select(DB::raw("contrato.contrato AS contrato, pago_cliente.id, pago_cliente.contrato_id AS contratoid, pago_cliente.serie, pago_cliente.fecha_pago, pago_cliente.fecha_pagado, pago_cliente.pago, pago_cliente.status, pago_cliente.memo, pago_cliente.tipo_pago, pago_cliente.comprobante, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre"))
            ->where("contrato_id", "=", $id)
            ->get();

            if ($pagoscliente) {
                return datatables()->of($pagoscliente)->addColumn('acciones', 'pagocliente.acciones')->rawColumns(['acciones'])->toJson();
            }
    }

    public function editPagoCliente(Request $request)
    {

        if ($request->ajax()) {

            $pagocliente = PagoCliente::find($request->id);

            $pagocliente->fecha_pagado = $request->fecha_pagado;
            $pagocliente->pago = $request->pago;
            $pagocliente->status = $request->status;
            $pagocliente->tipo_pago = $request->tipo_pago;

            if ($request->hasFile('foto')) {
                // $pagocliente = PagoCliente::where('id', $request->id)->get();

                // $imagen = $pagocliente[0]->comprobante;

                // if (is_file(public_path('img/comprobantes/pagocliente') . $imagen)) {
                //     chmod(public_path('img/comprobantes/pagocliente') . $imagen, 0777);
                //     unlink(public_path('img/comprobantes/pagocliente') . $imagen);
                // }

                $file = $request->file('foto');
                $filename = $file->getClientOriginalName();
                $ext = explode('.', $filename);
                $ext = end($ext);
                $filename = time().'_pagocliente.' . $ext;

                $file->move(public_path('img/comprobantes/pagocliente'), $filename);
                $pagocliente->comprobante = $filename;
            }

            $pagocliente->update();

            return response($pagocliente);
        }
    }
}
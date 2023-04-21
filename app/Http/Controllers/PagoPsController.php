<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Modelo;
use App\Models\PagoPS;
use App\Models\Ps;
use App\Models\TipoContrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagoPsController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold){
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
            return response()->view('pagops.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getPS()
    {

        $psid = session('psid');
        $codigo = session('codigo_oficina');

        if (auth()->user()->is_ps_gold) {
            $ps_cons = Ps::select()->where("correo_institucional", auth()->user()->correo)->first();
            $psid = $ps_cons->id;
        }

        $ps = DB::table('ps')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("ps.codigoPs, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre"))
            ->where("ps.id", "like", $psid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->get();

        return datatables()->of($ps)->addColumn('enlace', 'pagops.enlace')->rawColumns(['enlace'])->toJson();
    }

    public function getContratos(Request $request)
    {
        $psid = $request->psid;
        $codigo = session('codigo_oficina');        

        $contratos = DB::table('contrato')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
            ->join('modelo_contrato', 'modelo_contrato.id', '=', 'tipo_contrato.modelo_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("contrato.id AS contratoid, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha, contrato.fecha_renovacion, contrato.fecha_pago, contrato.contrato, ps.id AS psid, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS clienteid,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS cliente_nombre, tipo_contrato.id AS tipoid, tipo_contrato.tipo AS tipoContrato, tipo_contrato.capertura AS capertura, tipo_contrato.cmensual AS cmensual, contrato.porcentaje, modelo_contrato.id AS modeloid, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.inversion_letra_us, contrato.fecha_reintegro, contrato.status_reintegro, contrato.memo_reintegro, contrato.status"))
            ->where("ps.id", "=", $psid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->get();

        return datatables()->of($contratos)->addColumn('buttons', 'pagops.buttons')->rawColumns(['buttons'])->toJson();
    }

    public function ifExists(Request $request)
    {        
        if ($request->contratoid) {
            $id = $request->contratoid;

            $pagosps = DB::table("pago_ps")
            ->join('contrato', "contrato.id", "=", "pago_ps.contrato_id")
            ->join('ps', "ps.id", "=", "contrato.ps_id")
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->where("contrato_id", "=", $id)
            ->get();

            if ($pagosps) {
                return "Success";
            }
        }
    }

    public function getPagosPS(Request $request)
    {
        $id = $request->contratoid;

        $pagosps = DB::table('pago_ps')
            ->join('contrato', 'contrato.id', '=', 'pago_ps.contrato_id')
            ->join('ps', "ps.id", "=", "contrato.ps_id")
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->select(DB::raw("contrato.contrato AS contrato, pago_ps.id, pago_ps.contrato_id AS contratoid, pago_ps.serie, pago_ps.fecha_pago, pago_ps.fecha_limite, pago_ps.fecha_pagado, pago_ps.pago, pago_ps.status, pago_ps.memo, pago_ps.tipo_pago, pago_ps.comprobante, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS cliente_nombre, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre"))
            ->where("contrato_id", "=", $id)
            ->get();

            if ($pagosps) {
                return datatables()->of($pagosps)->addColumn('acciones', 'pagops.acciones')->rawColumns(['acciones'])->toJson();
            }
    }

    public function editPagoPS(Request $request)
    {

        if ($request->ajax()) {

            $pagops = PagoPS::find($request->id);

            $pagops->fecha_pagado = $request->fecha_pagado;
            $pagops->pago = $request->pago;
            $pagops->status = $request->status;
            $pagops->tipo_pago = $request->tipo_pago;

            if ($request->hasFile('foto')) {
                // $pagops = PagoPS::where('id', $request->id)->get();

                // $imagen = $pagops[0]->comprobante;

                // if (is_file(public_path('img/comprobantes/pagops') . $imagen)) {
                //     chmod(public_path('img/comprobantes/pagops') . $imagen, 0777);
                //     unlink(public_path('img/comprobantes/pagops') . $imagen);
                // }

                $file = $request->file('foto');
                $filename = $file->getClientOriginalName();
                $ext = explode('.', $filename);
                $ext = end($ext);
                $filename = time().'_pagops.' . $ext;

                $file->move(public_path('img/comprobantes/pagops'), $filename);
                $pagops->comprobante = $filename;
            }

            $pagops->update();

            return response($pagops);
        }
    }
}
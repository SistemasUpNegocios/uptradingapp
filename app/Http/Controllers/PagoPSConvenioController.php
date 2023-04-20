<?php

namespace App\Http\Controllers;

use App\Models\Banco;
use App\Models\Cliente;
use App\Models\Convenio;
use App\Models\PagoPSConvenio;
use App\Models\Ps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PagoPSConvenioController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze){
            $convenios = Convenio::all();
            $ps = Ps::all();
            $clientes = Cliente::all();
            $bancos = Banco::all();
            $data = array(
                "convenios" => $convenios,
                "lista_ps" => $ps,
                "clientes" => $clientes,
                "bancos" => $bancos
            );
            return response()->view('pagopsconvenio.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }
    
    public function getPSConvenio()
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

        return datatables()->of($ps)->addColumn('enlace', 'pagopsconvenio.enlace')->rawColumns(['enlace'])->toJson();
    }

    public function getConvenios(Request $request)
    {

        $psid = $request->psid;
        $codigo = session('codigo_oficina'); 

        $convenios = DB::table('convenio')
            ->join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->join('banco', 'banco.id', '=', 'convenio.banco_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("convenio.id AS convenioid, ps.id AS psid, convenio.folio AS convenio, convenio.monto, convenio.monto_letra, convenio.fecha_inicio, convenio.fecha_fin, convenio.capertura, convenio.cmensual, convenio.ctrimestral, convenio.status, convenio.numerocuenta, ps.id AS ps_id, cliente.id AS cliente_id,  CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS cliente_nombre, banco.id AS banco_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre"))
            ->where("ps.id", "=", $psid)
            ->where("oficina.codigo_oficina", "like", $codigo)
            ->get();
            
        return datatables()->of($convenios)->addColumn('buttons', 'pagopsconvenio.buttons')->rawColumns(['buttons'])->toJson();
    }

    public function ifExists(Request $request)
    {
        if ($request->convenioid) {
            $id = $request->convenioid;

            $pagosps = DB::table("pago_ps_convenio")
                ->join('convenio', "convenio.id", "=", "pago_ps_convenio.convenio_id")
                ->join('ps', "ps.id", "=", "convenio.ps_id")
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->where("convenio_id", "=", $id)
                ->get();

            if ($pagosps) {
                return "Success";
            }
        }
    }

    public function getPagosPS(Request $request)
    {
        if ($request->convenioid) {
            $id = $request->convenioid;

            $pagosps = DB::table('pago_ps_convenio')
                ->join('convenio', 'convenio.id', '=', 'pago_ps_convenio.convenio_id')
                ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
                ->join('ps', "ps.id", "=", "convenio.ps_id")
                ->join('oficina', "oficina.id", "=", "ps.oficina_id")
                ->select(DB::raw("convenio.folio AS convenio, pago_ps_convenio.id, pago_ps_convenio.convenio_id AS convenioid, pago_ps_convenio.serie, pago_ps_convenio.fecha_pago, pago_ps_convenio.fecha_limite, pago_ps_convenio.fecha_pagado, pago_ps_convenio.pago, pago_ps_convenio.status, pago_ps_convenio.tipo_pago, pago_ps_convenio.memo, pago_ps_convenio.comprobante, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre"))
                ->where("convenio_id", "=", $id)
                ->get();

                if ($pagosps) {
                    return datatables()->of($pagosps)->addColumn('acciones', 'pagopsconvenio.acciones')->rawColumns(['acciones'])->toJson();
                }
        }
    }

    public function editPagoPS(Request $request)
    {
        if ($request->ajax()) {
            $pagops = PagoPSConvenio::find($request->id);

            $pagops->fecha_pagado = $request->fecha_pagado;
            $pagops->pago = $request->pago;
            $pagops->status = $request->status;
            $pagops->tipo_pago = $request->tipo_pago;

            if ($request->hasFile('foto')) {
                $pagopsconvenio = PagoPSConvenio::where('id', $request->id)->get();

                $imagen = $pagopsconvenio[0]->comprobante;

                if (is_file(public_path('img/comprobantes/pagopsconvenio') . $imagen)) {
                    chmod(public_path('img/comprobantes/pagopsconvenio') . $imagen, 0777);
                    unlink(public_path('img/comprobantes/pagopsconvenio') . $imagen);
                }

                $file = $request->file('foto');
                $filename = $file->getClientOriginalName();
                $ext = explode('.', $filename);
                $ext = end($ext);
                $filename = time().'_pagopsconvenio.' . $ext;

                $file->move(public_path('img/comprobantes/pagopsconvenio'), $filename);
                $pagops->comprobante = $filename;
            }

            $pagops->update();

            return response($pagops);
        }
    }
}
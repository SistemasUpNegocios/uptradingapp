<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\Modelo;
use App\Models\Ps;
use App\Models\Reintegro;
use App\Models\TipoContrato;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReintegroController extends Controller
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
        return response()->view('reintegro.show', $data, 200);
    }

    public function getReintegro()
    {
        $reintegro = DB::table('reintegro')
            ->join('contrato', 'contrato.id', '=', 'reintegro.contrato_id')
            ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
            ->join('ps', 'ps.id', '=', 'contrato.ps_id')
            ->join('tipo_contrato', 'tipo_contrato.id', '=', 'contrato.tipo_id')
            ->select(DB::raw("CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS clientenombre, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, tipo_contrato.tipo AS tipocontrato, reintegro.id, reintegro.fecha, reintegro.monto, reintegro.status, reintegro.memo, contrato.id AS contratoid, contrato.operador, contrato.lugar_firma, contrato.periodo, contrato.fecha AS fechacontrato, contrato.fecha_renovacion, contrato.fecha_pago, contrato.contrato, contrato.porcentaje, contrato.inversion, contrato.tipo_cambio, contrato.inversion_us, contrato.inversion_letra, contrato.status AS statuscontrato"))
            ->get();

        return datatables()->of($reintegro)->addColumn('btn', 'reintegro.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addReintegro(Request $request)
    {
        if ($request->ajax()) {
            $reintegro = new Reintegro;

            $reintegro->contrato_id = $request->input('contratoid');

            $reintegro->fecha = $request->input('fecha');

            $reintegro->monto = $request->input('monto');

            $reintegro->status = $request->input('status');

            $reintegro->memo = $request->input('memo');

            $reintegro->save();

            return response($reintegro);
        }
    }

    public function editReintegro(Request $request)
    {
        if ($request->ajax()) {
            $reintegro = Reintegro::find($request->id);

            $reintegro->contrato_id = $request->input('contratoid');

            $reintegro->fecha = $request->input('fecha');

            $reintegro->monto = $request->input('monto');

            $reintegro->status = $request->input('status');

            $reintegro->memo = $request->input('memo');

            $reintegro->update();

            return response($reintegro);
        }
    }

    public function deleteReintegro(Request $request)
    {
        if ($request->ajax()) {
            Reintegro::destroy($request->id);
        }
    }
}

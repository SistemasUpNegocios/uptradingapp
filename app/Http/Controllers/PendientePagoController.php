<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PendientesPagoExport;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Contrato;
use App\Models\Cliente;

class PendientePagoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }
    
    public function index()
    {
        $clientes = Cliente::select(DB::raw('CONCAT(nombre, " ", apellido_p, " ", apellido_m) AS nombre'), 'id')->get();
        $contratos = $this->consulta("all");

        return view('pendiente-pago.show', compact('contratos', 'clientes'));
    }

    public function getPendientePago(Request $request)
    {
        $contratos = $this->consulta($request->id);
        $id = $request->id;
        return view('pendiente-pago.tabla', compact('contratos', 'id'));
    }

    private function consulta($id)
    {
        if($id == "all"){
            $contratos = Contrato::join('cliente', 'contrato.cliente_id', '=', 'cliente.id')
            ->join('tipo_contrato', 'contrato.tipo_id', '=', 'tipo_contrato.id')
            ->select(
                DB::raw('CONCAT(cliente.nombre, " ", cliente.apellido_p, " ", cliente.apellido_m) AS nombre'),
                'cliente.id AS cliente_id',
                'contrato.id',
                'contrato.contrato',
                'contrato.fecha',
                'tipo_contrato.tipo',
                'contrato.inversion_us'
            )
            ->where('contrato.status', 'Activado')
            ->where('cliente.id', "!=", 261)
            ->orderBy('contrato.contrato', 'asc')
            ->get();
        }else{
            $contratos = Contrato::join('cliente', 'contrato.cliente_id', '=', 'cliente.id')
            ->join('tipo_contrato', 'contrato.tipo_id', '=', 'tipo_contrato.id')
            ->select(
                DB::raw('CONCAT(cliente.nombre, " ", cliente.apellido_p, " ", cliente.apellido_m) AS nombre'),
                'cliente.id AS cliente_id',
                'contrato.id',
                'contrato.contrato',
                'contrato.fecha',
                'tipo_contrato.tipo',
                'contrato.inversion_us'
            )
            ->where('contrato.status', 'Activado')
            ->where('cliente.id', "!=", 261)
            ->where('cliente.id', $id)
            ->orderBy('contrato.contrato', 'asc')
            ->get();
        }

        return $contratos;
    }

    public function export(Request $request)
    {
        if($request->id == "all"){
            $descarga = "Clientes con pendiente de pago.xlsx";
        }else{
            $cliente = Cliente::find($request->id);
            $cliente = $cliente->nombre . " " . $cliente->apellido_p . " " . $cliente->apellido_m;
            $descarga = "Pagos pendientes del cliente $cliente.xlsx";
        }

        return Excel::download(new PendientesPagoExport($request->id), "$descarga");
    }
}

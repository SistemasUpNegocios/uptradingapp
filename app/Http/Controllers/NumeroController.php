<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Cliente;

class NumeroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }
    
    public function index()
    {
        return view('numeros.show');
    }

    public function getNumeros()
    {
        $numeros = DB::table('contrato')
            ->join('cliente', 'contrato.cliente_id', '=', 'cliente.id')
            ->join('ps', 'contrato.ps_id', '=', 'ps.id')
            ->select(DB::raw('DISTINCT(cliente.celular) AS "telefono"'),
                DB::raw('CONCAT(cliente.nombre, " ", cliente.apellido_p, " ", cliente.apellido_m) AS "cliente"'),
                DB::raw('CONCAT(ps.nombre, " ", ps.apellido_p, " ", ps.apellido_m) AS "ps"'),
                DB::raw("cliente.id AS id_cliente, cliente.color, cliente.modelo, cliente.bitacora")
                )
            ->orderBy('cliente.nombre')
            ->get();
            
        return datatables()->of($numeros)->addColumn('btn', 'numeros.buttons')->addColumn('color', 'numeros.colors')->addColumn('modelo', 'numeros.modelo')->rawColumns(['btn', 'color', 'modelo'])->toJson();
    }

    public function editColor(Request $request)
    {
        $cliente = Cliente::find($request->id);
        $cliente->color = strtoupper($request->color);
        $cliente->save();

        return response($cliente);
    }

    public function editModelo(Request $request)
    {

        $cliente = Cliente::find($request->id);
        $cliente->modelo = strtoupper($request->modelo);
        $cliente->save();

        return response($cliente);
    }

    public function editBitacora(Request $request)
    {
        $cliente = Cliente::find($request->id);
        $cliente->bitacora = $request->bitacora;
        $cliente->save();

        return response($cliente);
    }
}

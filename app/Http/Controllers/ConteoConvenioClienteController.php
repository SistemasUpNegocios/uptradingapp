<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\Cliente;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class ConteoConvenioClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            return response()->view('conteoconveniosclientes.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getClientes(Request $request)
    {
        $lista_clientes = Cliente::select()->orderBy('codigoCliente', 'ASC')->get();
            
        $data = array(
            "fecha_inicio" => $request->fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
            "lista_clientes" => $lista_clientes,
            "dolar" => $request->dolar
        );

        return response()->view('conteoconveniosclientes.tabla', $data, 200);
    }

    public function imprimirReporte(Request $request)
    {
        $lista_clientes = Cliente::select()->orderBy('codigoCliente', 'ASC')->get();
            
        $data = array(
            "fecha_inicio" => $request->inicio,
            "fecha_fin" => $request->fin,
            "lista_clientes" => $lista_clientes,
            "dolar" => $request->dolar
        );

        $inicio = Carbon::parse($request->inicio)->formatLocalized('%d de %B de %Y');
        $fin = Carbon::parse($request->fin)->formatLocalized('%d de %B de %Y');

        $pdf = PDF::loadView('conteoconveniosclientes.imprimir', $data);
        $nombreDescarga = "Conteo de convenios desde $inicio hasta $fin.pdf";
        return $pdf->stream($nombreDescarga);
    }
}

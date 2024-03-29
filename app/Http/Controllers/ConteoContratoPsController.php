<?php

namespace App\Http\Controllers;

use App\Models\Oficina;
use App\Models\Ps;
use App\Models\Cliente;
use App\Models\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade as PDF;

class ConteoContratoPsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            return response()->view('conteocontratosps.show');
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getPs(Request $request)
    {
        $lista_ps = Ps::select()
            ->where('codigoPS', "!=", "IA1")
            ->where('codigoPS', "!=", "IA2")
            ->where('codigoPS', "!=", "IA3")
            ->orderBy('codigoPS', 'ASC')->get();
            
        $data = array(
            "fecha_inicio" => $request->fecha_inicio,
            "fecha_fin" => $request->fecha_fin,
            "lista_ps" => $lista_ps,
            "dolar" => $request->dolar
        );

        return response()->view('conteocontratosps.tabla', $data, 200);
    }

    public function imprimirReporte(Request $request)
    {
        $lista_ps = Ps::select()
            ->where('codigoPS', "!=", "IA1")
            ->where('codigoPS', "!=", "IA2")
            ->where('codigoPS', "!=", "IA3")
            ->orderBy('codigoPS', 'ASC')->get();
            
        $data = array(
            "fecha_inicio" => $request->inicio,
            "fecha_fin" => $request->fin,
            "lista_ps" => $lista_ps,
            "dolar" => $request->dolar
        );

        $inicio = Carbon::parse($request->inicio)->formatLocalized('%d de %B de %Y');
        $fin = Carbon::parse($request->fin)->formatLocalized('%d de %B de %Y');

        $pdf = PDF::loadView('conteocontratosps.imprimir', $data);
        $nombreDescarga = "Conteo de contratos desde $inicio hasta $fin.pdf";
        return $pdf->stream($nombreDescarga);
    }
}
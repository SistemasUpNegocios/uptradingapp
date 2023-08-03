<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ps;
use App\Models\Convenio;
use App\Models\Log;
use App\Models\Banco;
use App\Models\Notificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConvenioVencerController extends Controller
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

            $bancos = Banco::all();
            $ps = Ps::select()->where("codigoPS", "like", "$codigo%")->get();
            $clientes = Cliente::select()->orderBy("apellido_p")->where("codigoCliente", "like", "$numeroCliente%")->get();

            $data = array(
                "lista_ps" => $ps,
                "clientes" => $clientes,
                "bancos" => $bancos
            );

            return response()->view('conveniosvencer.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getConvenioVencer ()
    {
        $convenio = DB::table('convenio')
            ->join('ps', 'ps.id', '=', 'convenio.ps_id')
            ->join('cliente', 'cliente.id', '=', 'convenio.cliente_id')
            ->join('banco', 'banco.id', '=', 'convenio.banco_id')
            ->join('oficina', "oficina.id", "=", "ps.oficina_id")
            ->select(DB::raw("convenio.id, convenio.folio, convenio.monto, convenio.monto_letra, convenio.firma, convenio.fecha_inicio, convenio.fecha_fin, convenio.fecha_carga, convenio.capertura, convenio.cmensual, convenio.ctrimestral, ps.id AS ps_id, CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre, cliente.id AS cliente_id,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, cliente.celular, convenio.status, convenio.memo_status, convenio.status_oficina, convenio.numerocuenta, convenio.loggin, banco.id AS banco_id, autorizacion_nota, nota_convenio"))
            ->where("convenio.status", "Activado")
            ->where("fecha_fin", "<=", Carbon::now()->addDays(15)->format('Y-m-d'))
            ->where("fecha_fin", ">=", Carbon::now()->format('Y-m-d'))
            ->orderBy("fecha_fin", "ASC")
            ->get();
       

        return datatables()->of($convenio)->addColumn('btn', 'conveniosvencer.buttons')->rawColumns(['btn'])->toJson();
    }

    public function editNota(Request $request)
    {

        $bitacora_id = session('bitacora_id');

        $convenio = Convenio::find($request->id);
        $convenio->nota_convenio = $request->nota_convenio;
        $convenio->save();

        return response($convenio);
    }
    
    public function autorizarNota(Request $request)
    {
        $convenio = Convenio::find($request->id);
        $convenio->autorizacion_nota = $request->autorizacion;
        $convenio->save();

        return response($convenio);
    }
}
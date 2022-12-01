<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use App\Models\Cliente;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BitacoraController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos ){
            $clientes = Cliente::all();
            $data = array("lista_clientes" => $clientes);
            return response()->view('bitacora.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getBitacora()
    {
        $bitacora = DB::table('bitacora')
            ->join('cliente', 'cliente.id', '=', 'bitacora.cliente_id')
            ->select(DB::raw("bitacora.id, CONCAT(cliente.nombre, ' ', cliente.apellido_p, ' ', cliente.apellido_m) AS nombre, cliente.id AS clienteid, bitacora.nota"))
            ->get();

        return datatables()->of($bitacora)->addColumn('btn', 'bitacora.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addBitacora(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'clienteid' => 'required',
                'nota' => 'required',
            ]);

            $bitacora = new Bitacora;
            $bitacora->cliente_id = $request->input('clienteid');
            $bitacora->nota = strtoupper($request->input('nota'));

            $bitacora->save();

            $bitacora_table_id = $bitacora->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Bitácora";
            $log->id_tabla = $bitacora_table_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                return response($bitacora);
            }
        }
    }

    public function editBitacora(Request $request)
    {
        if ($request->ajax()) {
            
            $request->validate([
                'clienteid' => 'required',
                'nota' => 'required',
            ]);

            $bitacora = Bitacora::find($request->id);
            $bitacora->cliente_id = $request->input('clienteid');
            $bitacora->nota = strtoupper($request->input('nota'));
            $bitacora->update();

            $bitacora_table_id = $bitacora->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Bitácora";
            $log->id_tabla = $bitacora_table_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                return response($bitacora);
            }
        }
    }

    public function deleteBitacora(Request $request)
    {
        if ($request->ajax()) {
            $bitacora_table_id = $request->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Eliminación";
            $log->tabla = "Bitácora";
            $log->id_tabla = $bitacora_table_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                Bitacora::destroy($request->id);
            }
        }
    }
}
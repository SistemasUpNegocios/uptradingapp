<?php

namespace App\Http\Controllers;

use App\Models\Folio;
use App\Models\Contrato;
use App\Models\Log;
use Illuminate\Http\Request;

class FolioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){
            $lista_contratos = Contrato::all();
            return view('folio.show', compact('lista_contratos'));
        }else{
            return redirect()->to('/admin/dashboard');
        }

    }

    public function getFolioCancelado()
    {
        $folio = Folio::join("contrato", "contrato.id", "=", "folio.contrato_id")
            ->select("folio.id", "folio.folio", "contrato.contrato", "contrato.id AS contratoid", "folio.estatus", "folio.fecha")
            ->where("folio.estatus", "Cancelado")
            ->get();

        return datatables()->of($folio)->addColumn('btn', 'folio.buttons_cancelado')->rawColumns(['btn'])->toJson();
    }

    public function getFolio()
    {
        $folio = Folio::join("contrato", "contrato.id", "=", "folio.contrato_id")
            ->select("folio.id", "folio.folio", "contrato.contrato", "contrato.id AS contratoid", "folio.estatus", "folio.fecha")
            ->where("folio.estatus", "En uso")
            ->get();

        return datatables()->of($folio)->addColumn('btn', 'folio.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addFolio(Request $request)
    {
        if ($request->ajax()) {

            $folio = new Folio;
            $folio->folio = $request->folio;
            $folio->contrato = $request->contrato;
            $folio->estatus = $request->estatus;
            $folio->fecha = $request->fecha;
            $folio->save();

            $folio_id = $folio->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Folio";
            $log->id_tabla = $folio_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                return response($folio);
            }
        }
    }

    public function editFolio(Request $request)
    {
        if ($request->ajax()) {

            $folio = Folio::find($request->id);
            $folio->folio = $request->folio;
            $folio->contrato = $request->contrato;
            $folio->estatus = $request->estatus;
            $folio->fecha = $request->fecha;
            $folio->update();

            $folio_id = $folio->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Folio";
            $log->id_tabla = $folio_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                return response($folio);
            }
        }
    }

    public function deleteFolio(Request $request)
    {
        if ($request->ajax()) {
            $folio_id = $request->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Eliminación";
            $log->tabla = "Folio";
            $log->id_tabla = $folio_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                Folio::destroy($request->id);
            }
        }
    }
}
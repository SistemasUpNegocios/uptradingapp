<?php

namespace App\Http\Controllers;

use App\Models\Clausula;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClausulaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function ifExists(Request $request)
    {
        if ($request->tipo) {
            $id = $request->tipoid;

            $clausulas = DB::table("clausula")
                ->where("tipo_id", "=", $id)
                ->get();

            if ($clausulas) {
                return "Success";
            }
        }
    }

    public function getClausulas(Request $request)
    {
        if ($request->tipoid) {
            $id = $request->tipoid;

            $clausulas = DB::table("clausula")
                ->where("tipo_id", "=", $id)
                ->get();

            if ($clausulas) {
                return datatables()->of($clausulas)->addColumn('btn', 'tipocontrato.buttons_clau')->rawColumns(['btn'])->toJson();
            }
        }
    }

    public function addClausula(Request $request)
    {
        if ($request->ajax()) {
            $clausula = new Clausula;
            $clausula->redaccion = $request->input('redaccion');
            $clausula->tipo_id = $request->input('tipoid');
            $clausula->save();

            $clausula_id = $clausula->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Cláusula";
            $log->id_tabla = $clausula_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                return response($clausula);
            }
        }
    }

    public function editClausula(Request $request)
    {
        if ($request->ajax()) {
            $clausula = Clausula::find($request->id);
            $clausula->redaccion = $request->input('redaccion');
            $clausula->update();

            $clausula_id = $clausula->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Cláusula";
            $log->id_tabla = $clausula_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                return response($clausula);
            }
        }
    }

    public function deleteClausula(Request $request)
    {
        if ($request->ajax()) {
            $clausula_id = $request->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Eliminación";
            $log->tabla = "Cláusula";
            $log->id_tabla = $clausula_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                Clausula::destroy($request->id);
            }
        }
    }
}

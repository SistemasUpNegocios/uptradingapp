<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DocumentoController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function index()
    {
        $documentos = Documento::orderByDesc("tipo_documento")->get();
        return response()->view('documento.show', compact("documentos"));
    }

    public function addDocumento(Request $request)
    {
        if ($request->ajax())
        {
            $documento = new Documento;
            $documento->nombre = $request->nombre;
            $documento->tipo_documento = $request->tipo_documento;
            if ($request->hasFile('documento')) {

                $file = $request->file('documento');            
                $filename = $file->getClientOriginalName();
    
                if($request->tipo_documento == "swissquote"){
                    $file->move(public_path("documentos/swissquote"), $filename);
                }else if($request->tipo_documento == "uptrading"){
                    $file->move(public_path("documentos/uptrading"), $filename);
                }

                $documento->documento = $filename;
            }

            $documento->save();

            $documento_id = $documento->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Documento";
            $log->id_tabla = $documento_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            $documentos = Documento::orderByDesc("tipo_documento")->get();
            return response($documentos);
        }
    }

    public function editDocumento(Request $request)
    {
        if ($request->ajax())
        {
            $documento = Documento::find($request->id);
            $documento->nombre = $request->nombre;
            $documento->tipo_documento = $request->tipo_documento;
            if ($request->hasFile('documento')) {

                $file = $request->file('documento');            
                $filename = $file->getClientOriginalName();
    
                if($request->tipo_documento == "swissquote"){
                    $file->move(public_path("documentos/swissquote"), $filename);
                }else if($request->tipo_documento == "uptrading"){
                    $file->move(public_path("documentos/uptrading"), $filename);
                }

                $documento->documento = $filename;
            }
            $documento->update();

            $documento_id = $documento->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Documento";
            $log->id_tabla = $documento_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            $documentos = Documento::orderByDesc("tipo_documento")->get();
            return response($documentos);
        }
    }

    public function deleteDocumento(Request $request)
    {
        $documento_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Documento";
        $log->id_tabla = $documento_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
        if ($request->ajax())
        {
            Documento::destroy($request->id);
        }
    }

        $documentos = Documento::orderByDesc("tipo_documento")->get();
        return response($documentos);
    }
}

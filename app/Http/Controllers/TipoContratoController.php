<?php

namespace App\Http\Controllers;

use App\Models\TipoContrato;
use Illuminate\Http\Request;
use App\Models\Modelo;
use Illuminate\Support\Facades\DB;

class TipoContratoController extends Controller
{
    public function __construct(){
        $this->middleware('auth.admin');
    }
    
    public function index()
    {

        if (auth()->user()->is_root){
            $modelos = Modelo::all();
            $data = array(
                "lista_modelos" => $modelos
            );

            return response()->view('tipocontrato.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
        
    }

    public function getTipoContratos()
    {
        $tipoContrato = DB::table('tipo_contrato')
        ->join('modelo_contrato', 'modelo_contrato.id', '=', 'tipo_contrato.modelo_id')
        ->select(DB::raw("tipo_contrato.id, tipo_contrato.tipo, tipo_contrato.redaccion, tipo_contrato.capertura, tipo_contrato.cmensual, tipo_contrato.rendimiento, tipo_contrato.modelo_id AS modeloid, tipo_contrato.tabla, modelo_contrato.modelo AS nombremodelo "))
        ->get();

        return datatables()->of($tipoContrato)->addColumn('btn', 'tipocontrato.buttons')->rawColumns(['btn'])->toJson();
    }

    public function getTipoContrato(Request $request)
    {
        $tipoContrato = DB::table('tipo_contrato')
        ->select(DB::raw("tipo_contrato.id, tipo_contrato.tipo, tipo_contrato.redaccion, tipo_contrato.capertura, tipo_contrato.cmensual, tipo_contrato.rendimiento"))
        ->where("tipo_contrato.id", "=", $request->tipoid)
        ->get();

        return response($tipoContrato);
    }

    public function addTipoContrato(Request $request)
    {
        if ($request->ajax())
        {

            $request->validate([
                'tipo' => 'required',
                'redaccion' => 'required',
                'capertura' => 'required',
                'cmensual' => 'required',
                'rendimiento' => 'required',
            ]);

            $switch = $request->input('tabla');
            if(!empty($switch)){
                $switch = true;
            }else{
                $switch = false;
            }

            $tipoContrato = new TipoContrato;
            $tipoContrato->tipo = $request->input('tipo');
            $tipoContrato->redaccion = $request->input('redaccion');
            $tipoContrato->capertura = $request->input('capertura');
            $tipoContrato->cmensual = $request->input('cmensual');
            $tipoContrato->rendimiento = $request->input('rendimiento');
            $tipoContrato->tabla = $switch;
            $tipoContrato->modelo_id = $request->input('modelo_id');
            $tipoContrato->save();

            return response($tipoContrato);
        }
    }

    public function editTipoContrato(Request $request)
    {
        if ($request->ajax())
        {
            $request->validate([
                'tipo' => 'required',
                'redaccion' => 'required',
                'capertura' => 'required',
                'cmensual' => 'required',
            ]);

            $switch = $request->input('tabla');
            if(!empty($switch)){
                $switch = true;
            }else{
                $switch = false;
            }
            
            $tipoContrato = TipoContrato::find($request->id);
            $tipoContrato->tipo = $request->input('tipo');
            $tipoContrato->redaccion = $request->input('redaccion');
            $tipoContrato->capertura = $request->input('capertura');
            $tipoContrato->cmensual = $request->input('cmensual');
            $tipoContrato->rendimiento = $request->input('rendimiento');
            $tipoContrato->tabla = $switch;
            $tipoContrato->modelo_id = $request->input('modelo_id');

            $tipoContrato->update();

            return response($tipoContrato);
        }
    }

    public function deleteTipoContrato(Request $request)
    {
        if ($request->ajax())
        {
            TipoContrato::destroy($request->id);
        }
    }

}
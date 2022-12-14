<?php

namespace App\Http\Controllers;

use App\Models\PSMovil;
use App\Models\User;
use App\Models\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PSMovilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos){    
            $lista_ps = User::where('privilegio', 'ps_encargado')->get();
            return view('psmovil.show', compact('lista_ps'));
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getPsMovil()
    {
        $psmovil = PSMovil::join('users', 'users.id', '=', 'psmovil.ps_encargado')
            ->select(DB::raw("CONCAT(users.nombre, ' ', users.apellido_p) AS ps_encargado, psmovil.id, psmovil.imei, psmovil.mac_wifi, psmovil.no_serie"))
            ->get();

        return datatables()->of($psmovil)->addColumn('btn', 'psmovil.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addPSMovil(Request $request)
    {
        if ($request->ajax()) {

            $request->validate([
                'ps_encargado' => 'required',
                'imei' => 'required',
                'mac_wifi' => 'required',
                'serie' => 'required',
            ]);

            $psmovil = new PSMovil;
            $psmovil->ps_encargado = $request->ps_encargado;
            $psmovil->imei = $request->input('imei');
            $psmovil->mac_wifi = strtoupper($request->input('mac_wifi'));
            $psmovil->no_serie = strtoupper($request->input('serie'));

            $psmovil->save();

            $psmovil_id = $psmovil->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "PS Móvil";
            $log->id_tabla = $psmovil_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                return response($psmovil);
            }
        }
    }

    public function editPSMovil(Request $request)
    {
        if ($request->ajax()) {
            
            $request->validate([
                'ps_encargado' => 'required',
                'imei' => 'required',
                'mac_wifi' => 'required',
                'serie' => 'required',
            ]);

            $psmovil = PSMovil::find($request->id);
            $psmovil->ps_encargado = $request->ps_encargado;
            $psmovil->imei = $request->input('imei');
            $psmovil->mac_wifi = strtoupper($request->input('mac_wifi'));
            $psmovil->no_serie = strtoupper($request->input('serie'));

            $psmovil->update();

            $psmovil_id = $psmovil->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "PS Móvil";
            $log->id_tabla = $psmovil_id;
            $log->bitacora_id = $bitacora_id;


            if ($log->save()) {
                return response($psmovil);
            }
        }
    }

    public function deletePSMovil(Request $request)
    {
        if ($request->ajax()) {
            $psmovil_id = $request->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Eliminación";
            $log->tabla = "PS Móvil";
            $log->id_tabla = $psmovil_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                PSMovil::destroy($request->id);
            }
        }
    }
}
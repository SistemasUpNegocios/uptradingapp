<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Mail\CitaEmail;
use App\Models\Cita;
use App\Models\Log;
use Carbon\Carbon;

class CitaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        $citas_pendientes = Cita::select()->orderBy('dia', 'ASC')->orderBy('hora', 'ASC')->where('estatus', 'pendiente')->get();
        $citas_proceso = Cita::select()->orderBy('dia', 'ASC')->orderBy('hora', 'ASC')->where('estatus', 'proceso')->get();
        $citas_canceladas = Cita::select()->orderBy('dia', 'ASC')->orderBy('hora', 'ASC')->where('estatus', 'cancelada')->get();
        $citas_atendidas = Cita::select()->orderBy('dia', 'ASC')->orderBy('hora', 'ASC')->where('estatus', 'atendida')->get();
        return view('citas.show', compact('citas_pendientes', 'citas_proceso', 'citas_canceladas', 'citas_atendidas'));
    }

    public function getCountCitas()
    {
        $citas = Cita::select()->where('estatus', 'pendiente')->count();
        return response($citas);
    }

    public function buscarCita(Request $request)
    {
        $data = $request->query_cita;
        $opc = $request->opc;

        $citas_pendientes = Cita::where(function ($query)  use ($data) {
            $query->whereRaw("CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%" . $data . "%'")
            ->orWhere("codigo_cliente", "like", "%$data%");
        })
        ->where("estatus", "pendiente")
        ->orderByRaw(
            "CASE
                WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '$data%' THEN 1
                WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%$data' THEN 3
            ELSE 2
            END"
        )->get();

        $citas_proceso = Cita::where(function ($query)  use ($data) {
            $query->whereRaw("CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%" . $data . "%'")
            ->orWhere("codigo_cliente", "like", "%$data%");
        })
        ->where("estatus", "proceso")
        ->orderByRaw(
            "CASE
                WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '$data%' THEN 1
                WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%$data' THEN 3
            ELSE 2
            END"
        )->get();

        $citas_canceladas = Cita::where(function ($query)  use ($data) {
            $query->whereRaw("CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%" . $data . "%'")
            ->orWhere("codigo_cliente", "like", "%$data%");
        })
        ->where("estatus", "cancelada")
        ->orderByRaw(
            "CASE
                WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '$data%' THEN 1
                WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%$data' THEN 3
            ELSE 2
            END"
        )->get()
        ;
        $citas_atendidas = Cita::where(function ($query)  use ($data) {
            $query->whereRaw("CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%" . $data . "%'")
            ->orWhere("codigo_cliente", "like", "%$data%");
        })
        ->where("estatus", "atendida")
        ->orderByRaw(
            "CASE
                WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '$data%' THEN 1
                WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%$data' THEN 3
            ELSE 2
            END"
        )->get();

        $active = $opc;
        
        
        return view('citas.tabscitas', compact('citas_pendientes', 'citas_proceso', 'citas_canceladas', 'citas_atendidas', 'active'));
    }

    public function editHorarioCita(Request $request)
    {
        $cita = Cita::find($request->id);
        $cita->dia = $request->dia;
        $cita->hora = $request->hora;
        $cita->save();

        $dia = Carbon::parse($request->dia)->formatLocalized('%d de %B de %Y');
        $hora =  Carbon::parse($request->hora)->format('H:i');
        $fecha = "$dia a las $hora hrs";

        Mail::to("javiersalazar@uptradingexperts.com")->send(new CitaEmail("Javier Salazar", $fecha));

        $log = new Log;
        $log->tipo_accion = "Actualización";
        $log->tabla = "Citas";
        $log->id_tabla = $cita->id;
        $log->bitacora_id = session('bitacora_id');

        if ($log->save()) {
            return $this->getCitas($request->active);
        }
    }

    public function editBitacoraCita(Request $request)
    {
        $cita = Cita::find($request->id);
        if($cita->contenido_llamada != $request->contenido_llamada){
            $cita->fecha_contenido_llamada = Carbon::now();
        }

        if($cita->acuerdo != $request->acuerdo){
            $cita->fecha_acuerdo = Carbon::now();
        }

        if($cita->firma_documento != $request->firma_documento){
            $cita->fecha_firma_documento = Carbon::now();
        }

        if($cita->otros_comentarios != $request->otros_comentarios){
            $cita->fecha_otros_comentarios = Carbon::now();
        }

        $cita->contenido_llamada = $request->contenido_llamada;
        $cita->acuerdo = $request->acuerdo;
        $cita->firma_documento = $request->firma_documento;
        $cita->otros_comentarios = $request->otros_comentarios;
        $cita->save();

        if($cita->save()){
            $log = new Log;
            $log->tipo_accion = "Actualización";
            $log->tabla = "Citas";
            $log->id_tabla = $cita->id;
            $log->bitacora_id = session('bitacora_id');
            $log->save();

            return $this->getCitas($request->active);
        }
    }

    public function editStatusCita(Request $request)
    {
        $cita = Cita::find($request->id_estatus);
        $cita->estatus = $request->estatus;
        $cita->save();

        $log = new Log;
        $log->tipo_accion = "Actualización";
        $log->tabla = "Citas";
        $log->id_tabla = $cita->id;
        $log->bitacora_id = session('bitacora_id');

        if ($log->save()) {
            return $this->getCitas($request->active_estatus);
        }
    }

    public function deleteCita(Request $request)
    {

        $log = new Log;
        $log->tipo_accion = "Eliminación";
        $log->tabla = "Citas";
        $log->id_tabla = $request->id;
        $log->bitacora_id = session('bitacora_id');

        if ($log->save()) {
            Cita::destroy($request->id);
        }
    }

    public function getAllCitas(Request $request)
    {
        return $this->getCitas($request->opc);
    }

    private function getCitas($active)
    {
        $citas_pendientes = Cita::select()->orderBy('dia', 'ASC')->orderBy('hora', 'ASC')->where('estatus', 'pendiente')->get();
        $citas_proceso = Cita::select()->orderBy('dia', 'ASC')->orderBy('hora', 'ASC')->where('estatus', 'proceso')->get();
        $citas_canceladas = Cita::select()->orderBy('dia', 'ASC')->orderBy('hora', 'ASC')->where('estatus', 'cancelada')->get();
        $citas_atendidas = Cita::select()->orderBy('dia', 'ASC')->orderBy('hora', 'ASC')->where('estatus', 'atendida')->get();
        return view('citas.tabscitas', compact('citas_pendientes', 'citas_proceso', 'citas_canceladas', 'citas_atendidas', 'active'));
    }
}

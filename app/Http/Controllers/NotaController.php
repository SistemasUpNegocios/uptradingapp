<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Nota;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotaController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth.admin");
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos){
            return $this->consultas("nota.show");
        }else{
            return redirect()->to("/admin/dashboard");
        }
    }

    public function getUsuariosAsignados(Request $request)
    {
        if(auth()->user()->is_root || auth()->user()->is_egresos){
            $usuario_asignado = User::select("id", "nombre", "foto_perfil")->where("id", $request->id)->get();

            if ($request->id == 0 || $request->id != auth()->user()->id) {
                $usuarios_a_asignar = User::select("id", "nombre", "foto_perfil")->where("id", auth()->user()->id)->get();
            }else{
                $usuarios_a_asignar = User::select("id", "nombre", "foto_perfil")->where("id", 0)->get();
            }
        }else{
            $usuario_asignado = User::select("id", "nombre", "foto_perfil")->where("id", $request->id)->get();

            if ($request->id == 0) {
                $usuarios_a_asignar = User::select("id", "nombre", "foto_perfil")->where("id", 234)->orWhere("id", 235)->get();
            }else if($request->id == 234){
                $usuarios_a_asignar = User::select("id", "nombre", "foto_perfil")->where("id", 235)->get();
            }else if($request->id == 235){
                $usuarios_a_asignar = User::select("id", "nombre", "foto_perfil")->where("id", 234)->get();
            }
        }

        $data = array(
            "usuario_asignado" => $usuario_asignado,
            "usuarios_a_asignar" => $usuarios_a_asignar,
        );

        return response($data);
    }

    public function addNota(Request $request)
    {

        $nombre = ucfirst(strtolower(auth()->user()->nombre));
        $fecha = Carbon::now()->isoFormat('D [de] MMMM [de] YYYY HH:mm');

        $nota = new Nota;
        $nota->titulo = $request->titulo;
        $nota->estatus = $request->estatus;
        $nota->fecha_creacion = Carbon::now();
        $nota->fecha_actualizacion = Carbon::now();
        $nota->historial = "$nombre creó la tarea,$fecha";
        $nota->contribucion = auth()->user()->foto_perfil.",".$nombre;
        $nota->creado_por = auth()->user()->id;
        $nota->save();

        $log = new Log;
        $log->tipo_accion = "Inserción";
        $log->tabla = "Nota";
        $log->id_tabla = $nota->id;
        $log->bitacora_id = session("bitacora_id");
        $log->save();

        return $this->consultas("nota.notas");
    }

    public function editNota(Request $request)
    {
        $nombre = ucfirst(strtolower(auth()->user()->nombre));
        $fecha = Carbon::now()->isoFormat('D [de] MMMM [de] YYYY HH:mm');
        $foto_perfil = auth()->user()->foto_perfil;

        $nota = Nota::find($request->id);
        $pos = strpos($nota->contribucion, $foto_perfil);
        if ($pos === false) {
            $nota->contribucion = "$nota->contribucion,$foto_perfil,$nombre";
        }

        if($request->campo == "titulo"){
            $nota->titulo = $request->titulo;
            $nota->historial = "$nota->historial,$nombre editó el titulo,$fecha";
        }else if($request->campo == "descripción"){
            $nota->descripcion = $request->descripcion;
            $nota->historial = "$nota->historial,$nombre editó la descripción,$fecha";
        }else if($request->campo == "estatus"){
            $nota->archivada = "no";
            $nota->estatus = $request->estatus;
            if ($request->estatus == "Terminada") {
                $nota->historial = "$nota->historial,$nombre terminó la tarea,$fecha";
            }else{
                $nota->historial = "$nota->historial,$nombre movió la tarea a '$request->estatus',$fecha";
            }

            // if($request->arrastre == "si"){
            //     // Recuperar la posición dentro del contenedor específico
            //     $posicionEnContenedor = Nota::where('estatus', $request->estatus)
            //     ->where('posicion', '<=', $request->posicion)
            //     ->where('columna', $request->columna)
            //     ->count();

            //     // $nota->posicion = $posicionEnContenedor + 1;

            //     if ($request->estatus == "Abierta") {
            //         $nota->columna = 1;
            //     }else if($request->estatus == "En progreso"){
            //         $nota->columna = 2;
            //     }else if($request->estatus == "Terminada"){
            //         $nota->columna = 3;
            //     }
            // }
        }else if($request->campo == "archivada"){
            $nota->archivada = $request->archivada;
            $nota->historial = "$nota->historial,$nombre archivó la tarea,$fecha";
        }else if($request->campo == "fecha limite"){
            if($request->fecha_limite != ""){
                if ($nota->fecha_limite == "") {
                    $nota->historial = "$nota->historial,$nombre estableció una fecha límite,$fecha";
                }else{
                    $nota->historial = "$nota->historial,$nombre cambió el plazo,$fecha";
                }
            }else{
                $nota->historial = "$nota->historial,$nombre retiró la fecha límite,$fecha";
            }
            $nota->fecha_limite = $request->fecha_limite;
        }else if($request->campo == "asignar a"){
            $nota->asignado_a = $request->asignado_a;
            $user_asignado = User::where("id", $request->asignado_a)->first();
            $user_asignado_nombre = ucfirst(strtolower($user_asignado->nombre));

            $pos = strpos($nota->contribucion, $user_asignado->foto_perfil);
            if ($pos === false) {
                $nota->contribucion = "$nota->contribucion,$user_asignado->foto_perfil,$user_asignado_nombre";
            }

            $nota->historial = "$nota->historial,$nombre → $user_asignado_nombre,$fecha";
        }else if($request->campo == "desasignar"){
            $nota->asignado_a = null;
            $nota->historial = "$nota->historial,$nombre desasignó la tarea,$fecha";
        }
        $nota->save();

        $log = new Log;
        $log->tipo_accion = "Actualización";
        $log->tabla = "Nota ($request->campo)";
        $log->id_tabla = $request->id;
        $log->bitacora_id = session("bitacora_id");
        $log->save();

        return $this->consultas("nota.notas");
    }

    public function deleteNota(Request $request)
    {
        $log = new Log;
        $log->tipo_accion = "Eliminación";
        $log->tabla = "Nota";
        $log->id_tabla = $request->id;
        $log->bitacora_id = session("bitacora_id");

        if ($log->save()) {
            Nota::destroy($request->id);

            return $this->consultas("nota.notas");
        }
    }

    private function consultas($vista)
    {
        if (auth()->user()->is_root || auth()->user()->is_egresos) {
            $notas_abiertas = Nota::join("users", "users.id", "=", "notas.creado_por")
            ->select(DB::raw("users.nombre, users.foto_perfil, notas.id, notas.titulo, notas.descripcion, notas.estatus, notas.fecha_creacion, notas.fecha_actualizacion, notas.fecha_limite, notas.historial, notas.contribucion, notas.asignado_a"))
            ->where("notas.estatus", "Abierta")
            ->where("notas.archivada", "no")
            ->where("notas.creado_por", auth()->user()->id)
            ->orderBy('notas.columna','ASC')
            ->orderBy('notas.posicion','ASC')
            ->get();
            
            $notas_progreso = Nota::join("users", "users.id", "=", "notas.creado_por")
            ->select(DB::raw("users.nombre, users.foto_perfil, notas.id, notas.titulo, notas.descripcion, notas.estatus, notas.fecha_creacion, notas.fecha_actualizacion, notas.fecha_limite, notas.historial, notas.contribucion, notas.asignado_a"))
            ->where("notas.estatus", "En progreso")
            ->where("notas.archivada", "no")
            ->where("notas.creado_por", auth()->user()->id)
            ->orderBy('notas.columna','ASC')
            ->orderBy('notas.posicion','ASC')
            ->get();

            $notas_terminada = Nota::join("users", "users.id", "=", "notas.creado_por")
            ->select(DB::raw("users.nombre, users.foto_perfil, notas.id, notas.titulo, notas.descripcion, notas.estatus, notas.fecha_creacion, notas.fecha_actualizacion, notas.fecha_limite, notas.historial, notas.contribucion, notas.asignado_a"))
            ->where("notas.estatus", "Terminada")
            ->where("notas.archivada", "no")
            ->where("notas.creado_por", auth()->user()->id)
            ->orderBy('notas.columna','ASC')
            ->orderBy('notas.posicion','ASC')
            ->get();

            $notas_archivadas = Nota::join("users", "users.id", "=", "notas.creado_por")
            ->select(DB::raw("users.nombre, users.foto_perfil, notas.id, notas.titulo, notas.descripcion, notas.estatus, notas.fecha_creacion, notas.fecha_actualizacion, notas.fecha_limite, notas.historial, notas.contribucion, notas.asignado_a"))
            ->where("notas.archivada", "si")
            ->where("notas.creado_por", auth()->user()->id)
            ->orderBy('notas.columna','ASC')
            ->orderBy('notas.posicion','ASC')
            ->get();
    
            $notas_abiertas_count = Nota::where("estatus", "Abierta")->where("archivada", "no")->where("creado_por", auth()->user()->id)->count();
            $notas_progreso_count = Nota::where("estatus", "En progreso")->where("archivada", "no")->where("creado_por", auth()->user()->id)->count();
            $notas_terminada_count = Nota::where("estatus", "Terminada")->where("archivada", "no")->where("creado_por", auth()->user()->id)->count();
            $notas_archivadas_count = Nota::where("archivada", "si")->where("creado_por", auth()->user()->id)->count();
        }elseif (auth()->user()->is_admin || auth()->user()->is_procesos) {
            $notas_abiertas = Nota::join("users", "users.id", "=", "notas.creado_por")
            ->select(DB::raw("users.nombre, users.foto_perfil, notas.id, notas.titulo, notas.descripcion, notas.estatus, notas.fecha_creacion, notas.fecha_actualizacion, notas.fecha_limite, notas.historial, notas.contribucion, notas.asignado_a"))
            ->where("notas.estatus", "Abierta")
            ->where("notas.archivada", "no")
            ->where(function ($query) {
                $query->where("notas.creado_por", 234)->orWhere("notas.creado_por", 235);
            })->orderBy("notas.posicion", "ASC")->get();
            
            $notas_progreso = Nota::join("users", "users.id", "=", "notas.creado_por")
            ->select(DB::raw("users.nombre, users.foto_perfil, notas.id, notas.titulo, notas.descripcion, notas.estatus, notas.fecha_creacion, notas.fecha_actualizacion, notas.fecha_limite, notas.historial, notas.contribucion, notas.asignado_a"))
            ->where("notas.estatus", "En progreso")
            ->where("notas.archivada", "no")
            ->where(function ($query) {
                $query->where("notas.creado_por", 234)->orWhere("notas.creado_por", 235);
            })->orderBy("notas.posicion", "ASC")->get();

            $notas_terminada = Nota::join("users", "users.id", "=", "notas.creado_por")
            ->select(DB::raw("users.nombre, users.foto_perfil, notas.id, notas.titulo, notas.descripcion, notas.estatus, notas.fecha_creacion, notas.fecha_actualizacion, notas.fecha_limite, notas.historial, notas.contribucion, notas.asignado_a"))
            ->where("notas.estatus", "Terminada")
            ->where("notas.archivada", "no")
            ->where(function ($query) {
                $query->where("notas.creado_por", 234)->orWhere("notas.creado_por", 235);
            })->orderBy("notas.posicion", "ASC")->get();

            $notas_archivadas = Nota::join("users", "users.id", "=", "notas.creado_por")
            ->select(DB::raw("users.nombre, users.foto_perfil, notas.id, notas.titulo, notas.descripcion, notas.estatus, notas.fecha_creacion, notas.fecha_actualizacion, notas.fecha_limite, notas.historial, notas.contribucion, notas.asignado_a"))
            ->where("notas.archivada", "si")
            ->where(function ($query) {
                $query->where("notas.creado_por", 234)->orWhere("notas.creado_por", 235);
            })->orderBy("notas.posicion", "ASC")->get();
    
            $notas_abiertas_count = Nota::where("estatus", "Abierta")
            ->where("archivada", "no")
            ->where(function ($query) {
                $query->where("creado_por", 234)->orWhere("creado_por", 235);
            })->count();

            $notas_progreso_count = Nota::where("estatus", "En progreso")
            ->where("archivada", "no")
            ->where(function ($query) {
                $query->where("creado_por", 234)->orWhere("creado_por", 235);
            })->count();
            
            $notas_terminada_count = Nota::where("estatus", "Terminada")
            ->where("archivada", "no")
            ->where(function ($query) {
                $query->where("creado_por", 234)->orWhere("creado_por", 235);
            })->count();
            
            $notas_archivadas_count = Nota::where("archivada", "si")
            ->where(function ($query) {
                $query->where("creado_por", 234)->orWhere("creado_por", 235);
            })->count();
        }

        
        $data = array(
            "notas_abiertas" => $notas_abiertas,
            "notas_progreso" => $notas_progreso,
            "notas_terminada" => $notas_terminada,
            "notas_archivadas" => $notas_archivadas,
            "notas_abiertas_count" => $notas_abiertas_count,
            "notas_progreso_count" => $notas_progreso_count,
            "notas_terminada_count" => $notas_terminada_count,
            "notas_archivadas_count" => $notas_archivadas_count,
        );

        return response()->view($vista, $data, 200);
    }
}

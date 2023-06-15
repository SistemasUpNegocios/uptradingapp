<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Agenda;
use App\Models\User;
use App\Models\Log;
use App\Models\Notificacion;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Spatie\GoogleCalendar\Event;
use Illuminate\Support\Facades\Mail;
use App\Mail\AgendaEmail;

use Google_Client;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }
    
    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze){

            if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos) {
                $users = User::where('privilegio', 'root')
                    ->orWhere('privilegio', 'admin')
                    ->orWhere('privilegio', 'procesos')
                    ->orWhere('privilegio', 'egresos')
                    ->get();
            }elseif(auth()->user()->is_ps_gold || auth()->user()->is_ps_diamond || auth()->user()->is_ps_bronze){
                $users = User::where('privilegio', 'admin')
                ->orWhere('privilegio', 'procesos')
                ->get();
            }
            
            return View('agenda.show', compact('users'));
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function addAgenda(Request $request)
    {
        $agenda = new Agenda;

        $agenda->title = $request->titulo;
        $agenda->description = $request->descripcion;
        $agenda->start = $request->fecha . ' ' . $request->hora;
        $agenda->color = $request->color;
        $agenda->asignado_a = $request->asignado_a;
        $agenda->asignado_a2 = $request->asignado_a2;
        $agenda->generado_por = auth()->user()->id;
        $agenda->save();        
        
        $fecha = Carbon::parse($agenda->start)->formatLocalized('%d de %B de %Y');
        $hora = Carbon::parse($agenda->start)->format('h:i a');

        $user = User::find($request->asignado_a);
        $user2 = User::find($request->asignado_a2);

        if (strlen($request->descripcion) > 0) {
            $descripcion = $request->descripcion;
            $mensaje_notif = $request->descripcion;
        }else{
            $descripcion = "No hay más información para mostrar.";
            $mensaje_notif = $request->titulo;
        }

        Mail::to($user->correo)->send(new AgendaEmail($user->nombre, $fecha, $hora, $request->titulo, $descripcion, "nueva"));

        if(strlen($user2) > 0){
            Mail::to($user2->correo)->send(new AgendaEmail($user2->nombre, $fecha, $hora, $request->titulo, $descripcion, "nueva"));
            $notificacion = new Notificacion;
            $notificacion->titulo = $request->titulo;
            $notificacion->mensaje = $mensaje_notif;
            $notificacion->status = 'Pendiente';
            $notificacion->user_id = $request->asignado_a2;
            $notificacion->save();
        }

        $notificacion = new Notificacion;
        $notificacion->titulo = $request->titulo;
        $notificacion->mensaje = $mensaje_notif;
        $notificacion->status = 'Pendiente';
        $notificacion->user_id = $request->asignado_a;
        $notificacion->save();

        $agenda_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;
        $log->tipo_accion = "Inserción";
        $log->tabla = "Agenda";
        $log->id_tabla = $agenda_id;
        $log->bitacora_id = $bitacora_id;
        $log->save();

        return response($agenda);
    }

    public function getAgenda(Request $request)
    {
        if ($request->citas == "all") {
            if(auth()->user()->is_admin || auth()->user()->is_procesos){
                $cita = Agenda::join('users', 'users.id', 'agenda.asignado_a')
                ->select("agenda.id", "agenda.title", "agenda.description", "agenda.start", "agenda.color", "agenda.asignado_a", "agenda.generado_por")
                ->where(function ($query) {
                    $query->where('users.privilegio', 'root')
                    ->orWhere('users.privilegio', 'admin')
                    ->orWhere('users.privilegio', 'procesos')
                    ->orWhere('users.privilegio', 'egresos')
                    ->orWhere('users.privilegio', 'ps_gold')
                    ->orWhere('users.privilegio', 'ps_diamond');
                })->get();
            }else{
                $cita = Agenda::join('users', 'users.id', 'agenda.asignado_a')
                ->select("agenda.id", "agenda.title", "agenda.description", "agenda.start", "agenda.color", "agenda.asignado_a", "agenda.generado_por")
                ->where(function ($query) {
                    $query->where('users.privilegio', 'root')
                    ->orWhere('users.privilegio', 'admin')
                    ->orWhere('users.privilegio', 'procesos')
                    ->orWhere('users.privilegio', 'egresos')
                    ->orWhere('users.privilegio', 'ps_gold')
                    ->orWhere('users.privilegio', 'ps_diamond');
                })
                ->where(function ($query) {
                    $query->where('agenda.asignado_a','=', auth()->user()->id)
                    ->orWhere('agenda.generado_por','=', auth()->user()->id);
                })->get();
            }
        }else if ($request->citas == "asignada_a") {
            $cita = Agenda::where('agenda.asignado_a','=', auth()->user()->id)->get();
        }else if ($request->citas == "generado_por") {
            $cita = Agenda::where('agenda.generado_por','=', auth()->user()->id)->get();
        }        

        return response()->json($cita);
    }

    public function getCita(Request $request)
    {
        $cita = Agenda::find($request->id);

        $cita->date = Carbon::createFromFormat('Y-m-d H:i:s', $cita->start)->format('Y-m-d');
        $cita->hour = Carbon::createFromFormat('Y-m-d H:i:s', $cita->start)->format('H:i:s');

        return response()->json($cita);
    } 

    public function editAgenda(Request $request)
    {
        $agenda = Agenda::find($request->id);

        $agenda->title = $request->titulo;
        $agenda->description = $request->descripcion;
        $agenda->start = $request->fecha . ' ' . $request->hora;
        $agenda->asignado_a = $request->asignado_a;
        $agenda->asignado_a2 = $request->asignado_a2;
        $agenda->color = $request->color;
        $agenda->generado_por = auth()->user()->id;
        $agenda->save();        

        $fecha = Carbon::parse($agenda->start)->formatLocalized('%d de %B de %Y');
        $hora = Carbon::parse($agenda->start)->format('h:i a');

        $user = User::find($request->asignado_a);
        $user2 = User::find($request->asignado_a2);

        if (strlen($request->descripcion) > 0) {
            $descripcion = $request->descripcion;
            $mensaje_notif = $request->descripcion;
        }else{
            $descripcion = "No hay más información para mostrar.";
            $mensaje_notif = $request->titulo;
        }

        Mail::to($user->correo)->send(new AgendaEmail($user->nombre, $fecha, $hora, $request->titulo, $descripcion, "editada"));

        if(strlen($user2) > 0){
            Mail::to($user2->correo)->send(new AgendaEmail($user2->nombre, $fecha, $hora, $request->titulo, $descripcion, "editada"));

            $notificacion = new Notificacion;
            $notificacion->titulo = $request->titulo;
            $notificacion->mensaje = $mensaje_notif;
            $notificacion->status = 'Pendiente';
            $notificacion->user_id = $request->asignado_a2;
            $notificacion->save();
        }

        $notificacion = new Notificacion;
        $notificacion->titulo = $request->titulo;
        $notificacion->mensaje = $mensaje_notif;
        $notificacion->status = 'Pendiente';
        $notificacion->user_id = $request->asignado_a;
        $notificacion->save();

        $agenda_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;
        $log->tipo_accion = "Actualización";
        $log->tabla = "Agenda";
        $log->id_tabla = $agenda_id;
        $log->bitacora_id = $bitacora_id;
        $log->save();

        return response($agenda);
    }
  
    public function deleteAgenda(Request $request)
    {
        $agenda_id = $request->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Eliminación";
        $log->tabla = "Agenda";
        $log->id_tabla = $agenda_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            Agenda::destroy($request->id);
        }
    }
}
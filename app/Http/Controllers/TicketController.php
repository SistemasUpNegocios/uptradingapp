<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Notificacion;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        $user_id = auth()->user()->id;
        $count = 0;
        $tickets_arr_abier = [];
        $tickets_arr_proce = [];
        $tickets_arr_cancel = [];
        $tickets_arr_term = [];
        
        $tickets_abiertos = Ticket::where('status', 'Abierto')->get();
        foreach($tickets_abiertos as $ticket) {
            $asignado_a = $ticket->asignado_a;
            $asignado_a_array = explode(',', $asignado_a);
            foreach($asignado_a_array as $key => $asignado_item) {
                //Si es el último item
                if (!next($asignado_a_array)) {
                    //Como el último item es la fecha, el id es la posición anterior
                    $current_id = $asignado_a_array[$key - 1];
                    if ($user_id == $current_id) {
                        $user_ticket = User::where('id', $user_id);
                        if ($user_ticket->first()) {
                            array_push($tickets_arr_abier, $ticket->id);
                            $count++;
                        }
                    }
                }
            }
        }

        $tickets_procesos = Ticket::where('status', 'En proceso')->get();
        foreach($tickets_procesos as $ticket) {
            $asignado_a = $ticket->asignado_a;
            $asignado_a_array = explode(',', $asignado_a);
            foreach($asignado_a_array as $key => $asignado_item) {
                //Si es el último item
                if (!next($asignado_a_array)) {
                    //Como el último item es la fecha, el id es la posición anterior
                    $current_id = $asignado_a_array[$key - 1];
                    if ($user_id == $current_id) {
                        $user_ticket = User::where('id', $user_id);
                        if ($user_ticket->first()) {
                            array_push($tickets_arr_proce, $ticket->id);
                        }
                    }
                }
            }
        }

        $tickets_cancelados = Ticket::where('status', 'Cancelado')->get();
        foreach($tickets_cancelados as $ticket) {
            $asignado_a = $ticket->asignado_a;
            $asignado_a_array = explode(',', $asignado_a);
            foreach($asignado_a_array as $key => $asignado_item) {
                //Si es el último item
                if (!next($asignado_a_array)) {
                    //Como el último item es la fecha, el id es la posición anterior
                    $current_id = $asignado_a_array[$key - 1];
                    if ($user_id == $current_id) {
                        $user_ticket = User::where('id', $user_id);
                        if ($user_ticket->first()) {
                            array_push($tickets_arr_cancel, $ticket->id);
                        }
                    }
                }
            }
        }

        $tickets_terminados = Ticket::where('status', 'Terminado')->get();
        foreach($tickets_terminados as $ticket) {
            $asignado_a = $ticket->asignado_a;
            $asignado_a_array = explode(',', $asignado_a);
            foreach($asignado_a_array as $key => $asignado_item) {
                //Si es el último item
                if (!next($asignado_a_array)) {
                    //Como el último item es la fecha, el id es la posición anterior
                    $current_id = $asignado_a_array[$key - 1];
                    if ($user_id == $current_id) {
                        $user_ticket = User::where('id', $user_id);
                        if ($user_ticket->first()) {
                            array_push($tickets_arr_term, $ticket->id);
                        }
                    }
                }
            }
        }

        $tickets_user_abiertos = Ticket::join("users", "users.id", "ticket.generado_por")
        ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
        ->whereIn('ticket.id', $tickets_arr_abier)
        ->get();

        $tickets_user_procesos = Ticket::join("users", "users.id", "ticket.generado_por")
        ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
        ->whereIn('ticket.id', $tickets_arr_proce)
        ->get();

        $tickets_user_cancelados = Ticket::join("users", "users.id", "ticket.generado_por")
        ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
        ->whereIn('ticket.id', $tickets_arr_cancel)
        ->get();

        $tickets_user_terminados = Ticket::join("users", "users.id", "ticket.generado_por")
        ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
        ->whereIn('ticket.id', $tickets_arr_term)
        ->get();

        $tickets_generado = Ticket::where('generado_por', auth()->user()->id)->get();

        $data = array(
            "count" => $count,
            "tickets_user_abiertos" => $tickets_user_abiertos,
            "tickets_user_procesos" => $tickets_user_procesos,
            "tickets_user_cancelados" => $tickets_user_cancelados,
            "tickets_user_terminados" => $tickets_user_terminados,
            "tickets_generado" => $tickets_generado,
        );

        return response()->view('ticket.show', $data, 200);
    }

    public function getTabsTickets()
    {
        $user_id = auth()->user()->id;
        $count = 0;
        $tickets_arr_abier = [];
        $tickets_arr_proce = [];
        $tickets_arr_cancel = [];
        $tickets_arr_term = [];
        
        $tickets_abiertos = Ticket::where('status', 'Abierto')->get();
        foreach($tickets_abiertos as $ticket) {
            $asignado_a = $ticket->asignado_a;
            $asignado_a_array = explode(',', $asignado_a);
            foreach($asignado_a_array as $key => $asignado_item) {
                //Si es el último item
                if (!next($asignado_a_array)) {
                    //Como el último item es la fecha, el id es la posición anterior
                    $current_id = $asignado_a_array[$key - 1];
                    if ($user_id == $current_id) {
                        $user_ticket = User::where('id', $user_id);
                        if ($user_ticket->first()) {
                            array_push($tickets_arr_abier, $ticket->id);
                            $count++;
                        }
                    }
                }
            }
        }

        $tickets_procesos = Ticket::where('status', 'En proceso')->get();
        foreach($tickets_procesos as $ticket) {
            $asignado_a = $ticket->asignado_a;
            $asignado_a_array = explode(',', $asignado_a);
            foreach($asignado_a_array as $key => $asignado_item) {
                //Si es el último item
                if (!next($asignado_a_array)) {
                    //Como el último item es la fecha, el id es la posición anterior
                    $current_id = $asignado_a_array[$key - 1];
                    if ($user_id == $current_id) {
                        $user_ticket = User::where('id', $user_id);
                        if ($user_ticket->first()) {
                            array_push($tickets_arr_proce, $ticket->id);
                        }
                    }
                }
            }
        }

        $tickets_cancelados = Ticket::where('status', 'Cancelado')->get();
        foreach($tickets_cancelados as $ticket) {
            $asignado_a = $ticket->asignado_a;
            $asignado_a_array = explode(',', $asignado_a);
            foreach($asignado_a_array as $key => $asignado_item) {
                //Si es el último item
                if (!next($asignado_a_array)) {
                    //Como el último item es la fecha, el id es la posición anterior
                    $current_id = $asignado_a_array[$key - 1];
                    if ($user_id == $current_id) {
                        $user_ticket = User::where('id', $user_id);
                        if ($user_ticket->first()) {
                            array_push($tickets_arr_cancel, $ticket->id);
                        }
                    }
                }
            }
        }

        $tickets_terminados = Ticket::where('status', 'Terminado')->get();
        foreach($tickets_terminados as $ticket) {
            $asignado_a = $ticket->asignado_a;
            $asignado_a_array = explode(',', $asignado_a);
            foreach($asignado_a_array as $key => $asignado_item) {
                //Si es el último item
                if (!next($asignado_a_array)) {
                    //Como el último item es la fecha, el id es la posición anterior
                    $current_id = $asignado_a_array[$key - 1];
                    if ($user_id == $current_id) {
                        $user_ticket = User::where('id', $user_id);
                        if ($user_ticket->first()) {
                            array_push($tickets_arr_term, $ticket->id);
                        }
                    }
                }
            }
        }

        $tickets_user_abiertos = Ticket::join("users", "users.id", "ticket.generado_por")
            ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
            ->whereIn('ticket.id', $tickets_arr_abier)
            ->get();

        $tickets_user_procesos = Ticket::join("users", "users.id", "ticket.generado_por")
            ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
            ->whereIn('ticket.id', $tickets_arr_proce)
            ->get();

        $tickets_user_cancelados = Ticket::join("users", "users.id", "ticket.generado_por")
            ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
            ->whereIn('ticket.id', $tickets_arr_cancel)
            ->get();

        $tickets_user_terminados = Ticket::join("users", "users.id", "ticket.generado_por")
            ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
            ->whereIn('ticket.id', $tickets_arr_term)
            ->get();

        $tickets_generado = Ticket::where('generado_por', auth()->user()->id)->get();

        $data = array(
            "count" => $count,
            "tickets_user_abiertos" => $tickets_user_abiertos,
            "tickets_user_procesos" => $tickets_user_procesos,
            "tickets_user_cancelados" => $tickets_user_cancelados,
            "tickets_user_terminados" => $tickets_user_terminados,
            "tickets_generado" => $tickets_generado,
        );

        return response()->view('ticket.tab', $data, 200);
    }

    public function getUsuariosTickets(Request $request)
    {
        if($request->privilegio == 'Administración') {
            $usuarios = User::select("id", "nombre", "apellido_p")
                ->where("id", "!=", auth()->user()->id)
                ->where(function ($query) {
                    $query->where('privilegio', 'admin')
                    ->orWhere('privilegio', "procesos");
                })->get();
            return response($usuarios);
        }elseif($request->privilegio == 'Sistemas') {
            $usuarios = User::select("id", "nombre", "apellido_p")
                ->where('id', 1)
                ->where("id", "!=", auth()->user()->id)
                ->get();
            return response($usuarios);
        }elseif($request->privilegio == 'Contabilidad') {
            $usuarios = User::select("id", "nombre", "apellido_p")
                ->where('privilegio', 'contabilidad')
                ->where("id", "!=", auth()->user()->id)
                ->get();
            return response($usuarios);
        }elseif($request->privilegio == 'Egresos') {
            $usuarios = User::select("id", "nombre", "apellido_p")
                ->where('privilegio', 'egresos')
                ->where("id", "!=", auth()->user()->id)
                ->get();
            return response($usuarios);
        }elseif($request->privilegio == 'edit_user') {
            $usuarios = User::select("id", "nombre", "apellido_p")->where('id', $request->id)->get();
            return response($usuarios);
        }
    }

    public function getAsignadosTickets(Request $request)
    {
        $array_nombre = [];
        $array_fecha = [];
        $ticket = Ticket::find($request->id);
        $asignado_a = $ticket->asignado_a;
        $asignado_a_array = explode(',', $asignado_a);
        foreach($asignado_a_array as $asignado_item) {
            if (is_numeric($asignado_item)) {
                $user = User::find($asignado_item);
                array_push($array_nombre, $user->nombre . ' ' . $user->apellido_p);
            }else{
                array_push($array_fecha, $asignado_item);
            }
        }

        return response()->json(['nombre' => $array_nombre, 'fecha' => $array_fecha]);

    }

    public function addTicket(Request $request)
    {
        if ($request->ajax()) {

            $ticket = new Ticket;
            $ticket->generado_por = auth()->user()->id;
            $ticket->asignado_a = $request->asignado_a . ',' . Carbon::now()->toDateTimeString();
            $ticket->fecha_generado = Carbon::now()->toDateTimeString();
            $ticket->fecha_limite = $request->fecha_limite;
            $ticket->departamento = $request->departamento;
            $ticket->asunto = $request->asunto;
            $ticket->descripcion = $request->descripcion;
            $ticket->status = "Abierto";
            $ticket->save();

            $ticket_id = $ticket->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Inserción";
            $log->tabla = "Ticket";
            $log->id_tabla = $ticket_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                $notificacion = new Notificacion;
                $notificacion->titulo = "Ticket abierto";
                $notificacion->mensaje = "Tienes un nuevo ticket abierto con asunto: $request->asunto";
                $notificacion->status = "Pendiente";
                $notificacion->user_id = $request->asignado_a;
                $notificacion->save();

                return response($ticket);
            }
        }
    }

    public function editTicket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->departamento = $request->departamento;
        $ticket->generado_por = auth()->user()->id;
        $ticket->fecha_limite = $request->fecha_limite;
        $ticket->asunto = $request->asunto;
        $ticket->descripcion = $request->descripcion;
        $ticket->save();

        $ticket_id = $ticket->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Actualización";
        $log->tabla = "Ticket";
        $log->id_tabla = $ticket_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            return response($ticket);
        }
    }

    public function editStatusTicket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->status = $request->status;
        $ticket->save();

        $ticket_id = $ticket->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Actualización";
        $log->tabla = "Ticket";
        $log->id_tabla = $ticket_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            return response($ticket);
        }
    }

    public function traspasarTicket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $ticket->asignado_a = $ticket->asignado_a.','.$request->asignado_a.','.Carbon::now()->toDateTimeString();

        $notificacion = new Notificacion;
        $notificacion->titulo = "Traspaso de ticket";
        $notificacion->mensaje = "Te traspasaron un ticket con asunto: $ticket->asunto";
        $notificacion->status = "Pendiente";
        $notificacion->user_id = $request->asignado_a;
        $notificacion->save();

        $ticket->save();

        $ticket_id = $ticket->id;
        $bitacora_id = session('bitacora_id');

        $log = new Log;

        $log->tipo_accion = "Actualización";
        $log->tabla = "Ticket";
        $log->id_tabla = $ticket_id;
        $log->bitacora_id = $bitacora_id;

        if ($log->save()) {
            

            return response($ticket);
        }
    }

    public function getTicketsAlerta(Request $request)
    {
        $id = auth()->user()->id;
        $tickets = Ticket::where('fecha_limite', '<=', Carbon::now()->addDays(2)->toDateTimeString())
            ->where('fecha_limite', '>=', Carbon::now()->toDateTimeString())
            ->where('asignado_a', 'like', "%,$id,%")
            ->where(function ($query) {
                $query->where('status', 'Abierto')
                ->orWhere('status', 'En proceso');
            })->orderBy("status", "asc")
            ->get();

        if (sizeof($tickets) <= 0) {
            $tickets = [];            
        }

        return response($tickets);
    }

    public function getTicketsAbiertos(Request $request)
    {
        $id = auth()->user()->id;
        $tickets = Ticket::where('status', 'Abierto')->where('asignado_a', 'like', "%,$id,%")->count();

        return response($tickets);
    }
}
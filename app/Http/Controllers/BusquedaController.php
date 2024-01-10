<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusquedaController extends Controller
{
    public function buscarCliente(Request $request)
    {
        if ($request->ajax()) {
            $codigo = session("codigo_oficina");
            $query = $request->input('query');

            $clientes = Cliente::
            whereRaw("CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%" . $query . "%'")
                ->orderByRaw(
                    "CASE
                        WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '$query%' THEN 1
                        WHEN CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) LIKE '%$query' THEN 3
                    ELSE 2
                    END"
                )->where("codigoCliente", "like", "MXN-$codigo%")
                ->get();

            if ($clientes->first()) {
                return response()->view('busqueda.resultados', compact('clientes', 'query'), 200);
            } else {
                return response($query, 500);
            }
        }
    }

    public function buscarTicket(Request $request)
    {
        $query_ticket = $request->query_ticket;
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
            ->where(function ($query) use ($query_ticket) {
                $query->where("asunto", "like", "%$query_ticket%")
                ->orWhere("descripcion", "like", "%$query_ticket%");
            })
            ->whereIn('ticket.id', $tickets_arr_abier)
            ->get();

        $tickets_user_procesos = Ticket::join("users", "users.id", "ticket.generado_por")
            ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
            ->where(function ($query) use ($query_ticket) {
                $query->where("asunto", "like", "%$query_ticket%")
                ->orWhere("descripcion", "like", "%$query_ticket%");
            })
            ->whereIn('ticket.id', $tickets_arr_proce)
            ->get();

        $tickets_user_cancelados = Ticket::join("users", "users.id", "ticket.generado_por")
            ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
            ->where(function ($query) use ($query_ticket) {
                $query->where("asunto", "like", "%$query_ticket%")
                ->orWhere("descripcion", "like", "%$query_ticket%");
            })
            ->whereIn('ticket.id', $tickets_arr_cancel)
            ->get();

        $tickets_user_terminados = Ticket::join("users", "users.id", "ticket.generado_por")
            ->select(DB::raw("ticket.id as ticketid, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS usuarionombre, ticket.fecha_generado, ticket.asignado_a, ticket.fecha_limite, ticket.departamento, ticket.asunto, ticket.descripcion, ticket.status"))
            ->where(function ($query) use ($query_ticket) {
                $query->where("asunto", "like", "%$query_ticket%")
                ->orWhere("descripcion", "like", "%$query_ticket%");
            })
            ->whereIn('ticket.id', $tickets_arr_term)
            ->get();

        $tickets_generado = Ticket::where('generado_por', auth()->user()->id)
            ->where('archivado', 'no')
            ->where(function ($query) use ($query_ticket) {
                $query->where("asunto", "like", "%$query_ticket%")
                ->orWhere("descripcion", "like", "%$query_ticket%");
            })
            ->orderBy("id", "DESC")
            ->get();

        $tickets_archivado = Ticket::where('generado_por', auth()->user()->id)
            ->where('archivado', 'si')
            ->where(function ($query) use ($query_ticket) {
                $query->where("asunto", "like", "%$query_ticket%")
                ->orWhere("descripcion", "like", "%$query_ticket%");
            })
            ->orderBy("id", "DESC")
            ->get();

        $tickets_todo = Ticket::select()
            ->where(function ($query) use ($query_ticket) {
                $query->where("asunto", "like", "%$query_ticket%")
                ->orWhere("descripcion", "like", "%$query_ticket%");
            })
            ->orderBy("id", "DESC")
            ->get();

        $data = array(
            "count" => $count,
            "tickets_user_abiertos" => $tickets_user_abiertos,
            "tickets_user_procesos" => $tickets_user_procesos,
            "tickets_user_cancelados" => $tickets_user_cancelados,
            "tickets_user_terminados" => $tickets_user_terminados,
            "tickets_generado" => $tickets_generado,
            "tickets_archivado" => $tickets_archivado,
            "tickets_todo" => $tickets_todo,
        );

        return response()->view('ticket.tab', $data, 200);
    }
}

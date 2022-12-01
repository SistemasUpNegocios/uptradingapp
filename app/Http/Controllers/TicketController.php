<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth.admin');
    }

    public function index()
    {
        $tickets_abiertos = Ticket::where('status', 'Abierto')
        ->get();

        $user_id = auth()->user()->id;

        $count = 0;

        $tickets_arr = [];

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
                            array_push($tickets_arr, $ticket->id);
                            $count++;
                        }
                    }
                }
            }
        }

        $users = User::whereIn('privilegio', ['root', 'admin', 'procesos', 'ps_encargado'])
        ->orderBy('apellido_p')
        ->get();

        $tickets_user_abiertos = Ticket::whereIn('id', $tickets_arr)->get();

        $tickets_cerrados = Ticket::where('status', 'cerrado')->get();

        return response()->view('ticket.show', compact('users', 'count', 'tickets_user_abiertos'));
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
                return response($ticket);
            }
        }
    }
}
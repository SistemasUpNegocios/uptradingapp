<?php

namespace App\Http\Controllers;

use App\Models\Notificacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {

        $notificacionesList = DB::table('notificacion')
        ->join('users', 'users.id', '=', 'notificacion.user_id')
        ->select(DB::raw("notificacion.id, notificacion.titulo, notificacion.mensaje, notificacion.status, notificacion.created_at, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS nombreUser, users.id AS userId"))
        ->where('user_id', auth()->user()->id)
        ->orderBy('notificacion.id', 'DESC')
        ->get();

        return view('notificacion.show', compact("notificacionesList"));

    }

    public function getNotificaciones()
    {
        $notificaciones = DB::table('notificacion')
            ->join('users', 'users.id', '=', 'notificacion.user_id')
            ->select(DB::raw("notificacion.id, notificacion.titulo, notificacion.mensaje, notificacion.status, notificacion.created_at, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS nombreUser, notificacion.user_id"))
            ->where('user_id', auth()->user()->id)
            ->where('status', 'Pendiente')
            ->get();

        $notificacionesCount = DB::table('notificacion')
            ->join('users', 'users.id', '=', 'notificacion.user_id')
            ->select()
            ->where('user_id', auth()->user()->id)
            ->where('status', 'Pendiente')
            ->count();

        $fechaNotif = array();

        foreach($notificaciones as $notificacion){

            $fechaNotif[] = \Carbon\Carbon::parse($notificacion->created_at)->diffForHumans();

        }


        return response(['notificaciones' => $notificaciones, 'notificacionesCount' => $notificacionesCount, "fecha" => $fechaNotif]);
    }

    public function editNotificaciones(Request $request)
    {
        $notificacionesU = DB::table('notificacion')
            ->where("user_id", "=", auth()->user()->id)
            ->update(["status" => $request->status]);

        return response($notificacionesU);
    }

    public function editNotificacion(Request $request)
    {
        $notificacionesO = DB::table('notificacion')
            ->where("id", "=", $request->id)
            ->update(["status" => $request->status]);

        return response($notificacionesO);
    }

    public function deleteNotificaciones(Request $request)
    {
        if ($request->ajax())
        {
            Notificacion::destroy($request->id);

            $notificaciones = DB::table('notificacion')
            ->join('users', 'users.id', '=', 'notificacion.user_id')
            ->select(DB::raw("notificacion.id, notificacion.titulo, notificacion.mensaje, notificacion.status, notificacion.created_at, CONCAT(users.nombre, ' ', users.apellido_p, ' ', users.apellido_m) AS nombreUser, users.id AS userId"))
            ->where('user_id', auth()->user()->id)
            ->orderBy('notificacion.id', 'DESC')
            ->get();

            $fechaNotif = array();

            foreach($notificaciones as $notificacion){
                $fechaNotif[] = \Carbon\Carbon::parse($notificacion->created_at)->diffForHumans();
            }

            return response(["notificaciones" => $notificaciones, "fecha" => $fechaNotif]);
        }
    }
}
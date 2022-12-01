<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Events\Chat;
use App\Models\Notificacion;
use App\Models\Message;

class MessageController extends Controller
{

	public function __construct()
    {        
        $this->middleware('auth.admin');
    }
    
	public function sent(Request $request)
	{

		$message = auth()->user()->messages()->create([
			'content' => $request->message,
			'chat_id' => $request->chat_id,
		])->load('user');

		$enviado_a = Message::join('chat_user', 'chat_user.chat_id', 'messages.chat_id')
					->select("chat_user.user_id")
					->where("chat_user.user_id", "!=", auth()->user()->id)
					->first();
					
		$enviado_por = ucwords(strtolower( auth()->user()->nombre . " " . auth()->user()->apellido_p . " " . auth()->user()->apellido_m));

		$mensaje = "Tienes un nuevo mensaje de $enviado_por: $request->message";

		$notificacion = new Notificacion;
        $notificacion->titulo = "Mensaje de $enviado_por";
        $notificacion->mensaje = $mensaje;
        $notificacion->status = 'Pendiente';
        $notificacion->user_id = $enviado_a->user_id;
        $notificacion->save();

		broadcast(new MessageSent($message))->toOthers();

		$imagen = auth()->user()->foto_perfil;
		event(new Chat($mensaje, $imagen));

		return $message;

	}

}
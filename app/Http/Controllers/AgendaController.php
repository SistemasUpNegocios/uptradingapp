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
use Google_Client;

class AgendaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }
    
    public function index()
    {
        if(auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos){        
            $users = User::where('privilegio', 'root')
                    ->orWhere('privilegio', 'admin')
                    ->orWhere('privilegio', 'procesos')
                    ->get();
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

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        $mensaje = "<!DOCTYPE html>
                    <html lang='es'>
                        <head>
                            <meta charset='UTF-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                            <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                            <link href='https://fonts.gstatic.com' rel='preconnect'>
                            <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i' rel='stylesheet'>
                            <link href='https://fonts.googleapis.com/css2?family=Anton&display=swap' rel='stylesheet'>
                            <title>AGENDA</title>
                            <style>
                                body{
                                    margin: 0;
                                    padding: 0;
                                }

                                p {
                                    color: #404040;
                                }
                        
                                ::-webkit-scrollbar {
                                    width: 8px;
                                }
                        
                                ::-webkit-scrollbar-track {
                                    background: #fff;
                                }
                        
                                ::-webkit-scrollbar-thumb {
                                    background: #232b35;
                                }
                        
                                ::-webkit-scrollbar-thumb:hover {
                                    background: #1d242c;
                                }
                        
                                .contenedor{
                                    width: 100%;
                                    overflow-x: hidden;
                                }
                        
                                .header{
                                    background-color: #2fb5cc;
                                    color: #000000;
                                }
                        
                                .header .header_contenido{
                                    width: 100%;
                                    padding-left: 5px;
                                    height: 4.5rem;
                                    display: flex;
                                    align-items: center;
                                }
                        
                                .header .header_contenido img {
                                    display: block; 
                                    height: 3.5rem; 
                                    border: 0; 
                                    padding-left: 5px;
                                    padding-top: 5px;
                                }
                        
                                .contenido{
                                    background-color: #FFFFFF; 
                                    color: #000000; 
                                    margin: auto;
                                }
                        
                                .contenido_mensaje {
                                    mso-table-lspace: 0pt; 
                                    mso-table-rspace: 0pt; 
                                    font-weight: 400; 
                                    vertical-align: top;
                                    padding-top: 40px; 
                                    padding-bottom: 20px; 
                                    border-top: 0px; 
                                    border-right: 0px; 
                                    border-bottom: 0px; 
                                    border-left: 0px;
                                }
                        
                                .contenido_mensaje_texto{
                                    padding-bottom: 30px;
                                    padding-left: 50px;
                                    padding-right: 50px;
                                    font-size: 12px; 
                                    font-family: Open Sans, Tahoma, Verdana, Segoe, sans-serif; 
                                    color: #404040;
                                    line-height: 1.5;
                                }
                        
                                .contenido_mensaje_texto p {
                                    margin: 0; font-size: 14px;
                                }
                        
                                .contenido_mensaje_texto p span{
                                    font-size:18px;
                                    font-weight: bold;
                                }
                                            
                                .contenido_mensaje hr{
                                    height: 1px;
                                    margin-left: 20px;                         
                                    margin-right: 20px;
                                    background-color: #404040;
                                }
                        
                                .contenido_imagen{
                                    padding: 5px 20px 20px 20px;
                                    line-height: 10px; 
                                    display: flex;
                                }
                        
                                .contenido_imagen img{
                                    display: block; 
                                    height: auto; 
                                    border: 0; 
                                    width: 96px; 
                                    max-width: 100%;
                                }
                                .contenido_imagen_info{
                                    padding-top: 5px;
                                    padding-bottom: 20px;
                                    margin-left: 15px;
                                    font-size: 12px;
                                    font-family: Ubuntu, Tahoma, Verdana, Segoe, sans-serif; 
                                    color: #404040;
                                    line-height: 1.5;
                                }
                        
                                .contenido_imagen_info p {
                                    margin: 0;
                                    font-size: 14px; 
                                    text-align: left;
                                }
                        
                                .footer{
                                    background-color: #404040;                                                  
                                    margin: auto;
                                }
                                .footer_imagen {
                                    text-align: left; 
                                    font-weight: 400; 
                                    vertical-align: top; 
                                    padding: 25px 0px 15px 30px;
                                    line-height:10px;
                                }
                                .footer_imagen img {
                                    display: block; height: auto; border: 0; width: 155px; max-width: 100%;
                                }
                        
                                .footer_redes {
                                    text-align: left; 
                                    font-weight: 400; 
                                    vertical-align: top; 
                                    padding: 0px 5px 15px 20px;
                                }
                        
                                .footer_redes a {
                                    text-decoration: none;
                                    margin-left: 2px;
                                }
                        
                                .footer_direccion {
                                    padding: 15px 10px 25px 30px;
                                    font-size: 12px; 
                                    font-family: Ubuntu, Tahoma, Verdana, Segoe, sans-serif; 
                                    color: #999999; 
                                    line-height: 1.2;
                                }

                                @media (max-width: 500px) {
                                    .contenido_mensaje_texto{
                                        padding-left: 0px;
                                        padding-right: 0px;
                                    }
                                    .contenido_mensaje_texto__info{
                                        padding-left: 10px;
                                        padding-right: 10px;
                                        text-align: justify;
                                    }                                   
                                }
                            </style>
                        </head>
                        <body>
                            <div class='contenedor'>
                                <div class='header'>
                                    <div class='header_contenido'>
                                        <img src='https://uptradingexperts.com/assets/images/logoblanco.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                    </div>
                                </div>
                                <div class='contenido'>
                                    <div class='contenido_mensaje'>
                                        <div class='contenido_mensaje_texto'>
                                            <div class='contenido_mensaje_texto__info'>
                                                <p color: #404040;'>
                                                    Buenos días <b>$user->nombre</b>, me complace informarle que le han agendado una cita para el día <b>$fecha a las $hora</b>.
                                                </p>
                                                <br />
                                                <br />
                                                <p color: #404040;'>
                                                    <b>Asunto:</b>
                                                    <br />
                                                    $request->titulo.
                                                </p>
                                                <br />
                                                <p color: #404040;'>
                                                    <b>Más información acerca de la cita:</b>
                                                    <br />
                                                    $descripcion.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <br />
                                    <br />
                                    <br />
                                    <div class='contenido_imagen'>
                                        <div>
                                            <img src='https://admin.uptradingexperts.com/img/uplogopng.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                        </div>   
                                        <div class='contenido_imagen_info'>
                                            <p><strong style='color: #000000;'>Up Trading Experts</strong></p>
                                            <p>Equipo</p>
                                            <p><a title='sistemas@upnegocios.com' href='mailto:sistemas@upnegocios.com'>sistemas@upnegocios.com</a>
                                            </p>
                                            <br>
                                        </div>                
                                    </div>
                                </div>
                                <div class='footer'>
                                    <div class='footer_imagen'>
                                        <img src='https://admin.uptradingexperts.com/img/logo_latam.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                    </div>
                                    <div class='footer_redes'>
                                        <a href='https://www.facebook.com/UpTradingExperts/' target='_blank'>
                                            <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/facebook@2x.png' width='32' height='32' alt='Facebook' title='Facebook'>
                                        </a>                                    
                                        <a href='https://www.instagram.com/uptradingexperts/' target='_blank'>
                                            <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/instagram@2x.png' width='32' height='32' alt='Instagram' title='Instagram'>
                                        </a>
                                    </div>
                                    <div class='footer_direccion'>                  
                                        <p style='margin: 0; font-size: 12px; text-align: left; color: #999999;'>
                                            <strong>Up Trading Experts</strong>
                                            <br>Torre V1 - Av. Universidad #234.<br>
                                            Fracc. Lomas del Guadiana, Interior #308, C.P. 34138, Durango, Dgo. México.
                                        </p>                
                                    </div>
                                </div>
                            </div>
                        </body>
                    </html>";

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = env('MAILER_HOST');                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = env('MAILER_USERNAME');                     //SMTP username
            $mail->Password   = env('MAILER_PASS');                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = env('MAILER_PORT');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('mensajes@uptradingexperts.com', 'Sistemas Up Trading Experts');
            $mail->addAddress($user->correo, "$user->nombre $user->apellido_p $user->apellido_m");     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'CITA AGENDADA';
            $mail->Body    = $mensaje;
                

            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        if(strlen($user2) > 0){

            $mensaje = "<!DOCTYPE html>
                        <html lang='es'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                                <link href='https://fonts.gstatic.com' rel='preconnect'>
                                <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i' rel='stylesheet'>
                                <link href='https://fonts.googleapis.com/css2?family=Anton&display=swap' rel='stylesheet'>
                                <title>AGENDA</title>
                                <style>
                                    body{
                                        margin: 0;
                                        padding: 0;
                                    }
    
                                    p {
                                        color: #404040;
                                    }
                            
                                    ::-webkit-scrollbar {
                                        width: 8px;
                                    }
                            
                                    ::-webkit-scrollbar-track {
                                        background: #fff;
                                    }
                            
                                    ::-webkit-scrollbar-thumb {
                                        background: #232b35;
                                    }
                            
                                    ::-webkit-scrollbar-thumb:hover {
                                        background: #1d242c;
                                    }
                            
                                    .contenedor{
                                        width: 100%;
                                        overflow-x: hidden;
                                    }
                            
                                    .header{
                                        background-color: #2fb5cc;
                                        color: #000000;
                                    }
                            
                                    .header .header_contenido{
                                        width: 100%;
                                        padding-left: 5px;
                                        height: 4.5rem;
                                        display: flex;
                                        align-items: center;
                                    }
                            
                                    .header .header_contenido img {
                                        display: block; 
                                        height: 3.5rem; 
                                        border: 0; 
                                        padding-left: 5px;
                                        padding-top: 5px;
                                    }
                            
                                    .contenido{
                                        background-color: #FFFFFF; 
                                        color: #000000; 
                                        margin: auto;
                                    }
                            
                                    .contenido_mensaje {
                                        mso-table-lspace: 0pt; 
                                        mso-table-rspace: 0pt; 
                                        font-weight: 400; 
                                        vertical-align: top;
                                        padding-top: 40px; 
                                        padding-bottom: 20px; 
                                        border-top: 0px; 
                                        border-right: 0px; 
                                        border-bottom: 0px; 
                                        border-left: 0px;
                                    }
                            
                                    .contenido_mensaje_texto{
                                        padding-bottom: 30px;
                                        padding-left: 50px;
                                        padding-right: 50px;
                                        font-size: 12px; 
                                        font-family: Open Sans, Tahoma, Verdana, Segoe, sans-serif; 
                                        color: #404040;
                                        line-height: 1.5;
                                    }
                            
                                    .contenido_mensaje_texto p {
                                        margin: 0; font-size: 14px;
                                    }
                            
                                    .contenido_mensaje_texto p span{
                                        font-size:18px;
                                        font-weight: bold;
                                    }
                                                
                                    .contenido_mensaje hr{
                                        height: 1px;
                                        margin-left: 20px;                         
                                        margin-right: 20px;
                                        background-color: #404040;
                                    }
                            
                                    .contenido_imagen{
                                        padding: 5px 20px 20px 20px;
                                        line-height: 10px; 
                                        display: flex;
                                    }
                            
                                    .contenido_imagen img{
                                        display: block; 
                                        height: auto; 
                                        border: 0; 
                                        width: 96px; 
                                        max-width: 100%;
                                    }
                                    .contenido_imagen_info{
                                        padding-top: 5px;
                                        padding-bottom: 20px;
                                        margin-left: 15px;
                                        font-size: 12px;
                                        font-family: Ubuntu, Tahoma, Verdana, Segoe, sans-serif; 
                                        color: #404040;
                                        line-height: 1.5;
                                    }
                            
                                    .contenido_imagen_info p {
                                        margin: 0;
                                        font-size: 14px; 
                                        text-align: left;
                                    }
                            
                                    .footer{
                                        background-color: #404040;                                                  
                                        margin: auto;
                                    }
                                    .footer_imagen {
                                        text-align: left; 
                                        font-weight: 400; 
                                        vertical-align: top; 
                                        padding: 25px 0px 15px 30px;
                                        line-height:10px;
                                    }
                                    .footer_imagen img {
                                        display: block; height: auto; border: 0; width: 155px; max-width: 100%;
                                    }
                            
                                    .footer_redes {
                                        text-align: left; 
                                        font-weight: 400; 
                                        vertical-align: top; 
                                        padding: 0px 5px 15px 20px;
                                    }
                            
                                    .footer_redes a {
                                        text-decoration: none;
                                        margin-left: 2px;
                                    }
                            
                                    .footer_direccion {
                                        padding: 15px 10px 25px 30px;
                                        font-size: 12px; 
                                        font-family: Ubuntu, Tahoma, Verdana, Segoe, sans-serif; 
                                        color: #999999; 
                                        line-height: 1.2;
                                    }
    
                                    @media (max-width: 500px) {
                                        .contenido_mensaje_texto{
                                            padding-left: 0px;
                                            padding-right: 0px;
                                        }
                                        .contenido_mensaje_texto__info{
                                            padding-left: 10px;
                                            padding-right: 10px;
                                            text-align: justify;
                                        }                                   
                                    }
                                </style>
                            </head>
                            <body>
                                <div class='contenedor'>
                                    <div class='header'>
                                        <div class='header_contenido'>
                                            <img src='https://uptradingexperts.com/assets/images/logoblanco.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                        </div>
                                    </div>
                                    <div class='contenido'>
                                        <div class='contenido_mensaje'>
                                            <div class='contenido_mensaje_texto'>
                                                <div class='contenido_mensaje_texto__info'>
                                                    <p color: #404040;'>
                                                        Buenos días <b>$user2->nombre</b>, me complace informarle que le han agendado una cita para el día <b>$fecha a las $hora</b>.
                                                    </p>
                                                    <br />
                                                    <br />
                                                    <p color: #404040;'>
                                                        <b>Asunto:</b>
                                                        <br />
                                                        $request->titulo.
                                                    </p>
                                                    <br />
                                                    <p color: #404040;'>
                                                        <b>Más información acerca de la cita:</b>
                                                        <br />
                                                        $descripcion.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <br />
                                        <br />
                                        <div class='contenido_imagen'>
                                            <div>
                                                <img src='https://admin.uptradingexperts.com/img/uplogopng.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                            </div>   
                                            <div class='contenido_imagen_info'>
                                                <p><strong style='color: #000000;'>Up Trading Experts</strong></p>
                                                <p>Equipo</p>
                                                <p><a title='sistemas@upnegocios.com' href='mailto:sistemas@upnegocios.com'>sistemas@upnegocios.com</a>
                                                </p>
                                                <br>
                                            </div>                
                                        </div>
                                    </div>
                                    <div class='footer'>
                                        <div class='footer_imagen'>
                                            <img src='https://admin.uptradingexperts.com/img/logo_latam.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                        </div>
                                        <div class='footer_redes'>
                                            <a href='https://www.facebook.com/UpTradingExperts/' target='_blank'>
                                                <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/facebook@2x.png' width='32' height='32' alt='Facebook' title='Facebook'>
                                            </a>                                    
                                            <a href='https://www.instagram.com/uptradingexperts/' target='_blank'>
                                                <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/instagram@2x.png' width='32' height='32' alt='Instagram' title='Instagram'>
                                            </a>
                                        </div>
                                        <div class='footer_direccion'>                  
                                            <p style='margin: 0; font-size: 12px; text-align: left; color: #999999;'>
                                                <strong>Up Trading Experts</strong>
                                                <br>Torre V1 - Av. Universidad #234.<br>
                                                Fracc. Lomas del Guadiana, Interior #308, C.P. 34138, Durango, Dgo. México.
                                            </p>                
                                        </div>
                                    </div>
                                </div>
                            </body>
                        </html>";
    
            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = env('MAILER_HOST');                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = env('MAILER_USERNAME');                     //SMTP username
                $mail->Password   = env('MAILER_PASS');                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = env('MAILER_PORT');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    
                //Recipients
                $mail->setFrom('mensajes@uptradingexperts.com', 'Sistemas Up Trading Experts');
                $mail->addAddress($user2->correo, "$user2->nombre $user2->apellido_p $user2->apellido_m");     //Add a recipient
    
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'CITA AGENDADA';
                $mail->Body    = $mensaje;
                    
    
                $mail->send();
    
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

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
            $cita = Agenda::join('users', 'users.id', 'agenda.asignado_a')
            ->select("agenda.id", "agenda.title", "agenda.description", "agenda.start", "agenda.color", "agenda.asignado_a", "agenda.generado_por")
            ->where('agenda.generado_por','=', auth()->user()->id)
            ->orWhere('users.privilegio', 'root')
            ->orWhere('users.privilegio', 'admin')
            ->orWhere('users.privilegio', 'procesos')
            ->get();
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

        $mail = new PHPMailer(true);
        $mail->CharSet = "UTF-8";

        $mensaje = "<!DOCTYPE html>
                        <html lang='es'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                                <link href='https://fonts.gstatic.com' rel='preconnect'>
                                <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i' rel='stylesheet'>
                                <link href='https://fonts.googleapis.com/css2?family=Anton&display=swap' rel='stylesheet'>
                                <title>AGENDA</title>
                                <style>
                                    body{
                                        margin: 0;
                                        padding: 0;
                                    }

                                    p {
                                        color: #404040;
                                    }
                            
                                    ::-webkit-scrollbar {
                                        width: 8px;
                                    }
                            
                                    ::-webkit-scrollbar-track {
                                        background: #fff;
                                    }
                            
                                    ::-webkit-scrollbar-thumb {
                                        background: #232b35;
                                    }
                            
                                    ::-webkit-scrollbar-thumb:hover {
                                        background: #1d242c;
                                    }
                            
                                    .contenedor{
                                        width: 100%;
                                        overflow-x: hidden;
                                    }
                            
                                    .header{
                                        background-color: #2fb5cc;
                                        color: #000000;
                                    }
                            
                                    .header .header_contenido{
                                        width: 100%;
                                        padding-left: 5px;
                                        height: 4.5rem;
                                        display: flex;
                                        align-items: center;
                                    }
                            
                                    .header .header_contenido img {
                                        display: block; 
                                        height: 3.5rem; 
                                        border: 0; 
                                        padding-left: 5px;
                                        padding-top: 5px;
                                    }
                            
                                    .contenido{
                                        background-color: #FFFFFF; 
                                        color: #000000; 
                                        margin: auto;
                                    }
                            
                                    .contenido_mensaje {
                                        mso-table-lspace: 0pt; 
                                        mso-table-rspace: 0pt; 
                                        font-weight: 400; 
                                        vertical-align: top;
                                        padding-top: 40px; 
                                        padding-bottom: 20px; 
                                        border-top: 0px; 
                                        border-right: 0px; 
                                        border-bottom: 0px; 
                                        border-left: 0px;
                                    }
                            
                                    .contenido_mensaje_texto{
                                        padding-bottom: 30px;
                                        padding-left: 50px;
                                        padding-right: 50px;
                                        font-size: 12px; 
                                        font-family: Open Sans, Tahoma, Verdana, Segoe, sans-serif; 
                                        color: #404040;
                                        line-height: 1.5;
                                    }
                            
                                    .contenido_mensaje_texto p {
                                        margin: 0; font-size: 14px;
                                    }
                            
                                    .contenido_mensaje_texto p span{
                                        font-size:18px;
                                        font-weight: bold;
                                    }
                                                
                                    .contenido_mensaje hr{
                                        height: 1px;
                                        margin-left: 20px;                         
                                        margin-right: 20px;
                                        background-color: #404040;
                                    }
                            
                                    .contenido_imagen{
                                        padding: 5px 20px 20px 20px;
                                        line-height: 10px; 
                                        display: flex;
                                    }
                            
                                    .contenido_imagen img{
                                        display: block; 
                                        height: auto; 
                                        border: 0; 
                                        width: 96px; 
                                        max-width: 100%;
                                    }
                                    .contenido_imagen_info{
                                        padding-top: 5px;
                                        padding-bottom: 20px;
                                        margin-left: 15px;
                                        font-size: 12px;
                                        font-family: Ubuntu, Tahoma, Verdana, Segoe, sans-serif; 
                                        color: #404040;
                                        line-height: 1.5;
                                    }
                            
                                    .contenido_imagen_info p {
                                        margin: 0;
                                        font-size: 14px; 
                                        text-align: left;
                                    }
                            
                                    .footer{
                                        background-color: #404040;                                                  
                                        margin: auto;
                                    }
                                    .footer_imagen {
                                        text-align: left; 
                                        font-weight: 400; 
                                        vertical-align: top; 
                                        padding: 25px 0px 15px 30px;
                                        line-height:10px;
                                    }
                                    .footer_imagen img {
                                        display: block; height: auto; border: 0; width: 155px; max-width: 100%;
                                    }
                            
                                    .footer_redes {
                                        text-align: left; 
                                        font-weight: 400; 
                                        vertical-align: top; 
                                        padding: 0px 5px 15px 20px;
                                    }
                            
                                    .footer_redes a {
                                        text-decoration: none;
                                        margin-left: 2px;
                                    }
                            
                                    .footer_direccion {
                                        padding: 15px 10px 25px 30px;
                                        font-size: 12px; 
                                        font-family: Ubuntu, Tahoma, Verdana, Segoe, sans-serif; 
                                        color: #999999; 
                                        line-height: 1.2;
                                    }

                                    @media (max-width: 500px) {
                                        .contenido_mensaje_texto{
                                            padding-left: 0px;
                                            padding-right: 0px;
                                        }
                                        .contenido_mensaje_texto__info{
                                            padding-left: 10px;
                                            padding-right: 10px;
                                            text-align: justify;
                                        }                                   
                                    }
                                </style>
                            </head>
                            <body>
                                <div class='contenedor'>
                                    <div class='header'>
                                        <div class='header_contenido'>
                                            <img src='https://uptradingexperts.com/assets/images/logoblanco.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                        </div>
                                    </div>
                                    <div class='contenido'>
                                        <div class='contenido_mensaje'>
                                            <div class='contenido_mensaje_texto'>
                                                <div class='contenido_mensaje_texto__info'>
                                                    <p color: #404040;'>
                                                        Buenos días <b>$user->nombre</b>, para comentarle que se le ha actualizado la cita '$request->titulo', para el día <b>$fecha a las $hora</b>.
                                                    </p>
                                                    <br />
                                                    <br />
                                                    <p color: #404040;'>
                                                        <b>Asunto:</b>
                                                        <br />
                                                        $request->titulo.
                                                    </p>
                                                    <br />
                                                    <p color: #404040;'>
                                                        <b>Más información acerca de la cita:</b>
                                                        <br />
                                                        $request->descripcion.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <br />
                                        <br />
                                        <div class='contenido_imagen'>
                                            <div>
                                                <img src='https://admin.uptradingexperts.com/img/uplogopng.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                            </div>   
                                            <div class='contenido_imagen_info'>
                                                <p><strong style='color: #000000;'>Up Trading Experts</strong></p>
                                                <p>Equipo</p>
                                                <p><a title='sistemas@upnegocios.com' href='mailto:sistemas@upnegocios.com'>sistemas@upnegocios.com</a>
                                                </p>
                                                <br>
                                            </div>                
                                        </div>
                                    </div>
                                    <div class='footer'>
                                        <div class='footer_imagen'>
                                            <img src='https://admin.uptradingexperts.com/img/logo_latam.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                        </div>
                                        <div class='footer_redes'>
                                            <a href='https://www.facebook.com/UpTradingExperts/' target='_blank'>
                                                <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/facebook@2x.png' width='32' height='32' alt='Facebook' title='Facebook'>
                                            </a>                                    
                                            <a href='https://www.instagram.com/uptradingexperts/' target='_blank'>
                                                <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/instagram@2x.png' width='32' height='32' alt='Instagram' title='Instagram'>
                                            </a>
                                        </div>
                                        <div class='footer_direccion'>                  
                                            <p style='margin: 0; font-size: 12px; text-align: left; color: #999999;'>
                                                <strong>Up Trading Experts</strong>
                                                <br>Torre V1 - Av. Universidad #234.<br>
                                                Fracc. Lomas del Guadiana, Interior #308, C.P. 34138, Durango, Dgo. México.
                                            </p>                
                                        </div>
                                    </div>
                                </div>
                            </body>
                        </html>";

        try {
            //Server settings
            // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = env('MAILER_HOST');                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = env('MAILER_USERNAME');                     //SMTP username
            $mail->Password   = env('MAILER_PASS');                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = env('MAILER_PORT');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('mensajes@uptradingexperts.com', 'Sistemas Up Trading Experts');
            $mail->addAddress($user->correo, "$user->nombre $user->apellido_p $user->apellido_m");     //Add a recipient

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'CITA ACTUALIZADA';
            $mail->Body    =  $mensaje;
                

            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        if(strlen($user2) > 0){

            $mensaje = "<!DOCTYPE html>
                        <html lang='es'>
                            <head>
                                <meta charset='UTF-8'>
                                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                                <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
                                <link href='https://fonts.gstatic.com' rel='preconnect'>
                                <link href='https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i' rel='stylesheet'>
                                <link href='https://fonts.googleapis.com/css2?family=Anton&display=swap' rel='stylesheet'>
                                <title>AGENDA</title>
                                <style>
                                    body{
                                        margin: 0;
                                        padding: 0;
                                    }

                                    p {
                                        color: #404040;
                                    }
                            
                                    ::-webkit-scrollbar {
                                        width: 8px;
                                    }
                            
                                    ::-webkit-scrollbar-track {
                                        background: #fff;
                                    }
                            
                                    ::-webkit-scrollbar-thumb {
                                        background: #232b35;
                                    }
                            
                                    ::-webkit-scrollbar-thumb:hover {
                                        background: #1d242c;
                                    }
                            
                                    .contenedor{
                                        width: 100%;
                                        overflow-x: hidden;
                                    }
                            
                                    .header{
                                        background-color: #2fb5cc;
                                        color: #000000;
                                    }
                            
                                    .header .header_contenido{
                                        width: 100%;
                                        padding-left: 5px;
                                        height: 4.5rem;
                                        display: flex;
                                        align-items: center;
                                    }
                            
                                    .header .header_contenido img {
                                        display: block; 
                                        height: 3.5rem; 
                                        border: 0; 
                                        padding-left: 5px;
                                        padding-top: 5px;
                                    }
                            
                                    .contenido{
                                        background-color: #FFFFFF; 
                                        color: #000000; 
                                        margin: auto;
                                    }
                            
                                    .contenido_mensaje {
                                        mso-table-lspace: 0pt; 
                                        mso-table-rspace: 0pt; 
                                        font-weight: 400; 
                                        vertical-align: top;
                                        padding-top: 40px; 
                                        padding-bottom: 20px; 
                                        border-top: 0px; 
                                        border-right: 0px; 
                                        border-bottom: 0px; 
                                        border-left: 0px;
                                    }
                            
                                    .contenido_mensaje_texto{
                                        padding-bottom: 30px;
                                        padding-left: 50px;
                                        padding-right: 50px;
                                        font-size: 12px; 
                                        font-family: Open Sans, Tahoma, Verdana, Segoe, sans-serif; 
                                        color: #404040;
                                        line-height: 1.5;
                                    }
                            
                                    .contenido_mensaje_texto p {
                                        margin: 0; font-size: 14px;
                                    }
                            
                                    .contenido_mensaje_texto p span{
                                        font-size:18px;
                                        font-weight: bold;
                                    }
                                                
                                    .contenido_mensaje hr{
                                        height: 1px;
                                        margin-left: 20px;                         
                                        margin-right: 20px;
                                        background-color: #404040;
                                    }
                            
                                    .contenido_imagen{
                                        padding: 5px 20px 20px 20px;
                                        line-height: 10px; 
                                        display: flex;
                                    }
                            
                                    .contenido_imagen img{
                                        display: block; 
                                        height: auto; 
                                        border: 0; 
                                        width: 96px; 
                                        max-width: 100%;
                                    }
                                    .contenido_imagen_info{
                                        padding-top: 5px;
                                        padding-bottom: 20px;
                                        margin-left: 15px;
                                        font-size: 12px;
                                        font-family: Ubuntu, Tahoma, Verdana, Segoe, sans-serif; 
                                        color: #404040;
                                        line-height: 1.5;
                                    }
                            
                                    .contenido_imagen_info p {
                                        margin: 0;
                                        font-size: 14px; 
                                        text-align: left;
                                    }
                            
                                    .footer{
                                        background-color: #404040;                                                  
                                        margin: auto;
                                    }
                                    .footer_imagen {
                                        text-align: left; 
                                        font-weight: 400; 
                                        vertical-align: top; 
                                        padding: 25px 0px 15px 30px;
                                        line-height:10px;
                                    }
                                    .footer_imagen img {
                                        display: block; height: auto; border: 0; width: 155px; max-width: 100%;
                                    }
                            
                                    .footer_redes {
                                        text-align: left; 
                                        font-weight: 400; 
                                        vertical-align: top; 
                                        padding: 0px 5px 15px 20px;
                                    }
                            
                                    .footer_redes a {
                                        text-decoration: none;
                                        margin-left: 2px;
                                    }
                            
                                    .footer_direccion {
                                        padding: 15px 10px 25px 30px;
                                        font-size: 12px; 
                                        font-family: Ubuntu, Tahoma, Verdana, Segoe, sans-serif; 
                                        color: #999999; 
                                        line-height: 1.2;
                                    }

                                    @media (max-width: 500px) {
                                        .contenido_mensaje_texto{
                                            padding-left: 0px;
                                            padding-right: 0px;
                                        }
                                        .contenido_mensaje_texto__info{
                                            padding-left: 10px;
                                            padding-right: 10px;
                                            text-align: justify;
                                        }                                   
                                    }
                                </style>
                            </head>
                            <body>
                                <div class='contenedor'>
                                    <div class='header'>
                                        <div class='header_contenido'>
                                            <img src='https://uptradingexperts.com/assets/images/logoblanco.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                        </div>
                                    </div>
                                    <div class='contenido'>
                                        <div class='contenido_mensaje'>
                                            <div class='contenido_mensaje_texto'>
                                                <div class='contenido_mensaje_texto__info'>
                                                    <p color: #404040;'>
                                                        Buenos días <b>$user2->nombre</b>, para comentarle que se le ha actualizado la cita '$request->titulo', para el día <b>$fecha a las $hora</b>.
                                                    </p>
                                                    <br />
                                                    <br />
                                                    <p color: #404040;'>
                                                        <b>Asunto:</b>
                                                        <br />
                                                        $request->titulo.
                                                    </p>
                                                    <br />
                                                    <p color: #404040;'>
                                                        <b>Más información acerca de la cita:</b>
                                                        <br />
                                                        $request->descripcion.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <br />
                                        <br />
                                        <br />
                                        <div class='contenido_imagen'>
                                            <div>
                                                <img src='https://admin.uptradingexperts.com/img/uplogopng.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                            </div>   
                                            <div class='contenido_imagen_info'>
                                                <p><strong style='color: #000000;'>Up Trading Experts</strong></p>
                                                <p>Equipo</p>
                                                <p><a title='sistemas@upnegocios.com' href='mailto:sistemas@upnegocios.com'>sistemas@upnegocios.com</a>
                                                </p>
                                                <br>
                                            </div>                
                                        </div>
                                    </div>
                                    <div class='footer'>
                                        <div class='footer_imagen'>
                                            <img src='https://admin.uptradingexperts.com/img/logo_latam.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                        </div>
                                        <div class='footer_redes'>
                                            <a href='https://www.facebook.com/UpTradingExperts/' target='_blank'>
                                                <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/facebook@2x.png' width='32' height='32' alt='Facebook' title='Facebook'>
                                            </a>                                    
                                            <a href='https://www.instagram.com/uptradingexperts/' target='_blank'>
                                                <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/instagram@2x.png' width='32' height='32' alt='Instagram' title='Instagram'>
                                            </a>
                                        </div>
                                        <div class='footer_direccion'>                  
                                            <p style='margin: 0; font-size: 12px; text-align: left; color: #999999;'>
                                                <strong>Up Trading Experts</strong>
                                                <br>Torre V1 - Av. Universidad #234.<br>
                                                Fracc. Lomas del Guadiana, Interior #308, C.P. 34138, Durango, Dgo. México.
                                            </p>                
                                        </div>
                                    </div>
                                </div>
                            </body>
                        </html>";

            try {
                //Server settings
                // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = env('MAILER_HOST');                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = env('MAILER_USERNAME');                     //SMTP username
                $mail->Password   = env('MAILER_PASS');                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                $mail->Port       = env('MAILER_PORT');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                //Recipients
                $mail->setFrom('mensajes@uptradingexperts.com', 'Sistemas Up Trading Experts');
                $mail->addAddress($user2->correo, "$user2->nombre $user2->apellido_p $user2->apellido_m");     //Add a recipient

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'CITA ACTUALIZADA';
                $mail->Body    =  $mensaje;
                    

                $mail->send();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

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
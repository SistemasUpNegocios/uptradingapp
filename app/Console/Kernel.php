<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Pendiente;
use App\Models\Contrato;
use App\Models\TipoContrato;
use App\Models\Notificacion;
use App\Models\Amortizacion;
use App\Models\PagoCliente;
use App\Models\PagoPS;
use Carbon\Carbon;
use App\Mail\BackupEmail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Jobs\Drive;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected function schedule(Schedule $schedule)
    {

        //Tarea para enviar correos de pendientes de checklist
        $schedule->call(function () {

            $pendientes = Pendiente::all();
            $pendientesCheck = Pendiente::select("primer_reporte")->get();
            $fecha = \Carbon\Carbon::parse(date('d-m-Y'))->formatLocalized('%d de %B de %Y');
            
            //mandar correo
            $mail = new PHPMailer(true);
            $mail->CharSet = "UTF-8";

            foreach ($pendientesCheck as $pendienteCheck) {
                if ($pendienteCheck->primer_reporte == "Pendiente"){
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
                                    
                                        <title>PENDIENTES EN EL CHECKLIST</title>
                                    
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
                                                background-color: #00626be7;
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
                                                margin: 0; font-size: 14px; text-align: left;
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
    
                                            .tg {
                                                border-collapse: collapse;
                                                border-color: #ccc;
                                                border-spacing: 0;
                                            }
                                            .tg td {
                                                background-color: #fff;
                                                border-color: #ccc;
                                                border-style: solid;
                                                border-width: 1px;
                                                color: #333;
                                                font-family: Arial, sans-serif;
                                                font-size: 14px;
                                                overflow: hidden;
                                                padding: 10px 5px;
                                                word-break: normal;
                                            }
                                            .tg th {
                                                background-color: #f0f0f0;
                                                border-color: #ccc;
                                                border-style: solid;
                                                border-width: 1px;
                                                color: #333;
                                                font-family: Arial, sans-serif;
                                                font-size: 14px;
                                                font-weight: normal;
                                                overflow: hidden;
                                                padding: 10px 5px;
                                                word-break: normal;
                                            }
                                            .tg .tg-baqh {
                                                text-align: center;
                                                vertical-align: middle;
                                            }
                                            .tg .tg-a3y7 {
                                                font-family: 'Arial Black', Gadget, sans-serif !important;
                                                text-align: left;
                                                vertical-align: top;
                                            }
                                            .tg .tg-5bf1 {
                                                font-family: 'Arial Black', Gadget, sans-serif !important;
                                                text-align: center;
                                                vertical-align:top;
                                            }
                                            .tg .tg-0lax {
                                                text-align: left;
                                                vertical-align: middle;
                                            }
    
                                            @media (max-width: 500px) {
                                                .contenido_mensaje_texto{
                                                    padding-left: 0px;
                                                    padding-right: 0px;
                                                }
                                                .contenido_mensaje_texto__info{
                                                    padding-left: 10px;
                                                }
                                                .contenido_mensaje_texto__div_tabla {
                                                    width: 100% !important;
                                                }
                                            }
                                        </style>
                                    </head>
                                    <body>
                                        <div class='contenedor'>
                                            <div class='header'>
                                                <div class='header_contenido'>
                                                    <img src='https://www.uptradingexperts.com/assets/images/logoblanco.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                                </div>
                                            </div>
                                            <div class='contenido'>
                                                <div class='contenido_mensaje'>
                                                    <div class='contenido_mensaje_texto'>
                                                        <div style='background: rgb(0,98,107); text-align: center'>
                                                            <p><span style='color: #FFFFFF; margin: 10px 0px; font-family: Anton, sans-serif; text-transform: uppercase; font-style: italic; font-weight: bolder; width: 100%;'>PENDIENTES DE CHECKLIST</span></p>
                                                        </div>
                                                        <br>
                                                        <div class='contenido_mensaje_texto__info'>
                                                            <p color: #404040;'><b>ORGANIZACIÓN:</b> Up Trading Experts.</p>
                                                            <p color: #404040;'><b>AREA:</b> Administración.</p>
                                                            <p color: #404040;'><b>FECHA:</b> $fecha.</p>";
                                                            foreach($pendientes as $pendiente) {
                                                                if($pendiente->primer_reporte == "Pendiente"){

                                                                    $cont = 0;
                                                                    $mensaje.="
                                                                    <br>
                                                                    <p style='color: #404040;'><b>CLIENTE:</b> $pendiente->memo_nombre.</p>
                                                                    <p style='color: #404040; margin-bottom: 8px'><b>ULTIMA MODIFICACIÓN: </b>";
                                                                        $mensaje.= \Carbon\Carbon::parse($pendiente->ultima_modificacion)->diffForHumans();
                                                                    $mensaje.= ".</p>
                                                                    <div class='contenido_mensaje_texto__div_tabla' style='width: 60%; margin: auto'>
                                                                        <table class='tg'>
                                                                            <thead>
                                                                                <tr>
                                                                                    <th class='tg-a3y7'># DE TAREA</th>
                                                                                    <th class='tg-a3y7'>NOMBRE DE LA TAREA</th>
                                                                                    <th class='tg-5bf1'>STATUS</th>
                                                                                </tr>                                                        
                                                                            </thead>
                                                                            <tbody>";
                                                                                if($pendiente->introduccion == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Introducción</td>
                                                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->introduccion</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->formulario == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Formulario</td>
                                                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->formulario</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->alta_cliente == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Alta de cliente</td>
                                                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->alta_cliente</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->videoconferencia == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Videoconferencia</td>
                                                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->videoconferencia</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->apertura == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Estatus de apertura</td>
                                                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->apertura</td>
                                                                                    </tr>";
                                                                                }
                                                                                $cont+=1;
                                                                                $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Nota de apertura</td>
                                                                                        <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>$pendiente->memo_apertura</td>
                                                                                    </tr>";
                                                                                if($pendiente->instrucciones_bancarias == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Instucciones bancarias</td>
                                                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->instrucciones_bancarias</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->generar_lpoa == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Generar LPOA</td>
                                                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->generar_lpoa</td>
                                                                                    </tr>";
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Nota de LPOA</td>
                                                                                        <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>$pendiente->memo_generar_lpoa</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->instrucciones_bancarias_mam == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Instrucciones Bancarias MAM</td>
                                                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->instrucciones_bancarias_mam</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->transferencia == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Transferencia</td>
                                                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->transferencia</td>
                                                                                    </tr>";
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Nota de transferencia</td>
                                                                                        <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>$pendiente->memo_transferencia</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->conexion_mampol == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Conexión MAM</td>
                                                                                        <td class='tg-baqh'style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->conexion_mampol</td>
                                                                                    </tr>";
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Nota de conexión MAM</td>
                                                                                        <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>$pendiente->memo_conexion_mampol</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->generar_convenio == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Generar convenio</td>
                                                                                        <td class='tg-baqh'style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->generar_convenio</td>
                                                                                    </tr>";
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>Nota de convenio</td>
                                                                                        <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>$pendiente->memo_generar_convenio</td>
                                                                                    </tr>";
                                                                                }
                                                                                if($pendiente->primer_reporte == "Pendiente"){
                                                                                    $cont+=1;
                                                                                    $mensaje.= "<tr>
                                                                                        <td class='tg-baqh'>$cont</td>
                                                                                        <td class='tg-0lax'>1er reporte</td>
                                                                                        <td class='tg-baqh'style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>$pendiente->primer_reporte</td>
                                                                                    </tr>";
                                                                                }
                                                                            $mensaje.="</tbody>
                                                                        </table>
                                                                    </div>
        
                                                                    <div class='divider' style='margin-top: 1.5rem !important;'>
                                                                        <hr style='background-color: #3f3f3f8f !important;'>
                                                                    </div>
        
                                                                    <br><br>
                                                                    ";
                                                                }
                                                            }
                                                        $mensaje.="</div>
                                                    </div>
                                                </div>
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
                                                    <a href='#' target='_blank'>
                                                        <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/facebook@2x.png' width='32' height='32' alt='Facebook' title='Facebook'>
                                                    </a>                                    
                                                    <a href='#' target='_blank'>
                                                        <img src='https://app-rsrc.getbee.io/public/resources/social-networks-icon-sets/t-only-logo-white/instagram@2x.png' width='32' height='32' alt='Instagram' title='Instagram'>
                                                    </a>
                                                </div>
                                                <div class='footer_direccion'>                  
                                                    <p style='margin: 0; font-size: 12px; text-align: left; color: #999999;'>
                                                        <strong>Up Trading Experts</strong>
                                                        <br>Torre V1 - Av. Universidad #234.<br>
                                                        Fracc. Lomas del Guadiana, Interior #308, C.P. 34110, Durango, Dgo. México.
                                                    </p>                
                                                </div>
                                            </div>
                                        </div>
                                    </body>
                                </html>";
    
                    
                }                
            }

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
                $mail->addAddress("javiersalazar@uptradingexperts.com", "Administración");     //Add a recipient

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'PENDIENTES EN EL CHECKLIST';
                $mail->Body    = $mensaje;
                    
                $mail->send();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        })
        ->weekdays()
        ->dailyAt("08:00")
        ->timezone('America/Mexico_City');

        //Tarea para refrendar contratos
        // $schedule->call(function () {

        //     //Consulta de contratos a un día de vencer
        //     $contratos = Contrato::where("contrato.status", "Activado")
        //     ->where("fecha_pago", Carbon::now()->format('Y-m-d'))
        //     ->get();

        //     foreach ($contratos as $contrato_update) {
        //         $contrato = Contrato::find($contrato_update->id);
                
        //         //Actualizar numero de contrato
        //         $contratoAct = explode("-", $contrato_update->contrato);
        //         $contratoRef = intval($contratoAct[2]) + 1;
        //         $contratoRef = str_pad($contratoRef, 2, "0", STR_PAD_LEFT);
        //         $contratoRef = $contratoAct[0] . "-" . $contratoAct[1] . "-" . $contratoRef;

        //         //Guardar cambios de contrato
        //         $contrato->contrato = strtoupper($contratoRef);
        //         $contrato->fecha = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
        //         $contrato->fecha_renovacion = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
        //         $contrato->fecha_pago = Carbon::parse($contrato_update->fecha_pago)->addYear()->format('Y-m-d');
        //         $contrato->fecha_limite = Carbon::parse($contrato_update->fecha_limite)->addYear()->format('Y-m-d');
        //         $contrato->status = "Activado";
        //         $contrato->update();

        //         //Actualización de tabla de amortizaciones
        //         $amortizaciones = Amortizacion::where("contrato_id", $contrato_update->id)->get();
        //         foreach ($amortizaciones as $amortizacion_update) {
        //             $amortizacion = Amortizacion::find($amortizacion_update->id);
        //             $amortizacion->fecha = Carbon::parse($amortizacion_update->fecha)->addYear()->format('Y-m-d');
        //             $amortizacion->update();
        //         }

        //         //Actualización de tabla de pago de clientes
        //         $pagos_clientes = PagoCliente::where("contrato_id", $contrato_update->id)->get();
        //         foreach ($pagos_clientes as $pago_cliente_update) {
        //             $pago_cliente = PagoCliente::find($pago_cliente_update->id);
        //             $pago_cliente->fecha_pago = Carbon::parse($pago_cliente_update->fecha_pago)->addYear()->format('Y-m-d');
        //             $pago_cliente->update();
        //         }

        //         //Actualización de tabla de pago de ps
        //         $pagos_ps = PagoPS::where("contrato_id", $contrato_update->id)->get();
        //         foreach ($pagos_ps as $pago_ps_update) {
        //             $pago_ps = PagoPS::find($pago_ps_update->id);
        //             $pago_ps->fecha_pago = Carbon::parse($pago_ps_update->fecha_pago)->addYear()->format('Y-m-d');
        //             $pago_ps->fecha_limite = Carbon::parse($pago_ps_update->fecha_limite)->addYear()->format('Y-m-d');
        //             $pago_ps->update();
        //         }

        //     }

        // })
        // ->dailyAt("09:00")
        // ->timezone('America/Mexico_City');
        
        //Tareas para Bakups de archivos y base de datos y envier correos.
        $schedule->command("backup:run")->dailyAt("20:00")->timezone('America/Mexico_City');
        $schedule->command("backup:clean")->dailyAt("21:00")->timezone('America/Mexico_City');
        $schedule->call(function () { 
            Drive::dispatch(); 
        })->dailyAt("22:00")->timezone('America/Mexico_City');
        $schedule->command("queue:work")->dailyAt("23:00")->timezone('America/Mexico_City');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
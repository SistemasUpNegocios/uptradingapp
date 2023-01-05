<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\IntencionInversion;
use App\Models\Log;
use App\Models\TipoContrato;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class IntencionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if(!auth()->user()->is_cliente){
            $tipos = TipoContrato::all();
            $data = array(
                "lista_tipos" => $tipos,
            );
            return response()->view('intencioninversion.show', $data, 200);
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getOpc()
    {
        $tipos = TipoContrato::all();
        $data = array(
            "lista_tipos" => $tipos,
        );
        return response()->view('intencioninversion.tipo', $data, 200);
    }

    public function getOpcDividir()
    {
        $tipos = TipoContrato::all();
        $data = array(
            "lista_tipos" => $tipos,
        );
        return response()->view('intencioninversion.tipodividir', $data, 200);
    }

    public function reporteIntencion(Request $request)
    {
        if ($request->isMethod('post')) {
            $intencionInversion = new IntencionInversion;

            $nombre = $request->input('nombre');
            $intencionInversion->nombre = $nombre;

            $telefono = $request->input('telefono');
            $intencionInversion->telefono = $telefono;

            $email = $request->input('email');
            $intencionInversion->email = $email;

            $inversion = $request->input('inversion');
            $intencionInversion->inversion_mxn = $inversion;

            $inversion_us = $request->input('inversion_us');
            $intencionInversion->inversion_usd = $inversion_us;

            $tipo_cambio = $request->input('tipo_cambio');
            $intencionInversion->tipo_cambio = $tipo_cambio;

            $fecha_inicio = $request->input('fecha_inicio');
            $intencionInversion->fecha_inicio = $fecha_inicio;

            $fecha_renovacion = $request->input('fecha_renovacion');
            $intencionInversion->fecha_renovacion = $fecha_renovacion;

            $fecha_pago = $request->input('fecha_pago');
            $intencionInversion->fecha_pago = $fecha_pago;

            $tipo_id = $request->input('tipo_id');
            $tipo_id2 = 0;
            $tipo_contrato2 = 0;
            $rendimiento2 = 0;
            $porcentaje = 0;
            $porcentaje2 = 0;
            $inversionMXN1 = 0;
            $inversionUSD1 = 0;
            $inversionMXN2 = 0;
            $inversionUSD2 = 0;

            if ($request->has('tipo_id2')) {
                if ($request->filled('tipo_id2')) {
                    $tipo_id2 = $request->input('tipo_id2');

                    $sql2 = DB::table("tipo_contrato")
                    ->where("id", "=", $tipo_id2)
                    ->get();
    
                    $tipo_contrato2 = $sql2[0]->tipo;
                    $intencionInversion->tipo_2 = $tipo_contrato2;
                    $rendimiento2 = $sql2[0]->rendimiento;
                    $intencionInversion->porcentaje_tipo_2 = $rendimiento2;
                }
            }

            if ($request->has('porcentaje_inversion_2')) {
                if ($request->filled('porcentaje_inversion_2')) {
                    $porcentaje = $request->input('porcentaje_inversion_1');
                    $porcentaje2 = $request->input('porcentaje_inversion_2');
                    $intencionInversion->porcentaje_inversion_1 = $porcentaje;
                    $intencionInversion->porcentaje_inversion_2 = $porcentaje2;
                }
            } else {
                $intencionInversion->porcentaje_inversion_1 = 100;
            }

            if ($request->has('inversionMXN1')) {
                if ($request->filled('inversionMXN1')) {
                    $inversionMXN1 = $request->input('inversionMXN1');
                }
            }

            if ($request->has('inversionMXN2')) {
                if ($request->filled('inversionMXN2')) {
                    $inversionMXN2 = $request->input('inversionMXN2');
                }
            }

            if ($request->has('inversionUSD1')) {
                if ($request->filled('inversionUSD1')) {
                    $inversionUSD1 = $request->input('inversionUSD1');
                }
            }

            if ($request->has('inversionUSD2')) {
                if ($request->filled('inversionUSD2')) {
                    $inversionUSD2 = $request->input('inversionUSD2');
                }
            }

            $sql = DB::table("tipo_contrato")
                ->where("id", "=", $tipo_id)
                ->get();

            $tipo_contrato = $sql[0]->tipo;
            $intencionInversion->tipo_1 = $tipo_contrato;
            $rendimiento = $sql[0]->rendimiento;
            $intencionInversion->porcentaje_tipo_1 = $rendimiento;

            if ($intencionInversion->save()) {
                $id = $intencionInversion->id;
                return view('intencioninversion.preview', [
                    'id' => $id,
                ]);
            }
        }
    }

    public function pdfIntencion(Request $request)
    {
        if ($request->isMethod('get')) {
            $id = $request->id;

            $data = [
                'id' => $id,
            ];

            $bitacora_id = session('bitacora_id');

            $log = new Log;
    
            $log->tipo_accion = "Inserción";
            $log->tabla = "Intención de inversión";
            $log->bitacora_id = $bitacora_id;
    
            $log->save();

            $pdf = PDF::loadView('intencioninversion.pdf', $data);

            $query = IntencionInversion::where('id', $id)->get();
            $fecha_inicio = $query[0]->fecha_inicio;
            $nombre = $query[0]->nombre;
            $fecha = Carbon::parse($fecha_inicio)->formatLocalized('%d de %B de %Y');
            $correo = $query[0]->email;

            $nombreDescarga = "Intención de inversión " . $fecha_inicio . " $nombre.pdf";
            $visualizacion = $pdf->stream($nombreDescarga);
            
            Storage::disk('intencion')->put($nombreDescarga, $visualizacion);

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
                                                        <p style='color: #404040 !important;'>
                                                            Buen día <b>$nombre</b>, por este medio se le adjunta la intención de inversión creada el día <b>$fecha</b>.
                                                            <br />
                                                            Con el fin de que pueda revisarla y en caso de que tenga alguna duda o comentario, por favor no dude en contactarnos. Que tenga un excelente día.
                                                        </p>
                                                        <br />
                                                        <p style='color: #404040;'>
                                                            Este mensaje es generado automaticamente por el sistema, por favor no responda a este correo. Pero puede contactarnos a través de los siguientes medios:
                                                        </p>
                                                        <br />
                                                        <p style='color: #404040;'>
                                                            <b>Email: <a title='contacto@uptradingexperts.com' href='mailto:contacto@uptradingexperts.com'>contacto@uptradingexperts.com</a></b>
                                                            <br />
                                                            <b>Teléfono: <a href='tel:8000878290' title='Llama ahora'><i class='fa fa-phone'></i> (800) 087 8290</a></b>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <br />
                                            <div class='contenido_imagen'>
                                                <div>
                                                    <img src='https://admin.uptradingexperts.com/img/uplogopng.png' alt='Up Trading Experts' title='Up Trading Experts'>
                                                </div>   
                                                <div class='contenido_imagen_info'>
                                                    <p><strong style='color: #000000;'>Up Trading Experts</strong></p>
                                                    <p>Equipo</p>
                                                    <p><a title='administracion@upnegocios.com' href='mailto:administracion@upnegocios.com'>administracion@upnegocios.com</a>
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
                $mail->setFrom('mensajes@uptradingexperts.com', 'Administración UP Trading Experts');
                $mail->addAddress($correo, "$nombre");     //Add a recipient

                $mail->addAttachment(public_path() . '/documentos/intencion/' . $nombreDescarga);

                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'INTENCIÓN DE INVERSIÓN';
                $mail->Body    =  $mensaje;
                    

                $mail->send();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

            return $visualizacion;
        }
    }

    public function getClientes()
    {

        $codigo = session('codigo_oficina');
        $numeroCliente = "MXN-".$codigo."-";

        
        $clientes = DB::table("cliente")
        ->orderBy('apellido_p')
        ->where('codigoCliente', 'like', "$numeroCliente%")
        ->get();

        return view('intencioninversion.clientes', ['clientes' => $clientes]);
    }

    public function getDatosCliente(Request $request)
    {
        $id = $request->id;

        $query = Cliente::where('id', $id)->get();
        // $telefono = $query[0]->celular;

        return response($query);
    }
}
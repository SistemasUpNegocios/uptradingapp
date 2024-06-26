<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Contrato;
use App\Models\User;
use App\Models\Ps;
use App\Models\Oficina;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Http;
use App\Models\Formulario;
use App\Models\Convenio;
use App\Models\Log;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\SwissEmail;
use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\CuentasMam;
use Maatwebsite\Excel\Facades\Excel;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        if (auth()->user()->is_root || auth()->user()->is_admin || auth()->user()->is_procesos || auth()->user()->is_egresos || auth()->user()->is_ps_diamond){
            $codigo = session('codigo_oficina');
            $numeroCliente = "MXN-" . $codigo . "-";
            $lista_form = Formulario::select()->where('codigoCliente', 'like', "$numeroCliente%")->get();

            return view('cliente.show', compact("lista_form"));
        }else{
            return redirect()->to('/admin/dashboard');
        }
    }

    public function getCliente()
    {
        $codigo = session('codigo_oficina');
        $numeroCliente = "MXN-" . $codigo . "-";
        $cliente = Cliente::select()->where('codigoCliente', 'like', "$numeroCliente%")->orderBy("id", "DESC")->get();

        return datatables()->of($cliente)->addColumn('btn', 'cliente.buttons')->rawColumns(['btn'])->toJson();
    }

    public function addCliente(Request $request)
    {
        if ($request->ajax()) {

            $convenio_mam = $request->input('convenio_mam');

            if(!empty($convenio_mam)){
                $request->validate([
                    'nombre' => 'required|string',
                    'apellidop' => 'required|string',
                ]);
            }else{
                $request->validate([
                    'codigocliente' => 'required|unique:cliente',
                    'nombre' => 'required|string',
                    'apellidop' => 'required|string',
                    'fechanac' => 'required|date',
                    'nacionalidad' => 'required',
                    'direccion' => 'required',
                    'colonia' => 'required',
                    'cp' => 'required|numeric|digits:5',
                    'ciudad' => 'required|string',
                    'estado' => 'required|string',
                    'celular' => 'required|numeric|digits:10',
                    'correo_institucional' => 'required|email|unique:cliente',
                    'correo_personal' => 'required|email',
                ]);
            }

            if(!empty($request->input('ine'))){
                $request->validate([
                    'ine' => 'required|digits_between:10,20',
                ]);
            }

            //Añadir registros a la tabla clientes
            $cliente = new Cliente;

            $codigo_cliente = strtoupper($request->codigocliente);
            $codigo_cliente = explode("-", $codigo_cliente);
            $codigo_cliente = $codigo_cliente[2];

            $codigo_cliente_sql = Cliente::where('codigoCliente', 'like', "%$codigo_cliente%")->get();
            
            if(sizeof($codigo_cliente_sql) <= 0){
                $cliente->codigoCliente = strtoupper($request->input('codigocliente'));
                $cliente->nombre = strtoupper($request->input('nombre'));
                $cliente->apellido_p = strtoupper($request->input('apellidop'));
                $cliente->apellido_m = strtoupper($request->input('apellidom'));
                $cliente->fecha_nac = $request->input('fechanac');
                $cliente->nacionalidad = strtoupper($request->input('nacionalidad'));
                $cliente->direccion = strtoupper($request->input('direccion'));
                $cliente->colonia = strtoupper($request->input('colonia'));
                $cliente->cp = $request->input('cp');
                $cliente->ciudad = strtoupper($request->input('ciudad'));
                $cliente->estado = strtoupper($request->input('estado'));
                $cliente->celular = $request->input('celular');
                $cliente->correo_personal = strtolower($request->input('correo_personal'));
                $cliente->correo_institucional = strtolower($request->input('correo_institucional'));
                $cliente->ine = $request->input('ine');
                $cliente->pasaporte = strtoupper($request->input('pasaporte'));
                $cliente->vencimiento_pasaporte = $request->input('fechapas');
                $cliente->swift = strtoupper($request->input('swift'));
                $cliente->iban = strtoupper($request->input('iban'));
                $cliente->identificador_mam = $request->input('identificador');
                if (gettype($request->tipo_pago) != 'NULL'){
                    $tipos_pagos = "";
                    foreach ($request->tipo_pago as $tipo_pago) {
                        if($tipo_pago != ""){
                            $tipos_pagos .= $tipo_pago.',';
                        }
                    }
                    $cliente->tipo_pago = $tipos_pagos;
                }

                $tarjeta = $request->input('tarjeta');
                
                if(!empty($tarjeta)){
                    $cliente->tarjeta = "SI";
                }else{
                    $cliente->tarjeta = "NO";
                }

                $formulario = DB::table('formulario')->select()->where("id", "=", $request->form_id)->first();

                $nombreDocs = $request->codigocliente;
                $nombreDocs = explode("-", $request->codigocliente);
                $nombreDocs = $nombreDocs[1] . "-" . $nombreDocs[2];

                if ($request->hasFile('ine_documento')) {
                    $file = $request->file('ine_documento');
                    $ext = $file->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    $filename = $nombreDocs . "_ine" . $ext;

                    $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                    $cliente->ine_documento = $filename;
                }else if($request->form_id > 0 || $request->form_id != ""){
                        $cliente->ine_documento = $formulario->ine_documento;
                }
                    
                if ($request->hasFile('pasaporte_documento')) {
                    $file = $request->file('pasaporte_documento');
                    $ext = $file->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    $filename = $nombreDocs . "_pasaporte" . $ext;

                    $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                    $cliente->pasaporte_documento = $filename;
                }else if($request->form_id > 0 || $request->form_id != ""){
                    $cliente->pasaporte_documento = $formulario->pasaporte_documento;
                }

                if ($request->hasFile('comprobante_domicilio')) {
                    $file = $request->file('comprobante_domicilio');
                    $ext = $file->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    $filename = $nombreDocs . "_comprobante_domicilio" . $ext;

                    $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                    $cliente->comprobante_domicilio = $filename;
                }else if($request->form_id > 0 || $request->form_id != ""){
                    $cliente->comprobante_domicilio = $formulario->comprobante_domicilio;
                }

                if ($request->hasFile('lpoa_documento')) {
                    $file = $request->file('lpoa_documento');
                    $ext = $file->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    $filename = $nombreDocs . "_lpoa" . $ext;

                    $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                    $cliente->lpoa_documento = $filename;
                }

                if ($request->hasFile('formulario_apertura')) {
                    $file = $request->file('formulario_apertura');
                    $ext = $file->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    $filename = $nombreDocs . "_formapertura" . $ext;

                    $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                    $cliente->formulario_apertura = $filename;
                }

                if ($request->hasFile('formulario_riesgos')) {
                    $file = $request->file('formulario_riesgos');
                    $ext = $file->getClientOriginalName();
                    $ext = substr($ext, strpos($ext, "."));
                    $filename = strtolower($nombreDocs . "_formriesgos" . $ext);

                    $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                    $cliente->formulario_riesgos = $filename;
                }

                $cliente->save();

                $cliente_id = $cliente->id;
                $bitacora_id = session('bitacora_id');

                $log = new Log;

                $log->tipo_accion = "Inserción";
                $log->tabla = "Cliente";
                $log->id_tabla = $cliente_id;
                $log->bitacora_id = $bitacora_id;

                $log->save();

                //Añadir registros a la tabla users
                $verificacion = User::where("correo", strtolower($request->correo_institucional))->count();
                if ($verificacion == 0) {
                    $user = new User;
                    $user->nombre = strtoupper($request->nombre);
                    $user->apellido_p = strtoupper($request->apellidop);
                    $user->apellido_m = strtoupper($request->apellidom);
                    $user->correo = strtolower($request->correo_institucional);
                    $user->password = "nuevo123";
                    $user->privilegio = 'cliente';

                    $user->save();
                } else {
                    User::where('correo', strtolower($request->input('correo_institucional')))
                        ->update([
                            'nombre' => strtoupper($request->nombre),
                            "apellido_p" => strtoupper($request->apellidop),
                            "apellido_m" => strtoupper($request->apellidom),
                            "privilegio" => "ps_silver"
                        ]);
                }
                return response($cliente);
            }else{
                return response()->json(
                    [
                        'errors' => [
                            "codigocliente" => ["El código de cliente ya está en uso."]
                        ]
                    ], 
                    422
                );
            }            
        }
    }

    public function editCliente(Request $request)
    {
        if ($request->ajax()) {
            
            $convenio_mam = $request->input('convenio_mam');
            if(!empty($convenio_mam)){
                $request->validate([
                    'nombre' => 'required|string',
                    'apellidop' => 'required|string',
                ]);
            }else{
                $request->validate([
                    'codigocliente' => 'required',
                    'nombre' => 'required|string',
                    'apellidop' => 'required|string',
                    'fechanac' => 'required|date',
                    'nacionalidad' => 'required',
                    'direccion' => 'required',
                    'colonia' => 'required',
                    'cp' => 'required|numeric|digits:5',
                    'ciudad' => 'required|string',
                    'estado' => 'required|string',
                    'celular' => 'required|numeric|digits:10',
                    'correo_institucional' => 'required|email',
                    'correo_personal' => 'required|email',
                ]);
            }

            if(!empty($request->input('ine'))){
                $request->validate([
                    'ine' => 'required|digits_between:10,20',
                ]);
            }

            //Editar registros en la tabla clientes
            $cliente = Cliente::find($request->id);

            $codigo_cliente = strtoupper($request->codigocliente);
            $codigo_cliente = explode("-", $codigo_cliente);
            $codigo_cliente = $codigo_cliente[2];

            $cliente->codigoCliente = $request->input('codigocliente');
            $cliente->nombre = strtoupper($request->input('nombre'));
            $cliente->apellido_p = strtoupper($request->input('apellidop'));
            $cliente->apellido_m = strtoupper($request->input('apellidom'));
            $cliente->fecha_nac = $request->input('fechanac');
            $cliente->nacionalidad = strtoupper($request->input('nacionalidad'));
            $cliente->direccion = strtoupper($request->input('direccion'));
            $cliente->colonia = strtoupper($request->input('colonia'));
            $cliente->cp = $request->input('cp');
            $cliente->ciudad = strtoupper($request->input('ciudad'));
            $cliente->estado = strtoupper($request->input('estado'));
            $cliente->celular = $request->input('celular');
            $cliente->correo_personal = strtolower($request->input('correo_personal'));
            $cliente->correo_institucional = strtolower($request->input('correo_institucional'));
            $cliente->ine = $request->input('ine');
            $cliente->pasaporte = strtoupper($request->input('pasaporte'));
            $cliente->vencimiento_pasaporte = $request->input('fechapas');
            $cliente->swift = strtoupper($request->input('swift'));
            $cliente->iban = $request->input('iban');
            $cliente->identificador_mam = $request->input('identificador');
            if (gettype($request->tipo_pago) != 'NULL'){
                $tipos_pagos = "";
                foreach ($request->tipo_pago as $tipo_pago) {
                    if($tipo_pago != ""){
                        $tipos_pagos .= $tipo_pago.',';
                    }
                }
                $cliente->tipo_pago = $tipos_pagos;
            }

            $tarjeta = $request->input('tarjeta');
            
            if(!empty($tarjeta)){
                $cliente->tarjeta = "SI";
            }else{
                $cliente->tarjeta = "NO";
            }

            $nombreDocs = $request->codigocliente;
            $nombreDocs = explode("-", $request->codigocliente);
            $nombreDocs = $nombreDocs[1] . "-" . $nombreDocs[2];
            if ($request->hasFile('ine_documento')) {
                $file = $request->file('ine_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_ine" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->ine_documento = $filename;
            }

            if ($request->hasFile('pasaporte_documento')) {
                $file = $request->file('pasaporte_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_pasaporte" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->pasaporte_documento = $filename;
            }

            if ($request->hasFile('comprobante_domicilio')) {
                $file = $request->file('comprobante_domicilio');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_comprobante_domicilio" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->comprobante_domicilio = $filename;
            }

            if ($request->hasFile('lpoa_documento')) {
                $file = $request->file('lpoa_documento');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_lpoa" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->lpoa_documento = $filename;
            }

            if ($request->hasFile('formulario_apertura')) {
                $file = $request->file('formulario_apertura');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = $nombreDocs . "_formapertura" . $ext;

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->formulario_apertura = $filename;
            }

            if ($request->hasFile('formulario_riesgos')) {
                $file = $request->file('formulario_riesgos');
                $ext = $file->getClientOriginalName();
                $ext = substr($ext, strpos($ext, "."));
                $filename = strtolower($nombreDocs . "_formriesgos" . $ext);

                $file->move(public_path("documentos/clientes/$nombreDocs"), $filename);
                $cliente->formulario_riesgos = $filename;
            }

            $cliente->update();

            $cliente_id = $cliente->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Actualización";
            $log->tabla = "Cliente";
            $log->id_tabla = $cliente_id;
            $log->bitacora_id = $bitacora_id;

            $log->save();

            //editar user
            User::where('correo', $request->correo_temp)
                ->update([
                    'nombre' => strtoupper($request->nombre),
                    "apellido_p" => strtoupper($request->apellidop),
                    "apellido_m" => strtoupper($request->apellidom),
                    "correo" => strtolower($request->input('correo_institucional'))
                ]);

            return response($cliente);
                       
        }
    }

    public function deleteCliente(Request $request)
    {
        if ($request->ajax()) {

            $cliente = DB::table('cliente')->where('id', $request->id)->first();
            $users = DB::table('users')->where('correo', $cliente->correo_institucional)->first();

            $cliente_id = $request->id;
            $bitacora_id = session('bitacora_id');

            $log = new Log;

            $log->tipo_accion = "Eliminación";
            $log->tabla = "Cliente";
            $log->id_tabla = $cliente_id;
            $log->bitacora_id = $bitacora_id;

            if ($log->save()) {
                Cliente::destroy($request->id);
            }
        }
    }

    public function numCliente(Request $request)
    {

        $numeroOficina = session('codigo_oficina');

        if ($numeroOficina == "%") {
            $numeroOficina = "001";
        }
        $codigoForm = Formulario::select('codigoCliente')->orderBy('id', 'DESC')->first();
        $codigoCliente = Cliente::select('codigoCliente')->orderBy('id', 'DESC')->first();
        
        if (!empty($codigoForm) && !empty($codigoCliente)) {

            $codigoForm = explode("-", $codigoForm);            
            $codigoCliente = explode("-", $codigoCliente);

            if($codigoForm[2] >= $codigoCliente[2]){
                $cliente = intval($codigoForm[2]) + 1;
            }else if($codigoForm[2] < $codigoCliente[2]){
                $cliente = intval($codigoCliente[2]) + 1;
            }else{
                $cliente = intval($codigoForm[2]) + 1;
            }        

            $numeroCliente = str_pad($cliente, 5, "0", STR_PAD_LEFT);
            $numeroClienteCompleto = "MXN-$numeroOficina-$numeroCliente-000-00";

            $data = array(
                "numeroCliente" => $numeroClienteCompleto,
                "correoCliente" => "mxa_" . $numeroCliente . "@uptradingexperts.com"
            );

            return response($data);
        } else {
            $numeroCliente = "MXN-$numeroOficina-00001-000-00";

            $data = array(
                "numeroCliente" => $numeroCliente,
                "correoCliente" => "mxa_00001@uptradingexperts.com"
            );
            return response($numeroCliente);
        }
    }

    public function getFormulario(Request $request)
    {
        $formulario = DB::table('formulario')
            ->select()
            ->where("id", "=", $request->id)
            ->get();

        return response($formulario);
    }

    public function pdfLpoaSwiss(Request $request)
    {
        $id = $request->id;

        $nombreDocs = $request->codigocliente;
        $nombreDocs = explode("-", $request->codigocliente);
        $nombreDocs = $nombreDocs[1] . "-" . $nombreDocs[2];
        $query = Cliente::where('id', $id)->get();
        $nombre = $request->nombre;
        $nombreDoc = $request->doc;
        $correo = "latam@swissquote.com";
        $nombreDescarga = $nombreDocs."/".$nombreDoc;
        
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

@media(max-width: 500px) {
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
                                                        Hola, buen día, adjunto LPOA del cliente: <b>$nombre </b>, para apertura de cuenta MAM.</b>
                                                        <br />
                                                    Saludos, gracias.
                                                    </p>
                                                    <br />
                                                    <p style='color: #404040;'>
                                                        <b>Email: <a title='clientes@uptradingexperts.com' href='mailto:contacto@uptradingexperts.com'>clientes@uptradingexperts.com</a></b>
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
                                                <p><a title='clientes@uptradingexperts.com' href='mailto:clientes@uptradingexperts.com'>clientes@uptradingexperts.com</a>
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
            $mail->Username   = env('MAILER_CLIENTES');                     //SMTP username
            $mail->Password   = env('MAILER_CLIENTESPASS');                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = env('MAILER_PORT');                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('clientes@uptradingexperts.com', 'Clientes UP Trading Experts');
            $mail->addAddress($correo, "LATAM SWISSQUOTE");     //Add a recipient

            $mail->addAttachment(public_path() . '/documentos/clientes/' . $nombreDescarga);

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'DOCUMENTO LPOA PARA CUENTA MAM';
            $mail->Body    =  $mensaje;
                

            $mail->send();

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

          
        return response()->json(['data']);
    }

    public function getCuenta()
    {
        $cliente = Convenio::join("cliente", "cliente.id", "=", "convenio.cliente_id")
        ->select("convenio.id as convenioid", "cliente.nombre", "cliente.apellido_p", "cliente.apellido_m", "convenio.numerocuenta", "convenio.monto", "convenio.fecha_inicio", "convenio.cliente_id", "convenio.loggin")
        ->where("convenio.id", "!=", 39)
        ->groupBy('convenio.cliente_id')
        ->orderBy("convenio.cliente_id", "ASC")
        ->get();

        $data = array(
            "informacion" => $cliente,
        );

        $pdf = PDF::loadView('cliente.imprimir', $data)->setPaper('letter', 'landscape');
        
        $fecha = Carbon::now()->formatLocalized('%d de %B de %Y');
        $nombreDescarga = "Clientes y su IBAN hasta el día $fecha.pdf";

        return $pdf->stream($nombreDescarga);
        
    }

    public function export()
    {
        $fecha = Carbon::now()->formatLocalized('%d de %B de %Y');
        return Excel::download(new CuentasMam(), "Cuentas Mam al día $fecha.xlsx");
    }

}

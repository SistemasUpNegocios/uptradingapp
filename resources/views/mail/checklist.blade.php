<!DOCTYPE html>
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
                            <p color: #404040;'><b>FECHA:</b> {{$fecha}}.</p>
                            @foreach($pendientes as $pendiente) 
                                @if($pendiente->primer_reporte == "Pendiente")
                                    @php $cont = 0; @endphp
                                    <br>
                                    <p style='color: #404040;'><b>CLIENTE:</b> {{$pendiente->memo_nombre}}.</p>
                                    <p style='color: #404040; margin-bottom: 8px'><b>ULTIMA MODIFICACIÓN: </b>
                                        {{\Carbon\Carbon::parse($pendiente->ultima_modificacion)->diffForHumans()}}
                                    </p>
                                    <div class='contenido_mensaje_texto__div_tabla' style='width: 60%; margin: auto'>
                                        <table class='tg'>
                                            <thead>
                                                <tr>
                                                    <th class='tg-a3y7'># DE TAREA</th>
                                                    <th class='tg-a3y7'>NOMBRE DE LA TAREA</th>
                                                    <th class='tg-5bf1'>STATUS</th>
                                                </tr>                                                        
                                            </thead>
                                            <tbody>
                                                @if($pendiente->introduccion == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Introducción</td>
                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->introduccion}}</td>
                                                    </tr>
                                                @endif
                                                @if($pendiente->formulario == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Formulario</td>
                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->formulario}}</td>
                                                    </tr>
                                                @endif
                                                @if($pendiente->alta_cliente == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Alta de cliente</td>
                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->alta_cliente}}</td>
                                                    </tr>
                                                @endif
                                                @if($pendiente->videoconferencia == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Videoconferencia</td>
                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->videoconferencia}}</td>
                                                    </tr>
                                                @endif
                                                @if($pendiente->apertura == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Estatus de apertura</td>
                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->apertura}}</td>
                                                    </tr>
                                                @endif
                                                @php $cont+=1; @endphp
                                                <tr>
                                                    <td class='tg-baqh'>{{$cont}}</td>
                                                    <td class='tg-0lax'>Nota de apertura</td>
                                                    <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>{{$pendiente->memo_apertura}}</td>
                                                </tr>
                                                @if($pendiente->instrucciones_bancarias == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Instucciones bancarias</td>
                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->instrucciones_bancarias}}</td>
                                                    </tr>
                                                @endif
                                                @if($pendiente->generar_lpoa == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Generar LPOA</td>
                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->generar_lpoa}}</td>
                                                    </tr>
                                                @endif
                                                @php $cont+=1; @endphp
                                                <tr>
                                                    <td class='tg-baqh'>{{$cont}}</td>
                                                    <td class='tg-0lax'>Nota de LPOA</td>
                                                    <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>{{$pendiente->memo_generar_lpoa}}</td>
                                                </tr>
                                                @if($pendiente->instrucciones_bancarias_mam == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Instrucciones Bancarias MAM</td>
                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->instrucciones_bancarias_mam}}</td>
                                                    </tr>
                                                @endif
                                                @if($pendiente->transferencia == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Transferencia</td>
                                                        <td class='tg-baqh' style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->transferencia}}</td>
                                                    </tr>
                                                @endif
                                                @php $cont+=1; @endphp
                                                <tr>
                                                    <td class='tg-baqh'>{{$cont}}</td>
                                                    <td class='tg-0lax'>Nota de transferencia</td>
                                                    <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>{{$pendiente->memo_transferencia}}</td>
                                                </tr>
                                                @if($pendiente->conexion_mampol == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Conexión MAM</td>
                                                        <td class='tg-baqh'style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->conexion_mampol}}</td>
                                                    </tr>
                                                @endif
                                                @php $cont+=1; @endphp
                                                <tr>
                                                    <td class='tg-baqh'>{{$cont}}</td>
                                                    <td class='tg-0lax'>Nota de conexión MAM</td>
                                                    <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>{{$pendiente->memo_conexion_mampool}}</td>
                                                </tr>
                                                @if($pendiente->generar_convenio == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>Generar convenio</td>
                                                        <td class='tg-baqh'style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->generar_convenio}}</td>
                                                    </tr>
                                                @endif
                                                @php $cont+=1; @endphp
                                                <tr>
                                                    <td class='tg-baqh'>{{$cont}}</td>
                                                    <td class='tg-0lax'>Nota de convenio</td>
                                                    <td class='tg-baqh' style='background: #e2e3e5; color: #41464b; text-transform: uppercase; font-weight: bold;'>{{$pendiente->memo_generar_convenio}}</td>
                                                </tr>
                                                @if($pendiente->primer_reporte == "Pendiente")
                                                    @php $cont+=1; @endphp
                                                    <tr>
                                                        <td class='tg-baqh'>{{$cont}}</td>
                                                        <td class='tg-0lax'>1er reporte</td>
                                                        <td class='tg-baqh'style='background: #f8d7da; color: #842029; text-transform: uppercase; font-weight: bold;'>{{$pendiente->primer_reporte}}</td>
                                                    </tr>
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class='divider' style='margin-top: 1.5rem !important;'>
                                        <hr style='background-color: #3f3f3f8f !important;'>
                                    </div>

                                    <br><br>
                                @endif
                            @endforeach
                        </div>
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
</html>
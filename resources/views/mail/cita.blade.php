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
        <title>Cambio de horario de cita</title>
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
                                Buen día <b>{{$nombre}}</b>, le informamos que hemos cambiado el horario de su cita para el día <b>{{$fecha}}</b>.
                            </p>
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
                        <p><a title='contacto@upnegocios.com' href='mailto:contacto@upnegocios.com'>contacto@upnegocios.com</a>
                        </p>
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
</html>
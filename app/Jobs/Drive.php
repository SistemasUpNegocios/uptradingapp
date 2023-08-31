<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\BackupEmail;

class Drive implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 900;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '8192M');

		//Comprimir archivos
		$zip = new \ZipArchive();
        $zip->open("AdminUpTradingExperts.zip", \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $origen = storage_path('app/Admin-Up-Trading-Experts');
        $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($origen), \RecursiveIteratorIterator::LEAVES_ONLY);
        foreach ($files as $name => $file){
            if (!$file->isDir()){
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($origen) + 1);
                $zip->addFile($filePath, $relativePath);
            }
        }
        $zip->close();

        // Mover archivo
        $ruta_anterior = base_path('AdminUpTradingExperts.zip');
        $nueva_ruta = storage_path('app/AdminUpTradingExperts.zip');
        rename($ruta_anterior, $nueva_ruta);

        //Subir archvio a Google Drive
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/clave.json'));

        //crear y configurar el objeto cliente
        $cliente = new \Google_Client();
        $cliente->useApplicationDefaultCredentials();
        $cliente->setScopes(['https://www.googleapis.com/auth/drive.file']);
        
        try {
            //proceso para leer un archivo por pedazos
            function leerPorPedazos($fp, $bytesDelPedazo){
                $totalBytes = 0;
                $pedazoGigante = "";
                while (!feof($fp)) {
                    $pedazo = fread($fp, 8192);
                    $totalBytes += strlen($pedazo);
                    $pedazoGigante .= $pedazo;
                    if ($totalBytes >= $bytesDelPedazo) {
                        return $pedazoGigante;
                    }
                }
                return $pedazoGigante;
            }

            $fecha = \Carbon\Carbon::now()->subDays(1)->formatLocalized('%d de %B de %Y');
            $nombre = "AdminUpTradingExperts-".\Carbon\Carbon::now()->format('d-m-Y').".zip";

            $servicio = new \Google_Service_Drive($cliente); // definir el serivico que se está solicitando
            $archivoLocal = storage_path("app/AdminUpTradingExperts.zip"); // definimos la ruta del archivo a cargar

            $archivoDrive = new \Google_Service_Drive_DriveFile();
            $archivoDrive->setName($nombre);
            $archivoDrive->setParents(array("1ELGZNDzq_Yl6VbBRAlT698MPWAiapGzZ"));
            $archivoDrive->setDescription("Backup de archivos y Base de Datos del día $fecha");
            
            $bytesDelPedazo = 1 * 1024 * 1024; //128Kbs

            //configurar los parámetros opcionales
            $paramsOpc = array(
                'fields' => '*'
            );

            //llamar a la api y configurar al cliente diferido para que no regrese inmediatamente
            $cliente->setDefer(true);
            $solicitud = $servicio->files->create($archivoDrive, $paramsOpc);

            //crear una carga de archivo multimedia para representar el proceso de carga
            $multimedia = new \Google_Http_MediaFileUpload(
                $cliente,
                $solicitud,
                "application/zip",
                null,
                true,
                $bytesDelPedazo
            );
            $multimedia->setFileSize(filesize($archivoLocal));
        
            //cargamos todos los pedazos. $estado será false hasta que el proceso esté completo
            $estado = false;
            $fp = fopen($archivoLocal, "rb");
            while (!$estado && !feof($fp)) {
                // leemos hasta que dejamos de obtener $bytesDelPedazo del $archivoLocal
                $pedazo = leerPorPedazos($fp, $bytesDelPedazo);
                $estado = $multimedia->nextChunk($pedazo);
            }
        
            $link = "https://drive.google.com/file/d/$estado->id/view?usp=sharing";

            $cliente->setDefer(false);
            
        } catch (\Google_Service_Exception $gs) {
            $mensaje = json_decode($gs->getMessage());
            echo $mensaje->error->message;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
        
        //Enviar correos
		Mail::to("javiersalazar@uptradingexperts.com")->send(new BackupEmail($link));

        ini_set('memory_limit', '512M');
    }
}

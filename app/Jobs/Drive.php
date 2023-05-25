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

        //Mover archivo
        $ruta_anterior = base_path('AdminUpTradingExperts.zip');
        $nueva_ruta = storage_path('app/AdminUpTradingExperts.zip');
        rename($ruta_anterior, $nueva_ruta);

        //Subir archvio a Google Drive
        putenv('GOOGLE_APPLICATION_CREDENTIALS=' . storage_path('app/clave.json'));

        $client = new \Google_Client();
        $client->useApplicationDefaultCredentials();
        $client->setScopes(['https://www.googleapis.com/auth/drive.file']);
        
        try {
            ini_set('memory_limit', '8192M');

            $fecha_inicio = \Carbon\Carbon::now()->subDays(1)->formatLocalized('%d de %B de %Y');
            $fecha_fin = \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y');
            $nombre = "AdminUpTradingExperts-".\Carbon\Carbon::now()->format('d-m-Y').".zip";

            $service = new \Google_Service_Drive($client);
            $file_path = storage_path("app/AdminUpTradingExperts.zip");

            $file = new \Google_Service_Drive_DriveFile();
            $file->setName($nombre);

            $file->setParents(array("1ELGZNDzq_Yl6VbBRAlT698MPWAiapGzZ"));
            $file->setDescription("Backup de archivos y Base de Datos del día $fecha_inicio al $fecha_fin");
            $file->setMimeType("application/zip");
            
            $result = $service->files->create(
                $file,
                array(
                    'data' => file_get_contents($file_path),
                    'mimeType' => "application/zip",
                    'uploadType' => 'multipart',
                )
            );

            $link = "https://drive.google.com/file/d/$result->id/view?usp=sharing";
            
            //Enviar correos
            Mail::to("javiersalazar@uptradingexperts.com")->send(new BackupEmail($link));
            Mail::to("paolarosales@uptradingexperts.com")->send(new BackupEmail($link));
            
            ini_set('memory_limit', '512M');

        } catch (Google_Service_Exception $gs) {
            $mensaje = json_decode($gs->getMessage());
            echo $mensaje->error->message;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}

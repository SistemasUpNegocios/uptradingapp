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

        ini_set('memory_limit', '512M');
    }
}

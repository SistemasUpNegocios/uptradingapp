<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Pendiente;
use App\Models\Contrato;
use App\Models\Amortizacion;
use App\Models\PagoCliente;
use App\Models\Cliente;
use App\Models\PagoPS;
use Carbon\Carbon;
use App\Mail\CumpleEmail;
use App\Mail\CheckListEmail;
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
            $pendientes = Pendiente::join("ps", "ps.id", "=", "pendiente.ps_id")->select(DB::raw("*,  CONCAT(ps.nombre, ' ', ps.apellido_p, ' ', ps.apellido_m) AS psnombre"))->where("pendiente.primer_reporte", "Pendiente")->get();
            $fecha = \Carbon\Carbon::parse(date('d-m-Y'))->formatLocalized('%d de %B de %Y');
            
            if(sizeof($pendientes) > 0){
                Mail::to("administracion@upnegocios.com")->send(new CheckListEmail($pendientes, $fecha));
            }
        })
        ->weekdays()
        ->dailyAt("08:00")
        ->timezone('America/Mexico_City');

        // Tarea para refrendar contratos
        $schedule->call(function () {
            //Consulta de contratos a un día de vencer
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDay()->format('Y-m-d'))
            ->where(function ($query) {
                $query->where("nota_contrato", NULL)
                ->orWhere("nota_contrato", "");
            })->get();

            foreach ($contratos as $contrato_update) {
                //Actualizar contrato
                $contrato = Contrato::find($contrato_update->id);
                
                //Actualizar numero de contrato
                $contratoAct = explode("-", $contrato_update->contrato);
                $contratoRef = intval($contratoAct[2]) + 1;
                $contratoRef = str_pad($contratoRef, 2, "0", STR_PAD_LEFT);
                $contratoRef = $contratoAct[0] . "-" . $contratoAct[1] . "-" . $contratoRef;

                //Guardar cambios de contrato
                $contrato->contrato = strtoupper($contratoRef);
                $contrato->fecha = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $contrato->fecha_renovacion = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->fecha_pago = Carbon::parse($contrato_update->fecha_pago)->addYear()->format('Y-m-d');
                $contrato->fecha_limite = Carbon::parse($contrato_update->fecha_limite)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";
                $contrato->update();

                //Actualización de tabla de amortizaciones
                $amortizaciones = Amortizacion::where("contrato_id", $contrato_update->id)->get();
                foreach ($amortizaciones as $amortizacion_update) {
                    $amortizacion = Amortizacion::find($amortizacion_update->id);
                    $amortizacion->fecha = Carbon::parse($amortizacion_update->fecha)->addYear()->format('Y-m-d');
                    $amortizacion->update();
                }

                //Actualización de tabla de pago de clientes
                $pagos_clientes = PagoCliente::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_clientes as $pago_cliente_update) {
                    $pago_cliente = PagoCliente::find($pago_cliente_update->id);
                    $pago_cliente->fecha_pago = Carbon::parse($pago_cliente_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_cliente->update();
                }

                //Actualización de tabla de pago de ps
                $pagos_ps = PagoPS::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_ps as $pago_ps_update) {
                    $pago_ps = PagoPS::find($pago_ps_update->id);
                    $pago_ps->fecha_pago = Carbon::parse($pago_ps_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_limite = Carbon::parse($pago_ps_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps->update();
                }
            }
        })
        ->dailyAt("09:00")
        ->timezone('America/Mexico_City');

        //Tarea para mandar mensaje de cumpleaños
        $schedule->call(function () { 
            $clientes = DB::table('cliente')
                ->select('id', 'nombre', 'correo_personal', 'mensaje')
                ->whereRaw('DAY(fecha_nac) = DAY(CURDATE())')
                ->whereRaw('MONTH(fecha_nac) = MONTH(CURDATE())')
                ->get();
    
                
            if (sizeof($clientes) > 0) {
                foreach ($clientes as $cliente) {
                    if($cliente->mensaje == "NO"){
    
                        Mail::to($cliente->correo_personal)->send(new CumpleEmail($cliente->nombre));
    
                        $clientes_update = Cliente::find($cliente->id);
                        $clientes_update->mensaje = "SI";
                        $clientes_update->save();
                    }
                }
            }else{
                Cliente::whereRaw('DAY(fecha_nac) != DAY(CURDATE())')
                    ->whereRaw('MONTH(fecha_nac) = MONTH(CURDATE())')
                    ->update(['mensaje' => 'NO']);
            }
        })->dailyAt("10:00")->timezone('America/Mexico_City');
        
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
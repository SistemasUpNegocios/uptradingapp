<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Pendiente;
use App\Models\Contrato;
use App\Models\Convenio;
use App\Models\PagoPSConvenio;
use App\Models\Amortizacion;
use App\Models\PagoCliente;
use App\Models\Ticket;
use App\Models\Notificacion;
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
use Luecano\NumeroALetras\NumeroALetras;

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

        // Tareas para refrendar contratos
        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_contrato", NULL)->orWhere("nota_contrato", ""); })
            ->get();

            foreach ($contratos as $contrato_update) {
                $tipo_contrato = DB::table('tipo_contrato')->where('id', $contrato_update->tipo_id)->first();
                $contrato = Contrato::find($contrato_update->id);
                
                // Actualizar numero de contrato
                $contratoAct = explode("-", $contrato_update->contrato);
                $contratoRef = intval($contratoAct[2]) + 1;
                $contratoRef = str_pad($contratoRef, 2, "0", STR_PAD_LEFT);
                $contratoRef = $contratoAct[0] . "-" . $contratoAct[1] . "-" . $contratoRef;

                // Crear ticket
                $ticket = new Ticket;
                $ticket->generado_por = 1;
                $ticket->asignado_a = "234".','.Carbon::now()->toDateTimeString();
                $ticket->fecha_generado = Carbon::now()->toDateTimeString();
                $ticket->fecha_limite = Carbon::now()->addDays(5)->toDateTimeString();
                $ticket->departamento = "Administración";
                $ticket->asunto = "Contrato refrendado para imprimir";
                $ticket->descripcion = "Contrato: ".strtoupper($contratoRef);
                $ticket->status = "Abierto";
                $ticket->save();

                $notificacion = new Notificacion;
                $notificacion->titulo = "Ticket abierto";
                $notificacion->mensaje = "Puede ser que tengas algún ticket abierto";
                $notificacion->status = "Pendiente";
                $notificacion->user_id = 234;
                $notificacion->save();

                $ticket = new Ticket;
                $ticket->generado_por = 1;
                $ticket->asignado_a = "235".','.Carbon::now()->toDateTimeString();
                $ticket->fecha_generado = Carbon::now()->toDateTimeString();
                $ticket->fecha_limite = Carbon::now()->addDays(5)->toDateTimeString();
                $ticket->departamento = "Administración";
                $ticket->asunto = "Contrato refrendado para imprimir";
                $ticket->descripcion = "Contrato: ".strtoupper($contratoRef);
                $ticket->status = "Abierto";
                $ticket->save();

                $notificacion = new Notificacion;
                $notificacion->titulo = "Ticket abierto";
                $notificacion->mensaje = "Puede ser que tengas algún ticket abierto";
                $notificacion->status = "Pendiente";
                $notificacion->user_id = 235;
                $notificacion->save();

                //Obtener el refrendo
                $pago = $contrato_update->inversion_us;
                $inversion = $contrato_update->inversion;
                $inversion_us = $contrato_update->inversion_us;
                $porcentaje = $contrato_update->porcentaje * 0.01;
                $meses = intval($contrato_update->periodo);

                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < $meses; $i++) {
                        $inversion_us = $inversion_us + $inversion_us * $porcentaje;
                        $inversion =  $inversion + $inversion * $porcentaje;
                    
                        $pago = $pago + $pago * $porcentaje;
                        $redito = $pago * $porcentaje;
                        $pago = $pago + $redito;
                    }
                }

                $formatter = new NumeroALetras();
                $inversion_letra = strtolower($formatter->toMoney($inversion, 2, "pesos", "centavos"));
                $inversion_letra_us = strtolower($formatter->toMoney($inversion_us, 2, "dólares", "centavos"));

                //Guardar cambios de contrato
                $contrato->contrato = strtoupper($contratoRef);

                // Actualizar fechas y status
                $contrato->fecha = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $contrato->fecha_renovacion = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->fecha_pago = Carbon::parse($contrato_update->fecha_pago)->addYear()->format('Y-m-d');
                $contrato->fecha_limite = Carbon::parse($contrato_update->fecha_limite)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->save();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
                
                //Fechas de pago refrendadas
                $fecha_inicio = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $fecha_pago = Carbon::parse($fecha_inicio);
                $fecha_amortizacion = Carbon::parse($fecha_inicio);
                $fecha_cond = Carbon::parse($fecha_inicio);
                $fecha_feb = Carbon::parse($fecha_inicio);
                $fecha_nueva = Carbon::parse($fecha_inicio);
                $fechaFeb = Carbon::parse($fecha_inicio);

                $mes_pago_ps = Carbon::parse($fecha_inicio)->format('m');
                $anio_pago_ps = Carbon::parse($fecha_inicio)->format('Y');
                $mes_pago_ps = $mes_pago_ps + 1;
                $mes_pago_ps = str_pad($mes_pago_ps, 2, "0", STR_PAD_LEFT);

                if ($mes_pago_ps == 13) {
                    $anio_pago_ps = $anio_pago_ps + 1;
                    $fecha_limite = $anio_pago_ps . "-01-10";                
                }else{
                    $fecha_limite = $anio_pago_ps . "-" . $mes_pago_ps . "-10";
                }

                $rendimiento = $contrato_update->porcentaje;
                $rendimiento = $rendimiento * .01;

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_apertura = $inversion_us * .02;
                $pago_ps_mensual = $inversion_us * $cmensual;
                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
                        
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');            
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
                        $monto = ($monto + $redito);
                    }
    
                    $pago_cliente = $amortizacion_saldo_con_redito;
                    $fecha_pago_cliente_inicial = $amortizacion_fecha;
    
                    $fecha_pago_cliente = Carbon::parse($fecha_pago_cliente_inicial);
    
                    $pago_cliente_table = new PagoCliente;
                    $pago_cliente_table->contrato_id = $contrato_update->id;
                    $pago_cliente_table->serie = ($i + 1);
                    $pago_cliente_table->fecha_pago = $fecha_pago_cliente;
                    $pago_cliente_table->pago = $pago_cliente;
                    $pago_cliente_table->status = "Pendiente";
                    $pago_cliente_table->tipo_pago = "Pendiente";
                    $pago_cliente_table->save();
                } elseif ($tipo_contrato->id == 1) {
                    $fecha_pago_cliente = Carbon::parse($fecha_inicio);
    
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
    
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                        $pago_cliente_table = new PagoCliente;
                        $pago_cliente_table->contrato_id = $contrato_update->id;
                        $pago_cliente_table->serie = ($i + 1);                
                        $pago_cliente_table->pago = $redito;
                        $pago_cliente_table->status = "Pendiente";
                        $pago_cliente_table->tipo_pago = "Pendiente";
                        $pago_cliente_table->fecha_pago = $amortizacion_fecha;
                        $pago_cliente_table->save();
                    }
                }

                //Actualización de tabla de amortizaciones
                $amortizaciones = Amortizacion::where("contrato_id", $contrato_update->id)->get();
                foreach ($amortizaciones as $amortizacion_update) {
                    $amortizacion = Amortizacion::find($amortizacion_update->id);
                    $amortizacion->fecha = Carbon::parse($amortizacion_update->fecha)->addYear()->format('Y-m-d');
                    $amortizacion->monto = $monto;
                    if ($tipo_contrato->id == 2) {
                        $redito = $monto * $porcentaje;
                        $saldo_con_redito = $monto + $redito;
                        $monto = $saldo_con_redito;
                    }

                    $amortizacion->redito = $redito;
                    $amortizacion->saldo_con_redito = $saldo_con_redito;
                    $amortizacion->update();
                }
            }

            $convenios = Convenio::where("convenio.status", "Activado")
            ->where("fecha_fin", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_convenio", NULL)->orWhere("nota_convenio", ""); })
            ->get();

            foreach ($convenios as $convenio_update) {
                $convenio = Convenio::find($convenio_update->id);

                //Refrendar folio
                $folio = explode("-", $convenio_update->folio);
                $refrendo = intval($folio[4]) + 1;
                $refrendo = str_pad($refrendo, 2, "0", STR_PAD_LEFT);
                $folio_completo = $folio[0].'-'.$folio[1].'-'.$folio[2].'-'.$folio[3].'-'.$refrendo;

                // Crear ticket
                $ticket = new Ticket;
                $ticket->generado_por = 1;
                $ticket->asignado_a = "234".','.Carbon::now()->toDateTimeString();
                $ticket->fecha_generado = Carbon::now()->toDateTimeString();
                $ticket->fecha_limite = Carbon::now()->addDays(5)->toDateTimeString();
                $ticket->departamento = "Administración";
                $ticket->asunto = "Convenio refrendado para imprimir";
                $ticket->descripcion = "Convenio: ".strtoupper($folio_completo);
                $ticket->status = "Abierto";
                $ticket->save();

                $notificacion = new Notificacion;
                $notificacion->titulo = "Ticket abierto";
                $notificacion->mensaje = "Puede ser que tengas algún ticket abierto";
                $notificacion->status = "Pendiente";
                $notificacion->user_id = 234;
                $notificacion->save();

                $ticket = new Ticket;
                $ticket->generado_por = 1;
                $ticket->asignado_a = "235".','.Carbon::now()->toDateTimeString();
                $ticket->fecha_generado = Carbon::now()->toDateTimeString();
                $ticket->fecha_limite = Carbon::now()->addDays(5)->toDateTimeString();
                $ticket->departamento = "Administración";
                $ticket->asunto = "Convenio refrendado para imprimir";
                $ticket->descripcion = "Convenio: ".strtoupper($folio_completo);
                $ticket->status = "Abierto";
                $ticket->save();

                $notificacion = new Notificacion;
                $notificacion->titulo = "Ticket abierto";
                $notificacion->mensaje = "Puede ser que tengas algún ticket abierto";
                $notificacion->status = "Pendiente";
                $notificacion->user_id = 235;
                $notificacion->save();

                //Actualizar numero de folio
                $convenio->folio = strtoupper($folio_completo);

                // Actualizar fechas y status
                $convenio->fecha_inicio = Carbon::parse($convenio_update->fecha_inicio)->addYear()->format('Y-m-d');
                $convenio->fecha_fin = Carbon::parse($convenio_update->fecha_fin)->addYear()->format('Y-m-d');
                $convenio->status = "Activado";
                $convenio->status_oficina = "Activado";
                $convenio->memo_status = "Convenio activado por id:1";

                // Dejar todo por defecto
                $convenio->nota_convenio = NULL;
                $convenio->autorizacion_nota = NULL;
                $convenio->save();

                $pagos_ps_convenio = PagoPSConvenio::where("convenio_id", $convenio_update->id)->get();
                foreach ($pagos_ps_convenio as $pago_ps_convenio_update) {
                    DB::table('pago_ps_convenio')->where('convenio_id', '=', $convenio_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps_convenio = PagoPSConvenio::find($pago_ps_convenio_update->id);
                    $pago_ps_convenio->fecha_pago = Carbon::parse($pago_ps_convenio_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->fecha_limite = Carbon::parse($pago_ps_convenio_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->save();
                }
            }
        })
        ->dailyAt("09:00")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_contrato", NULL)->orWhere("nota_contrato", ""); })
            ->get();

            foreach ($contratos as $contrato_update) {
                //Actualizar contrato
                $tipo_contrato = DB::table('tipo_contrato')->where('id', $contrato_update->tipo_id)->first();
                $contrato = Contrato::find($contrato_update->id);
                
                // Actualizar numero de contrato
                $contratoAct = explode("-", $contrato_update->contrato);
                $contratoRef = intval($contratoAct[2]) + 1;
                $contratoRef = str_pad($contratoRef, 2, "0", STR_PAD_LEFT);
                $contratoRef = $contratoAct[0] . "-" . $contratoAct[1] . "-" . $contratoRef;

                //Obtener el refrendo
                $pago = $contrato_update->inversion_us;
                $inversion = $contrato_update->inversion;
                $inversion_us = $contrato_update->inversion_us;
                $porcentaje = $contrato_update->porcentaje * 0.01;
                $meses = intval($contrato_update->periodo);

                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < $meses; $i++) {
                        $inversion_us = $inversion_us + $inversion_us * $porcentaje;
                        $inversion =  $inversion + $inversion * $porcentaje;
                    
                        $pago = $pago + $pago * $porcentaje;
                        $redito = $pago * $porcentaje;
                        $pago = $pago + $redito;
                    }
                }

                $formatter = new NumeroALetras();
                $inversion_letra = strtolower($formatter->toMoney($inversion, 2, "pesos", "centavos"));
                $inversion_letra_us = strtolower($formatter->toMoney($inversion_us, 2, "dólares", "centavos"));

                //Guardar cambios de contrato
                $contrato->contrato = strtoupper($contratoRef);

                // Actualizar fechas y status
                $contrato->fecha = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $contrato->fecha_renovacion = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->fecha_pago = Carbon::parse($contrato_update->fecha_pago)->addYear()->format('Y-m-d');
                $contrato->fecha_limite = Carbon::parse($contrato_update->fecha_limite)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->save();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;

                //Fechas de pago refrendadas
                $fecha_inicio = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $fecha_pago = Carbon::parse($fecha_inicio);
                $fecha_amortizacion = Carbon::parse($fecha_inicio);
                $fecha_cond = Carbon::parse($fecha_inicio);
                $fecha_feb = Carbon::parse($fecha_inicio);
                $fecha_nueva = Carbon::parse($fecha_inicio);
                $fechaFeb = Carbon::parse($fecha_inicio);

                $mes_pago_ps = Carbon::parse($fecha_inicio)->format('m');
                $anio_pago_ps = Carbon::parse($fecha_inicio)->format('Y');
                $mes_pago_ps = $mes_pago_ps + 1;
                $mes_pago_ps = str_pad($mes_pago_ps, 2, "0", STR_PAD_LEFT);

                if ($mes_pago_ps == 13) {
                    $anio_pago_ps = $anio_pago_ps + 1;
                    $fecha_limite = $anio_pago_ps . "-01-10";                
                }else{
                    $fecha_limite = $anio_pago_ps . "-" . $mes_pago_ps . "-10";
                }

                $rendimiento = $contrato_update->porcentaje;
                $rendimiento = $rendimiento * .01;

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_apertura = $inversion_us * .02;
                $pago_ps_mensual = $inversion_us * $cmensual;
                
                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $amortizacion = new Amortizacion;
                        $amortizacion->contrato_id = $contrato_update->id;
                        $amortizacion->serie = ($i + 1);
                        
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');            
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                    }
    
                    $pago_cliente = $amortizacion_saldo_con_redito;
                    $fecha_pago_cliente_inicial = $amortizacion_fecha;
    
                    $fecha_pago_cliente = Carbon::parse($fecha_pago_cliente_inicial);
    
                    $pago_cliente_table = new PagoCliente;
                    $pago_cliente_table->contrato_id = $contrato_update->id;
                    $pago_cliente_table->serie = ($i + 1);
                    $pago_cliente_table->fecha_pago = $fecha_pago_cliente;
                    $pago_cliente_table->pago = $pago_cliente;
                    $pago_cliente_table->status = "Pendiente";
                    $pago_cliente_table->tipo_pago = "Pendiente";
                    $pago_cliente_table->save();
                } elseif ($tipo_contrato->id == 1) {
                    $fecha_pago_cliente = Carbon::parse($fecha_inicio);
    
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
    
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                        $pago_cliente_table = new PagoCliente;
                        $pago_cliente_table->contrato_id = $contrato_update->id;
                        $pago_cliente_table->serie = ($i + 1);                
                        $pago_cliente_table->pago = $redito;
                        $pago_cliente_table->status = "Pendiente";
                        $pago_cliente_table->tipo_pago = "Pendiente";
                        $pago_cliente_table->fecha_pago = $amortizacion_fecha;
                        $pago_cliente_table->save();
                    }
                }

                //Actualización de tabla de amortizaciones
                $amortizaciones = Amortizacion::where("contrato_id", $contrato_update->id)->get();
                foreach ($amortizaciones as $amortizacion_update) {
                    $amortizacion = Amortizacion::find($amortizacion_update->id);
                    $amortizacion->fecha = Carbon::parse($amortizacion_update->fecha)->addYear()->format('Y-m-d');
                    $amortizacion->monto = $monto;
                    if ($tipo_contrato->id == 2) {
                        $redito = $monto * $porcentaje;
                        $saldo_con_redito = $monto + $redito;
                        $monto = $saldo_con_redito;
                    }

                    $amortizacion->redito = $redito;
                    $amortizacion->saldo_con_redito = $saldo_con_redito;
                    $amortizacion->update();
                }
            }

            $convenios = Convenio::where("convenio.status", "Activado")
            ->where("fecha_fin", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_convenio", NULL)->orWhere("nota_convenio", ""); })
            ->get();

            foreach ($convenios as $convenio_update) {
                $convenio = Convenio::find($convenio_update->id);

                //Refrendar folio
                $folio = explode("-", $convenio_update->folio);
                $refrendo = intval($folio[4]) + 1;
                $refrendo = str_pad($refrendo, 2, "0", STR_PAD_LEFT);
                $folio_completo = $folio[0].'-'.$folio[1].'-'.$folio[2].'-'.$folio[3].'-'.$refrendo;

                //Actualizar numero de folio
                $convenio->folio = strtoupper($folio_completo);

                // Actualizar fechas y status
                $convenio->fecha_inicio = Carbon::parse($convenio_update->fecha_inicio)->addYear()->format('Y-m-d');
                $convenio->fecha_fin = Carbon::parse($convenio_update->fecha_fin)->addYear()->format('Y-m-d');
                $convenio->status = "Activado";
                $convenio->status_oficina = "Activado";
                $convenio->memo_status = "Convenio activado por id:1";

                // Dejar todo por defecto
                $convenio->nota_convenio = NULL;
                $convenio->autorizacion_nota = NULL;
                $convenio->save();

                $pagos_ps_convenio = PagoPSConvenio::where("convenio_id", $convenio_update->id)->get();
                foreach ($pagos_ps_convenio as $pago_ps_convenio_update) {
                    DB::table('pago_ps_convenio')->where('convenio_id', '=', $convenio_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps_convenio = PagoPSConvenio::find($pago_ps_convenio_update->id);
                    $pago_ps_convenio->fecha_pago = Carbon::parse($pago_ps_convenio_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->fecha_limite = Carbon::parse($pago_ps_convenio_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->save();
                }
            }
        })
        ->dailyAt("09:10")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_contrato", NULL)->orWhere("nota_contrato", ""); })
            ->get();

            foreach ($contratos as $contrato_update) {
                //Actualizar contrato
                $tipo_contrato = DB::table('tipo_contrato')->where('id', $contrato_update->tipo_id)->first();
                $contrato = Contrato::find($contrato_update->id);
                
                // Actualizar numero de contrato
                $contratoAct = explode("-", $contrato_update->contrato);
                $contratoRef = intval($contratoAct[2]) + 1;
                $contratoRef = str_pad($contratoRef, 2, "0", STR_PAD_LEFT);
                $contratoRef = $contratoAct[0] . "-" . $contratoAct[1] . "-" . $contratoRef;

                //Obtener el refrendo
                $pago = $contrato_update->inversion_us;
                $inversion = $contrato_update->inversion;
                $inversion_us = $contrato_update->inversion_us;
                $porcentaje = $contrato_update->porcentaje * 0.01;
                $meses = intval($contrato_update->periodo);

                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < $meses; $i++) {
                        $inversion_us = $inversion_us + $inversion_us * $porcentaje;
                        $inversion =  $inversion + $inversion * $porcentaje;
                    
                        $pago = $pago + $pago * $porcentaje;
                        $redito = $pago * $porcentaje;
                        $pago = $pago + $redito;
                    }
                }

                $formatter = new NumeroALetras();
                $inversion_letra = strtolower($formatter->toMoney($inversion, 2, "pesos", "centavos"));
                $inversion_letra_us = strtolower($formatter->toMoney($inversion_us, 2, "dólares", "centavos"));

                //Guardar cambios de contrato
                $contrato->contrato = strtoupper($contratoRef);

                // Actualizar fechas y status
                $contrato->fecha = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $contrato->fecha_renovacion = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->fecha_pago = Carbon::parse($contrato_update->fecha_pago)->addYear()->format('Y-m-d');
                $contrato->fecha_limite = Carbon::parse($contrato_update->fecha_limite)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->save();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
                
                //Fechas de pago refrendadas
                $fecha_inicio = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $fecha_pago = Carbon::parse($fecha_inicio);
                $fecha_amortizacion = Carbon::parse($fecha_inicio);
                $fecha_cond = Carbon::parse($fecha_inicio);
                $fecha_feb = Carbon::parse($fecha_inicio);
                $fecha_nueva = Carbon::parse($fecha_inicio);
                $fechaFeb = Carbon::parse($fecha_inicio);

                $mes_pago_ps = Carbon::parse($fecha_inicio)->format('m');
                $anio_pago_ps = Carbon::parse($fecha_inicio)->format('Y');
                $mes_pago_ps = $mes_pago_ps + 1;
                $mes_pago_ps = str_pad($mes_pago_ps, 2, "0", STR_PAD_LEFT);

                if ($mes_pago_ps == 13) {
                    $anio_pago_ps = $anio_pago_ps + 1;
                    $fecha_limite = $anio_pago_ps . "-01-10";                
                }else{
                    $fecha_limite = $anio_pago_ps . "-" . $mes_pago_ps . "-10";
                }

                $rendimiento = $contrato_update->porcentaje;
                $rendimiento = $rendimiento * .01;

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_apertura = $inversion_us * .02;
                $pago_ps_mensual = $inversion_us * $cmensual;
                
                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $amortizacion = new Amortizacion;
                        $amortizacion->contrato_id = $contrato_update->id;
                        $amortizacion->serie = ($i + 1);
                        
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');            
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                    }
    
                    $pago_cliente = $amortizacion_saldo_con_redito;
                    $fecha_pago_cliente_inicial = $amortizacion_fecha;
    
                    $fecha_pago_cliente = Carbon::parse($fecha_pago_cliente_inicial);
    
                    $pago_cliente_table = new PagoCliente;
                    $pago_cliente_table->contrato_id = $contrato_update->id;
                    $pago_cliente_table->serie = ($i + 1);
                    $pago_cliente_table->fecha_pago = $fecha_pago_cliente;
                    $pago_cliente_table->pago = $pago_cliente;
                    $pago_cliente_table->status = "Pendiente";
                    $pago_cliente_table->tipo_pago = "Pendiente";
                    $pago_cliente_table->save();
                } elseif ($tipo_contrato->id == 1) {
                    $fecha_pago_cliente = Carbon::parse($fecha_inicio);
    
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
    
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                        $pago_cliente_table = new PagoCliente;
                        $pago_cliente_table->contrato_id = $contrato_update->id;
                        $pago_cliente_table->serie = ($i + 1);                
                        $pago_cliente_table->pago = $redito;
                        $pago_cliente_table->status = "Pendiente";
                        $pago_cliente_table->tipo_pago = "Pendiente";
                        $pago_cliente_table->fecha_pago = $amortizacion_fecha;
                        $pago_cliente_table->save();
                    }
                }

                //Actualización de tabla de amortizaciones
                $amortizaciones = Amortizacion::where("contrato_id", $contrato_update->id)->get();
                foreach ($amortizaciones as $amortizacion_update) {
                    $amortizacion = Amortizacion::find($amortizacion_update->id);
                    $amortizacion->fecha = Carbon::parse($amortizacion_update->fecha)->addYear()->format('Y-m-d');
                    $amortizacion->monto = $monto;
                    if ($tipo_contrato->id == 2) {
                        $redito = $monto * $porcentaje;
                        $saldo_con_redito = $monto + $redito;
                        $monto = $saldo_con_redito;
                    }

                    $amortizacion->redito = $redito;
                    $amortizacion->saldo_con_redito = $saldo_con_redito;
                    $amortizacion->update();
                }
            }

            $convenios = Convenio::where("convenio.status", "Activado")
            ->where("fecha_fin", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_convenio", NULL)->orWhere("nota_convenio", ""); })
            ->get();

            foreach ($convenios as $convenio_update) {
                $convenio = Convenio::find($convenio_update->id);

                //Refrendar folio
                $folio = explode("-", $convenio_update->folio);
                $refrendo = intval($folio[4]) + 1;
                $refrendo = str_pad($refrendo, 2, "0", STR_PAD_LEFT);
                $folio_completo = $folio[0].'-'.$folio[1].'-'.$folio[2].'-'.$folio[3].'-'.$refrendo;

                //Actualizar numero de folio
                $convenio->folio = strtoupper($folio_completo);

                // Actualizar fechas y status
                $convenio->fecha_inicio = Carbon::parse($convenio_update->fecha_inicio)->addYear()->format('Y-m-d');
                $convenio->fecha_fin = Carbon::parse($convenio_update->fecha_fin)->addYear()->format('Y-m-d');
                $convenio->status = "Activado";
                $convenio->status_oficina = "Activado";
                $convenio->memo_status = "Convenio activado por id:1";

                // Dejar todo por defecto
                $convenio->nota_convenio = NULL;
                $convenio->autorizacion_nota = NULL;
                $convenio->save();

                $pagos_ps_convenio = PagoPSConvenio::where("convenio_id", $convenio_update->id)->get();
                foreach ($pagos_ps_convenio as $pago_ps_convenio_update) {
                    DB::table('pago_ps_convenio')->where('convenio_id', '=', $convenio_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps_convenio = PagoPSConvenio::find($pago_ps_convenio_update->id);
                    $pago_ps_convenio->fecha_pago = Carbon::parse($pago_ps_convenio_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->fecha_limite = Carbon::parse($pago_ps_convenio_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->save();
                }
            }
        })
        ->dailyAt("09:20")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_contrato", NULL)->orWhere("nota_contrato", ""); })
            ->get();

            foreach ($contratos as $contrato_update) {
                //Actualizar contrato
                $tipo_contrato = DB::table('tipo_contrato')->where('id', $contrato_update->tipo_id)->first();
                $contrato = Contrato::find($contrato_update->id);
                
                // Actualizar numero de contrato
                $contratoAct = explode("-", $contrato_update->contrato);
                $contratoRef = intval($contratoAct[2]) + 1;
                $contratoRef = str_pad($contratoRef, 2, "0", STR_PAD_LEFT);
                $contratoRef = $contratoAct[0] . "-" . $contratoAct[1] . "-" . $contratoRef;

                //Obtener el refrendo
                $pago = $contrato_update->inversion_us;
                $inversion = $contrato_update->inversion;
                $inversion_us = $contrato_update->inversion_us;
                $porcentaje = $contrato_update->porcentaje * 0.01;
                $meses = intval($contrato_update->periodo);

                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < $meses; $i++) {
                        $inversion_us = $inversion_us + $inversion_us * $porcentaje;
                        $inversion =  $inversion + $inversion * $porcentaje;
                    
                        $pago = $pago + $pago * $porcentaje;
                        $redito = $pago * $porcentaje;
                        $pago = $pago + $redito;
                    }
                }

                $formatter = new NumeroALetras();
                $inversion_letra = strtolower($formatter->toMoney($inversion, 2, "pesos", "centavos"));
                $inversion_letra_us = strtolower($formatter->toMoney($inversion_us, 2, "dólares", "centavos"));

                //Guardar cambios de contrato
                $contrato->contrato = strtoupper($contratoRef);

                // Actualizar fechas y status
                $contrato->fecha = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $contrato->fecha_renovacion = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->fecha_pago = Carbon::parse($contrato_update->fecha_pago)->addYear()->format('Y-m-d');
                $contrato->fecha_limite = Carbon::parse($contrato_update->fecha_limite)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->save();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
                
                //Fechas de pago refrendadas
                $fecha_inicio = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $fecha_pago = Carbon::parse($fecha_inicio);
                $fecha_amortizacion = Carbon::parse($fecha_inicio);
                $fecha_cond = Carbon::parse($fecha_inicio);
                $fecha_feb = Carbon::parse($fecha_inicio);
                $fecha_nueva = Carbon::parse($fecha_inicio);
                $fechaFeb = Carbon::parse($fecha_inicio);

                $mes_pago_ps = Carbon::parse($fecha_inicio)->format('m');
                $anio_pago_ps = Carbon::parse($fecha_inicio)->format('Y');
                $mes_pago_ps = $mes_pago_ps + 1;
                $mes_pago_ps = str_pad($mes_pago_ps, 2, "0", STR_PAD_LEFT);

                if ($mes_pago_ps == 13) {
                    $anio_pago_ps = $anio_pago_ps + 1;
                    $fecha_limite = $anio_pago_ps . "-01-10";                
                }else{
                    $fecha_limite = $anio_pago_ps . "-" . $mes_pago_ps . "-10";
                }

                $rendimiento = $contrato_update->porcentaje;
                $rendimiento = $rendimiento * .01;

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_apertura = $inversion_us * .02;
                $pago_ps_mensual = $inversion_us * $cmensual;
                
                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $amortizacion = new Amortizacion;
                        $amortizacion->contrato_id = $contrato_update->id;
                        $amortizacion->serie = ($i + 1);
                        
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');            
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                    }
    
                    $pago_cliente = $amortizacion_saldo_con_redito;
                    $fecha_pago_cliente_inicial = $amortizacion_fecha;
    
                    $fecha_pago_cliente = Carbon::parse($fecha_pago_cliente_inicial);
    
                    $pago_cliente_table = new PagoCliente;
                    $pago_cliente_table->contrato_id = $contrato_update->id;
                    $pago_cliente_table->serie = ($i + 1);
                    $pago_cliente_table->fecha_pago = $fecha_pago_cliente;
                    $pago_cliente_table->pago = $pago_cliente;
                    $pago_cliente_table->status = "Pendiente";
                    $pago_cliente_table->tipo_pago = "Pendiente";
                    $pago_cliente_table->save();
                } elseif ($tipo_contrato->id == 1) {
                    $fecha_pago_cliente = Carbon::parse($fecha_inicio);
    
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
    
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                        $pago_cliente_table = new PagoCliente;
                        $pago_cliente_table->contrato_id = $contrato_update->id;
                        $pago_cliente_table->serie = ($i + 1);                
                        $pago_cliente_table->pago = $redito;
                        $pago_cliente_table->status = "Pendiente";
                        $pago_cliente_table->tipo_pago = "Pendiente";
                        $pago_cliente_table->fecha_pago = $amortizacion_fecha;
                        $pago_cliente_table->save();
                    }
                }

                //Actualización de tabla de amortizaciones
                $amortizaciones = Amortizacion::where("contrato_id", $contrato_update->id)->get();
                foreach ($amortizaciones as $amortizacion_update) {
                    $amortizacion = Amortizacion::find($amortizacion_update->id);
                    $amortizacion->fecha = Carbon::parse($amortizacion_update->fecha)->addYear()->format('Y-m-d');
                    $amortizacion->monto = $monto;
                    if ($tipo_contrato->id == 2) {
                        $redito = $monto * $porcentaje;
                        $saldo_con_redito = $monto + $redito;
                        $monto = $saldo_con_redito;
                    }

                    $amortizacion->redito = $redito;
                    $amortizacion->saldo_con_redito = $saldo_con_redito;
                    $amortizacion->update();
                }
            }

            $convenios = Convenio::where("convenio.status", "Activado")
            ->where("fecha_fin", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_convenio", NULL)->orWhere("nota_convenio", ""); })
            ->get();

            foreach ($convenios as $convenio_update) {
                $convenio = Convenio::find($convenio_update->id);

                //Refrendar folio
                $folio = explode("-", $convenio_update->folio);
                $refrendo = intval($folio[4]) + 1;
                $refrendo = str_pad($refrendo, 2, "0", STR_PAD_LEFT);
                $folio_completo = $folio[0].'-'.$folio[1].'-'.$folio[2].'-'.$folio[3].'-'.$refrendo;

                //Actualizar numero de folio
                $convenio->folio = strtoupper($folio_completo);

                // Actualizar fechas y status
                $convenio->fecha_inicio = Carbon::parse($convenio_update->fecha_inicio)->addYear()->format('Y-m-d');
                $convenio->fecha_fin = Carbon::parse($convenio_update->fecha_fin)->addYear()->format('Y-m-d');
                $convenio->status = "Activado";
                $convenio->status_oficina = "Activado";
                $convenio->memo_status = "Convenio activado por id:1";

                // Dejar todo por defecto
                $convenio->nota_convenio = NULL;
                $convenio->autorizacion_nota = NULL;
                $convenio->save();

                $pagos_ps_convenio = PagoPSConvenio::where("convenio_id", $convenio_update->id)->get();
                foreach ($pagos_ps_convenio as $pago_ps_convenio_update) {
                    DB::table('pago_ps_convenio')->where('convenio_id', '=', $convenio_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps_convenio = PagoPSConvenio::find($pago_ps_convenio_update->id);
                    $pago_ps_convenio->fecha_pago = Carbon::parse($pago_ps_convenio_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->fecha_limite = Carbon::parse($pago_ps_convenio_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->save();
                }
            }
        })
        ->dailyAt("09:30")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_contrato", NULL)->orWhere("nota_contrato", ""); })
            ->get();

            foreach ($contratos as $contrato_update) {
                //Actualizar contrato
                $tipo_contrato = DB::table('tipo_contrato')->where('id', $contrato_update->tipo_id)->first();
                $contrato = Contrato::find($contrato_update->id);
                
                // Actualizar numero de contrato
                $contratoAct = explode("-", $contrato_update->contrato);
                $contratoRef = intval($contratoAct[2]) + 1;
                $contratoRef = str_pad($contratoRef, 2, "0", STR_PAD_LEFT);
                $contratoRef = $contratoAct[0] . "-" . $contratoAct[1] . "-" . $contratoRef;

                //Obtener el refrendo
                $pago = $contrato_update->inversion_us;
                $inversion = $contrato_update->inversion;
                $inversion_us = $contrato_update->inversion_us;
                $porcentaje = $contrato_update->porcentaje * 0.01;
                $meses = intval($contrato_update->periodo);

                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < $meses; $i++) {
                        $inversion_us = $inversion_us + $inversion_us * $porcentaje;
                        $inversion =  $inversion + $inversion * $porcentaje;
                    
                        $pago = $pago + $pago * $porcentaje;
                        $redito = $pago * $porcentaje;
                        $pago = $pago + $redito;
                    }
                }

                $formatter = new NumeroALetras();
                $inversion_letra = strtolower($formatter->toMoney($inversion, 2, "pesos", "centavos"));
                $inversion_letra_us = strtolower($formatter->toMoney($inversion_us, 2, "dólares", "centavos"));

                //Guardar cambios de contrato
                $contrato->contrato = strtoupper($contratoRef);

                // Actualizar fechas y status
                $contrato->fecha = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $contrato->fecha_renovacion = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->fecha_pago = Carbon::parse($contrato_update->fecha_pago)->addYear()->format('Y-m-d');
                $contrato->fecha_limite = Carbon::parse($contrato_update->fecha_limite)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->save();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
                
                //Fechas de pago refrendadas
                $fecha_inicio = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $fecha_pago = Carbon::parse($fecha_inicio);
                $fecha_amortizacion = Carbon::parse($fecha_inicio);
                $fecha_cond = Carbon::parse($fecha_inicio);
                $fecha_feb = Carbon::parse($fecha_inicio);
                $fecha_nueva = Carbon::parse($fecha_inicio);
                $fechaFeb = Carbon::parse($fecha_inicio);

                $mes_pago_ps = Carbon::parse($fecha_inicio)->format('m');
                $anio_pago_ps = Carbon::parse($fecha_inicio)->format('Y');
                $mes_pago_ps = $mes_pago_ps + 1;
                $mes_pago_ps = str_pad($mes_pago_ps, 2, "0", STR_PAD_LEFT);

                if ($mes_pago_ps == 13) {
                    $anio_pago_ps = $anio_pago_ps + 1;
                    $fecha_limite = $anio_pago_ps . "-01-10";                
                }else{
                    $fecha_limite = $anio_pago_ps . "-" . $mes_pago_ps . "-10";
                }

                $rendimiento = $contrato_update->porcentaje;
                $rendimiento = $rendimiento * .01;

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_apertura = $inversion_us * .02;
                $pago_ps_mensual = $inversion_us * $cmensual;
                
                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $amortizacion = new Amortizacion;
                        $amortizacion->contrato_id = $contrato_update->id;
                        $amortizacion->serie = ($i + 1);
                        
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');            
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                    }
    
                    $pago_cliente = $amortizacion_saldo_con_redito;
                    $fecha_pago_cliente_inicial = $amortizacion_fecha;
    
                    $fecha_pago_cliente = Carbon::parse($fecha_pago_cliente_inicial);
    
                    $pago_cliente_table = new PagoCliente;
                    $pago_cliente_table->contrato_id = $contrato_update->id;
                    $pago_cliente_table->serie = ($i + 1);
                    $pago_cliente_table->fecha_pago = $fecha_pago_cliente;
                    $pago_cliente_table->pago = $pago_cliente;
                    $pago_cliente_table->status = "Pendiente";
                    $pago_cliente_table->tipo_pago = "Pendiente";
                    $pago_cliente_table->save();
                } elseif ($tipo_contrato->id == 1) {
                    $fecha_pago_cliente = Carbon::parse($fecha_inicio);
    
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
    
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                        $pago_cliente_table = new PagoCliente;
                        $pago_cliente_table->contrato_id = $contrato_update->id;
                        $pago_cliente_table->serie = ($i + 1);                
                        $pago_cliente_table->pago = $redito;
                        $pago_cliente_table->status = "Pendiente";
                        $pago_cliente_table->tipo_pago = "Pendiente";
                        $pago_cliente_table->fecha_pago = $amortizacion_fecha;
                        $pago_cliente_table->save();
                    }
                }

                //Actualización de tabla de amortizaciones
                $amortizaciones = Amortizacion::where("contrato_id", $contrato_update->id)->get();
                foreach ($amortizaciones as $amortizacion_update) {
                    $amortizacion = Amortizacion::find($amortizacion_update->id);
                    $amortizacion->fecha = Carbon::parse($amortizacion_update->fecha)->addYear()->format('Y-m-d');
                    $amortizacion->monto = $monto;
                    if ($tipo_contrato->id == 2) {
                        $redito = $monto * $porcentaje;
                        $saldo_con_redito = $monto + $redito;
                        $monto = $saldo_con_redito;
                    }

                    $amortizacion->redito = $redito;
                    $amortizacion->saldo_con_redito = $saldo_con_redito;
                    $amortizacion->update();
                }
            }

            $convenios = Convenio::where("convenio.status", "Activado")
            ->where("fecha_fin", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_convenio", NULL)->orWhere("nota_convenio", ""); })
            ->get();

            foreach ($convenios as $convenio_update) {
                $convenio = Convenio::find($convenio_update->id);

                //Refrendar folio
                $folio = explode("-", $convenio_update->folio);
                $refrendo = intval($folio[4]) + 1;
                $refrendo = str_pad($refrendo, 2, "0", STR_PAD_LEFT);
                $folio_completo = $folio[0].'-'.$folio[1].'-'.$folio[2].'-'.$folio[3].'-'.$refrendo;

                //Actualizar numero de folio
                $convenio->folio = strtoupper($folio_completo);

                // Actualizar fechas y status
                $convenio->fecha_inicio = Carbon::parse($convenio_update->fecha_inicio)->addYear()->format('Y-m-d');
                $convenio->fecha_fin = Carbon::parse($convenio_update->fecha_fin)->addYear()->format('Y-m-d');
                $convenio->status = "Activado";
                $convenio->status_oficina = "Activado";
                $convenio->memo_status = "Convenio activado por id:1";

                // Dejar todo por defecto
                $convenio->nota_convenio = NULL;
                $convenio->autorizacion_nota = NULL;
                $convenio->save();

                $pagos_ps_convenio = PagoPSConvenio::where("convenio_id", $convenio_update->id)->get();
                foreach ($pagos_ps_convenio as $pago_ps_convenio_update) {
                    DB::table('pago_ps_convenio')->where('convenio_id', '=', $convenio_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps_convenio = PagoPSConvenio::find($pago_ps_convenio_update->id);
                    $pago_ps_convenio->fecha_pago = Carbon::parse($pago_ps_convenio_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->fecha_limite = Carbon::parse($pago_ps_convenio_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->save();
                }
            }
        })
        ->dailyAt("09:40")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_contrato", NULL)->orWhere("nota_contrato", ""); })
            ->get();

            foreach ($contratos as $contrato_update) {
                //Actualizar contrato
                $tipo_contrato = DB::table('tipo_contrato')->where('id', $contrato_update->tipo_id)->first();
                $contrato = Contrato::find($contrato_update->id);
                
                // Actualizar numero de contrato
                $contratoAct = explode("-", $contrato_update->contrato);
                $contratoRef = intval($contratoAct[2]) + 1;
                $contratoRef = str_pad($contratoRef, 2, "0", STR_PAD_LEFT);
                $contratoRef = $contratoAct[0] . "-" . $contratoAct[1] . "-" . $contratoRef;

                //Obtener el refrendo
                $pago = $contrato_update->inversion_us;
                $inversion = $contrato_update->inversion;
                $inversion_us = $contrato_update->inversion_us;
                $porcentaje = $contrato_update->porcentaje * 0.01;
                $meses = intval($contrato_update->periodo);

                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < $meses; $i++) {
                        $inversion_us = $inversion_us + $inversion_us * $porcentaje;
                        $inversion =  $inversion + $inversion * $porcentaje;
                    
                        $pago = $pago + $pago * $porcentaje;
                        $redito = $pago * $porcentaje;
                        $pago = $pago + $redito;
                    }
                }

                $formatter = new NumeroALetras();
                $inversion_letra = strtolower($formatter->toMoney($inversion, 2, "pesos", "centavos"));
                $inversion_letra_us = strtolower($formatter->toMoney($inversion_us, 2, "dólares", "centavos"));

                //Guardar cambios de contrato
                $contrato->contrato = strtoupper($contratoRef);

                // Actualizar fechas y status
                $contrato->fecha = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $contrato->fecha_renovacion = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->fecha_pago = Carbon::parse($contrato_update->fecha_pago)->addYear()->format('Y-m-d');
                $contrato->fecha_limite = Carbon::parse($contrato_update->fecha_limite)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->save();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
                
                //Fechas de pago refrendadas
                $fecha_inicio = Carbon::parse($contrato_update->fecha)->addYear()->format('Y-m-d');
                $fecha_pago = Carbon::parse($fecha_inicio);
                $fecha_amortizacion = Carbon::parse($fecha_inicio);
                $fecha_cond = Carbon::parse($fecha_inicio);
                $fecha_feb = Carbon::parse($fecha_inicio);
                $fecha_nueva = Carbon::parse($fecha_inicio);
                $fechaFeb = Carbon::parse($fecha_inicio);

                $mes_pago_ps = Carbon::parse($fecha_inicio)->format('m');
                $anio_pago_ps = Carbon::parse($fecha_inicio)->format('Y');
                $mes_pago_ps = $mes_pago_ps + 1;
                $mes_pago_ps = str_pad($mes_pago_ps, 2, "0", STR_PAD_LEFT);

                if ($mes_pago_ps == 13) {
                    $anio_pago_ps = $anio_pago_ps + 1;
                    $fecha_limite = $anio_pago_ps . "-01-10";                
                }else{
                    $fecha_limite = $anio_pago_ps . "-" . $mes_pago_ps . "-10";
                }

                $rendimiento = $contrato_update->porcentaje;
                $rendimiento = $rendimiento * .01;

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_apertura = $inversion_us * .02;
                $pago_ps_mensual = $inversion_us * $cmensual;
                
                if ($tipo_contrato->id == 2) {
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $amortizacion = new Amortizacion;
                        $amortizacion->contrato_id = $contrato_update->id;
                        $amortizacion->serie = ($i + 1);
                        
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');            
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                    }
    
                    $pago_cliente = $amortizacion_saldo_con_redito;
                    $fecha_pago_cliente_inicial = $amortizacion_fecha;
    
                    $fecha_pago_cliente = Carbon::parse($fecha_pago_cliente_inicial);
    
                    $pago_cliente_table = new PagoCliente;
                    $pago_cliente_table->contrato_id = $contrato_update->id;
                    $pago_cliente_table->serie = ($i + 1);
                    $pago_cliente_table->fecha_pago = $fecha_pago_cliente;
                    $pago_cliente_table->pago = $pago_cliente;
                    $pago_cliente_table->status = "Pendiente";
                    $pago_cliente_table->tipo_pago = "Pendiente";
                    $pago_cliente_table->save();
                } elseif ($tipo_contrato->id == 1) {
                    $fecha_pago_cliente = Carbon::parse($fecha_inicio);
    
                    for ($i = 0; $i < 12; $i++) {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                        $fecha_pago->format('Y-m-d');
    
                        $fecha_limite = Carbon::parse($fecha_limite);
                        $fecha_limite->addMonth();
    
                        $fecha_limite->format('Y-m-d');
    
                        if ($i == 0) {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_apertura, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión por apertura';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
    
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        } else {
                            $pagops = new PagoPS;
                            $pago = $inversion_us;
                            $pagops->contrato_id = $contrato_update->id;
                            $pagops->serie = ($i + 1);
                            $pagops->fecha_pago = $fecha_pago;
                            $pagops->fecha_limite = $fecha_limite;
                            $pagops->pago = round($pago_ps_mensual, 2);
                            $pagops->status = 'Pendiente';
                            $pagops->memo = 'Comisión mensual';
                            $pagops->tipo_pago = 'Pendiente';
                            $pagops->save();
                        }
    
                        $mes_cond = $fecha_cond->format('m');
                        if($mes_cond == 1){
                            $fechaFeb->subDays(3)->addMonth()->format('Y-m-d');
                        }else{
                            $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                        }
                        $fecha_cond = $fecha_cond->subDays(3)->addMonth();
                        $fecha_dia = $fecha_nueva->format('d');
                        $fecha_mes = $fechaFeb->format('m');
                        $fecha_anio = $fechaFeb->format('Y');
    
                        if ($fecha_mes == 2){
                            if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                                $amortizacion_fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                            }else{
                                $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                            }
                        }else if ($fecha_dia == 31){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else if($fecha_dia == 29 || $fecha_dia == 30){
                            $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                            $amortizacion_fecha = $fecha_amortizacion->format('Y-m-d');
                        }else{
                            $amortizacion_fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
    
                        $redito = $monto * $rendimiento;
                        $amortizacion_saldo_con_redito = round(($monto + $redito), 2);
    
                        $pago_cliente_table = new PagoCliente;
                        $pago_cliente_table->contrato_id = $contrato_update->id;
                        $pago_cliente_table->serie = ($i + 1);                
                        $pago_cliente_table->pago = $redito;
                        $pago_cliente_table->status = "Pendiente";
                        $pago_cliente_table->tipo_pago = "Pendiente";
                        $pago_cliente_table->fecha_pago = $amortizacion_fecha;
                        $pago_cliente_table->save();
                    }
                }

                //Actualización de tabla de amortizaciones
                $amortizaciones = Amortizacion::where("contrato_id", $contrato_update->id)->get();
                foreach ($amortizaciones as $amortizacion_update) {
                    $amortizacion = Amortizacion::find($amortizacion_update->id);
                    $amortizacion->fecha = Carbon::parse($amortizacion_update->fecha)->addYear()->format('Y-m-d');
                    $amortizacion->monto = $monto;
                    if ($tipo_contrato->id == 2) {
                        $redito = $monto * $porcentaje;
                        $saldo_con_redito = $monto + $redito;
                        $monto = $saldo_con_redito;
                    }

                    $amortizacion->redito = $redito;
                    $amortizacion->saldo_con_redito = $saldo_con_redito;
                    $amortizacion->update();
                }
            }

            $convenios = Convenio::where("convenio.status", "Activado")
            ->where("fecha_fin", Carbon::now()->subDays(5)->format('Y-m-d'))
            ->where(function ($query) { $query->where("nota_convenio", NULL)->orWhere("nota_convenio", ""); })
            ->get();

            foreach ($convenios as $convenio_update) {
                $convenio = Convenio::find($convenio_update->id);

                //Refrendar folio
                $folio = explode("-", $convenio_update->folio);
                $refrendo = intval($folio[4]) + 1;
                $refrendo = str_pad($refrendo, 2, "0", STR_PAD_LEFT);
                $folio_completo = $folio[0].'-'.$folio[1].'-'.$folio[2].'-'.$folio[3].'-'.$refrendo;

                //Actualizar numero de folio
                $convenio->folio = strtoupper($folio_completo);

                // Actualizar fechas y status
                $convenio->fecha_inicio = Carbon::parse($convenio_update->fecha_inicio)->addYear()->format('Y-m-d');
                $convenio->fecha_fin = Carbon::parse($convenio_update->fecha_fin)->addYear()->format('Y-m-d');
                $convenio->status = "Activado";
                $convenio->status_oficina = "Activado";
                $convenio->memo_status = "Convenio activado por id:1";

                // Dejar todo por defecto
                $convenio->nota_convenio = NULL;
                $convenio->autorizacion_nota = NULL;
                $convenio->save();

                $pagos_ps_convenio = PagoPSConvenio::where("convenio_id", $convenio_update->id)->get();
                foreach ($pagos_ps_convenio as $pago_ps_convenio_update) {
                    DB::table('pago_ps_convenio')->where('convenio_id', '=', $convenio_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps_convenio = PagoPSConvenio::find($pago_ps_convenio_update->id);
                    $pago_ps_convenio->fecha_pago = Carbon::parse($pago_ps_convenio_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->fecha_limite = Carbon::parse($pago_ps_convenio_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps_convenio->save();
                }
            }
        })
        ->dailyAt("09:50")
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

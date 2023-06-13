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
            ->where("fecha_renovacion", Carbon::now()->subDays(4)->format('Y-m-d'))
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
                $contrato->fecha_carga = date('Y-m-d H:i:s', strtotime("now"));
                $contrato->fecha_reintegro = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->status_reintegro = "pendiente";
                $contrato->memo_reintegro = NULL;
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->pendiente_id = NULL;
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->update();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
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

                //Actualización de tabla de pago de clientes
                $pagos_clientes = PagoCliente::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_clientes as $pago_cliente_update) {
                    $pago_cliente = PagoCliente::find($pago_cliente_update->id);
                    $pago_cliente->fecha_pago = Carbon::parse($pago_cliente_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_cliente->fecha_pagado = NULL;
                    if ($tipo_contrato->id == 2) {
                        $pago_cliente->pago = $pago;
                    }
                    $pago_cliente->status = "Pendiente";
                    $pago_cliente->memo = NULL;
                    $pago_cliente->tipo_pago = "Pendiente";
                    $pago_cliente->comprobante = NULL;
                    $pago_cliente->update();
                }

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_mensual = $inversion_us * $cmensual;
                $capertura = $tipo_contrato->capertura * .01;
                $pago_ps_apertura = $inversion_us * $capertura;
                //Actualización de tabla de pago de ps
                $pagos_ps = PagoPS::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_ps as $pago_ps_update) {
                    DB::table('pago_ps')->where('contrato_id', '=', $contrato_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps = PagoPS::find($pago_ps_update->id);
                    $pago_ps->fecha_pago = Carbon::parse($pago_ps_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_limite = Carbon::parse($pago_ps_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_pagado = NULL;
                    $pago_ps->pago = $pago_ps_mensual;
                    $pago_ps->status = "Pendiente";
                    $pago_ps->tipo_pago = "Pendiente";
                    $pago_ps->comprobante = NULL;
                    $pago_ps->update();
                }

            }
        })
        ->dailyAt("09:00")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(4)->format('Y-m-d'))
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
                $contrato->fecha_carga = date('Y-m-d H:i:s', strtotime("now"));
                $contrato->fecha_reintegro = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->status_reintegro = "pendiente";
                $contrato->memo_reintegro = NULL;
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->pendiente_id = NULL;
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->update();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
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

                //Actualización de tabla de pago de clientes
                $pagos_clientes = PagoCliente::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_clientes as $pago_cliente_update) {
                    $pago_cliente = PagoCliente::find($pago_cliente_update->id);
                    $pago_cliente->fecha_pago = Carbon::parse($pago_cliente_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_cliente->fecha_pagado = NULL;
                    if ($tipo_contrato->id == 2) {
                        $pago_cliente->pago = $pago;
                    }
                    $pago_cliente->status = "Pendiente";
                    $pago_cliente->memo = NULL;
                    $pago_cliente->tipo_pago = "Pendiente";
                    $pago_cliente->comprobante = NULL;
                    $pago_cliente->update();
                }

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_mensual = $inversion_us * $cmensual;
                $capertura = $tipo_contrato->capertura * .01;
                $pago_ps_apertura = $inversion_us * $capertura;
                //Actualización de tabla de pago de ps
                $pagos_ps = PagoPS::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_ps as $pago_ps_update) {
                    DB::table('pago_ps')->where('contrato_id', '=', $contrato_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps = PagoPS::find($pago_ps_update->id);
                    $pago_ps->fecha_pago = Carbon::parse($pago_ps_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_limite = Carbon::parse($pago_ps_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_pagado = NULL;
                    $pago_ps->pago = $pago_ps_mensual;
                    $pago_ps->status = "Pendiente";
                    $pago_ps->tipo_pago = "Pendiente";
                    $pago_ps->comprobante = NULL;
                    $pago_ps->update();
                }

            }
        })
        ->dailyAt("09:10")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(4)->format('Y-m-d'))
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
                $contrato->fecha_carga = date('Y-m-d H:i:s', strtotime("now"));
                $contrato->fecha_reintegro = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->status_reintegro = "pendiente";
                $contrato->memo_reintegro = NULL;
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->pendiente_id = NULL;
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->update();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
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

                //Actualización de tabla de pago de clientes
                $pagos_clientes = PagoCliente::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_clientes as $pago_cliente_update) {
                    $pago_cliente = PagoCliente::find($pago_cliente_update->id);
                    $pago_cliente->fecha_pago = Carbon::parse($pago_cliente_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_cliente->fecha_pagado = NULL;
                    if ($tipo_contrato->id == 2) {
                        $pago_cliente->pago = $pago;
                    }
                    $pago_cliente->status = "Pendiente";
                    $pago_cliente->memo = NULL;
                    $pago_cliente->tipo_pago = "Pendiente";
                    $pago_cliente->comprobante = NULL;
                    $pago_cliente->update();
                }

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_mensual = $inversion_us * $cmensual;
                $capertura = $tipo_contrato->capertura * .01;
                $pago_ps_apertura = $inversion_us * $capertura;
                //Actualización de tabla de pago de ps
                $pagos_ps = PagoPS::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_ps as $pago_ps_update) {
                    DB::table('pago_ps')->where('contrato_id', '=', $contrato_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps = PagoPS::find($pago_ps_update->id);
                    $pago_ps->fecha_pago = Carbon::parse($pago_ps_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_limite = Carbon::parse($pago_ps_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_pagado = NULL;
                    $pago_ps->pago = $pago_ps_mensual;
                    $pago_ps->status = "Pendiente";
                    $pago_ps->tipo_pago = "Pendiente";
                    $pago_ps->comprobante = NULL;
                    $pago_ps->update();
                }

            }
        })
        ->dailyAt("09:20")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(4)->format('Y-m-d'))
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
                $contrato->fecha_carga = date('Y-m-d H:i:s', strtotime("now"));
                $contrato->fecha_reintegro = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->status_reintegro = "pendiente";
                $contrato->memo_reintegro = NULL;
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->pendiente_id = NULL;
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->update();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
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

                //Actualización de tabla de pago de clientes
                $pagos_clientes = PagoCliente::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_clientes as $pago_cliente_update) {
                    $pago_cliente = PagoCliente::find($pago_cliente_update->id);
                    $pago_cliente->fecha_pago = Carbon::parse($pago_cliente_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_cliente->fecha_pagado = NULL;
                    if ($tipo_contrato->id == 2) {
                        $pago_cliente->pago = $pago;
                    }
                    $pago_cliente->status = "Pendiente";
                    $pago_cliente->memo = NULL;
                    $pago_cliente->tipo_pago = "Pendiente";
                    $pago_cliente->comprobante = NULL;
                    $pago_cliente->update();
                }

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_mensual = $inversion_us * $cmensual;
                $capertura = $tipo_contrato->capertura * .01;
                $pago_ps_apertura = $inversion_us * $capertura;
                //Actualización de tabla de pago de ps
                $pagos_ps = PagoPS::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_ps as $pago_ps_update) {
                    DB::table('pago_ps')->where('contrato_id', '=', $contrato_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps = PagoPS::find($pago_ps_update->id);
                    $pago_ps->fecha_pago = Carbon::parse($pago_ps_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_limite = Carbon::parse($pago_ps_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_pagado = NULL;
                    $pago_ps->pago = $pago_ps_mensual;
                    $pago_ps->status = "Pendiente";
                    $pago_ps->tipo_pago = "Pendiente";
                    $pago_ps->comprobante = NULL;
                    $pago_ps->update();
                }

            }
        })
        ->dailyAt("09:30")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(4)->format('Y-m-d'))
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
                $contrato->fecha_carga = date('Y-m-d H:i:s', strtotime("now"));
                $contrato->fecha_reintegro = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->status_reintegro = "pendiente";
                $contrato->memo_reintegro = NULL;
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->pendiente_id = NULL;
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->update();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
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

                //Actualización de tabla de pago de clientes
                $pagos_clientes = PagoCliente::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_clientes as $pago_cliente_update) {
                    $pago_cliente = PagoCliente::find($pago_cliente_update->id);
                    $pago_cliente->fecha_pago = Carbon::parse($pago_cliente_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_cliente->fecha_pagado = NULL;
                    if ($tipo_contrato->id == 2) {
                        $pago_cliente->pago = $pago;
                    }
                    $pago_cliente->status = "Pendiente";
                    $pago_cliente->memo = NULL;
                    $pago_cliente->tipo_pago = "Pendiente";
                    $pago_cliente->comprobante = NULL;
                    $pago_cliente->update();
                }

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_mensual = $inversion_us * $cmensual;
                $capertura = $tipo_contrato->capertura * .01;
                $pago_ps_apertura = $inversion_us * $capertura;
                //Actualización de tabla de pago de ps
                $pagos_ps = PagoPS::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_ps as $pago_ps_update) {
                    DB::table('pago_ps')->where('contrato_id', '=', $contrato_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps = PagoPS::find($pago_ps_update->id);
                    $pago_ps->fecha_pago = Carbon::parse($pago_ps_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_limite = Carbon::parse($pago_ps_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_pagado = NULL;
                    $pago_ps->pago = $pago_ps_mensual;
                    $pago_ps->status = "Pendiente";
                    $pago_ps->tipo_pago = "Pendiente";
                    $pago_ps->comprobante = NULL;
                    $pago_ps->update();
                }

            }
        })
        ->dailyAt("09:40")
        ->timezone('America/Mexico_City');

        $schedule->call(function () {
            $contratos = Contrato::where("contrato.status", "Activado")
            ->where("fecha_renovacion", Carbon::now()->subDays(4)->format('Y-m-d'))
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
                $contrato->fecha_carga = date('Y-m-d H:i:s', strtotime("now"));
                $contrato->fecha_reintegro = Carbon::parse($contrato_update->fecha_renovacion)->addYear()->format('Y-m-d');
                $contrato->status = "Activado";

                // Dejar todo por defecto
                $contrato->status_reintegro = "pendiente";
                $contrato->memo_reintegro = NULL;
                $contrato->memo_status = "Contrato activado por id:1";
                $contrato->pendiente_id = NULL;
                $contrato->nota_contrato = NULL;
                $contrato->autorizacion_nota = NULL;

                // Actualizar inversion refrendada
                $contrato->inversion = $inversion;
                $contrato->inversion_letra = $inversion_letra;
                $contrato->inversion_us = $inversion_us;
                $contrato->inversion_letra_us = $inversion_letra_us;
                $contrato->update();
                
                $monto = $inversion_us;
                $redito = 0;
                $saldo_con_redito = 0;
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

                //Actualización de tabla de pago de clientes
                $pagos_clientes = PagoCliente::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_clientes as $pago_cliente_update) {
                    $pago_cliente = PagoCliente::find($pago_cliente_update->id);
                    $pago_cliente->fecha_pago = Carbon::parse($pago_cliente_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_cliente->fecha_pagado = NULL;
                    if ($tipo_contrato->id == 2) {
                        $pago_cliente->pago = $pago;
                    }
                    $pago_cliente->status = "Pendiente";
                    $pago_cliente->memo = NULL;
                    $pago_cliente->tipo_pago = "Pendiente";
                    $pago_cliente->comprobante = NULL;
                    $pago_cliente->update();
                }

                $cmensual = $tipo_contrato->cmensual * .001;
                $pago_ps_mensual = $inversion_us * $cmensual;
                $capertura = $tipo_contrato->capertura * .01;
                $pago_ps_apertura = $inversion_us * $capertura;
                //Actualización de tabla de pago de ps
                $pagos_ps = PagoPS::where("contrato_id", $contrato_update->id)->get();
                foreach ($pagos_ps as $pago_ps_update) {
                    DB::table('pago_ps')->where('contrato_id', '=', $contrato_update->id)->where("memo", "Comisión por apertura")->delete();

                    $pago_ps = PagoPS::find($pago_ps_update->id);
                    $pago_ps->fecha_pago = Carbon::parse($pago_ps_update->fecha_pago)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_limite = Carbon::parse($pago_ps_update->fecha_limite)->addYear()->format('Y-m-d');
                    $pago_ps->fecha_pagado = NULL;
                    $pago_ps->pago = $pago_ps_mensual;
                    $pago_ps->status = "Pendiente";
                    $pago_ps->tipo_pago = "Pendiente";
                    $pago_ps->comprobante = NULL;
                    $pago_ps->update();
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
<?php

namespace App\Http\Controllers;

use App\Models\Amortizacion;
use App\Models\Beneficiario;
use App\Models\Contrato;
use App\Models\PagoCliente;
use App\Models\PagoPS;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AuxiliarController extends Controller
{
    public function actualizarPagos()
    {
        $contratos = Contrato::with('tipo_contrato')->get();

        foreach ($contratos as $contrato) {
            Amortizacion::where('contrato_id', '=', $contrato->id)->delete();
            PagoPS::where('contrato_id', '=', $contrato->id)->delete();
            PagoCliente::where('contrato_id', '=', $contrato->id)->delete();

            $fecha_limite = "";

            $fecha_pago = Carbon::parse($contrato->fecha);
            $fecha_amortizacion = Carbon::parse($contrato->fecha);
            $fecha_feb = Carbon::parse($fecha_pago);
            $fecha_nueva = Carbon::parse($fecha_pago);
            $fechaFeb = Carbon::parse($fecha_pago);

            $capertura = $contrato->tipo_contrato->capertura;
            $capertura = $capertura * .01;

            $cmensual = $contrato->tipo_contrato->cmensual;
            $cmensual = $cmensual * .001;

            $rendimiento = $contrato->porcentaje;
            $rendimiento = $rendimiento * .01;

            $monto = $contrato->inversion_us;

            $tipo_contrato = $contrato->tipo_contrato->tipo;
            $periodo = $contrato->periodo;

            if ($tipo_contrato == "Rendimiento compuesto") {
                for ($i = 0; $i < $periodo; $i++) {
                    if ($fecha_limite == "") {
                        $fecha_pago->addMonth()->endOfMonth();
                        $fecha_pago->format('Y-m-d');
                    } else {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                    }

                    $fecha_limite = Carbon::parse($fecha_pago);
                    $fecha_limite->setDay(10)->addMonth();

                    $fecha_limite->format('Y-m-d');
                    if ($i == 0) {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $capertura), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión por apertura';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();

                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $cmensual), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    } else {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $cmensual), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    }

                    $amortizacion = new Amortizacion;

                    $amortizacion->contrato_id = $contrato->id;
                    $amortizacion->serie = ($i + 1);

                    $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                    $fecha_dia = $fecha_nueva->format('d');
                    $fecha_mes = $fechaFeb->format('m');
                    $fecha_anio = $fechaFeb->format('Y');

                    if ($fecha_mes == 2){
                        if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                            $amortizacion->fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                        }else{
                            $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
                    }else if ($fecha_dia == 31){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else if($fecha_dia == 29 || $fecha_dia == 30){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else{
                        $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                    }

                    $amortizacion->monto = round($monto, 2);
                    $redito = $monto * $rendimiento;
                    $amortizacion->redito = round($redito, 2);
                    $amortizacion->saldo_con_redito = round(($monto + $redito), 2);
                    $monto = ($monto + $redito);

                    $amortizacion->save();
                }

                $pago_cliente = $amortizacion->saldo_con_redito;
                $fecha_pago_cliente_inicial = $amortizacion->fecha;

                $fecha_pago_cliente = Carbon::parse($fecha_pago_cliente_inicial);

                $pago_cliente_table = new PagoCliente;

                $pago_cliente_table->contrato_id = $contrato->id;
                $pago_cliente_table->serie = ($i + 1);
                $pago_cliente_table->fecha_pago = $fecha_pago_cliente;
                $pago_cliente_table->pago = $pago_cliente;
                $pago_cliente_table->status = "Pendiente";
                $pago_cliente_table->tipo_pago = "Pendiente";

                $pago_cliente_table->save();
            } elseif ($tipo_contrato == "Rendimiento mensual") {
                $fecha_pago_cliente = Carbon::parse($contrato->fecha_inicio);

                for ($i = 0; $i < $periodo; $i++) {
                    if ($fecha_limite == "") {
                        $fecha_pago->addMonth()->endOfMonth();
                        $fecha_pago->format('Y-m-d');
                    } else {
                        $fecha_pago = Carbon::parse($fecha_limite);
                        $fecha_pago->endOfMonth();
                    }

                    $fecha_limite = Carbon::parse($fecha_pago);
                    $fecha_limite->setDay(10)->addMonth();

                    $fecha_limite->format('Y-m-d');
                    if ($i == 0) {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $capertura), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión por apertura';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();

                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $cmensual), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    } else {
                        $pagops = new PagoPS;

                        $pago = $contrato->inversion_us;

                        $pagops->contrato_id = $contrato->id;
                        $pagops->serie = ($i + 1);
                        $pagops->fecha_pago = $fecha_pago;
                        $pagops->fecha_limite = $fecha_limite;
                        $pagops->pago = round(($pago * $cmensual), 2);
                        $pagops->status = 'Pendiente';
                        $pagops->memo = 'Comisión mensual';
                        $pagops->tipo_pago = 'Pendiente';

                        $pagops->save();
                    }

                    $amortizacion = new Amortizacion;

                    $amortizacion->contrato_id = $contrato->id;
                    $amortizacion->serie = ($i + 1);

                    $fechaFeb->subDays(2)->addMonth()->format('Y-m-d');
                    $fecha_dia = $fecha_nueva->format('d');
                    $fecha_mes = $fechaFeb->format('m');
                    $fecha_anio = $fechaFeb->format('Y');

                    if ($fecha_mes == 2){
                        if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                            $amortizacion->fecha = $fecha_amortizacion->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                        }else{
                            $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                        }
                    }else if ($fecha_dia == 31){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else if($fecha_dia == 29 || $fecha_dia == 30){
                        $fecha_amortizacion = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                        $amortizacion->fecha = $fecha_amortizacion->format('Y-m-d');
                    }else{
                        $amortizacion->fecha = $fecha_amortizacion->addMonth()->format('Y-m-d');
                    }

                    $amortizacion->monto = round($monto, 2);
                    $redito = $monto * $rendimiento;
                    $amortizacion->redito = round($redito, 2);
                    $amortizacion->saldo_con_redito = round(($monto + $redito), 2);

                    $amortizacion->save();

                    $pago_cliente_table = new PagoCliente;

                    $pago_cliente_table->contrato_id = $contrato->id;
                    $pago_cliente_table->serie = ($i + 1);

                    if ($fecha_mes == 2){
                        if ($fecha_dia == 29 || $fecha_dia == 30 || $fecha_dia == 31) {
                            $pago_cliente_table->fecha_pago = $fecha_pago_cliente->subWeek()->addMonth()->endOfMonth()->format('Y-m-d');
                        }else{
                            $pago_cliente_table->fecha_pago = $fecha_pago_cliente->addMonth()->format('Y-m-d');
                        }
                    }else if ($fecha_dia == 31){
                        $fecha_pago_cliente = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia")->subWeek()->endOfMonth();
                        $pago_cliente_table->fecha_pago = $fecha_pago_cliente->format('Y-m-d');
                    }else if($fecha_dia == 29 || $fecha_dia == 30){
                        $fecha_pago_cliente = Carbon::parse("$fecha_anio-$fecha_mes-$fecha_dia");
                        $pago_cliente_table->fecha_pago = $fecha_pago_cliente->format('Y-m-d');
                    }else{
                        $pago_cliente_table->fecha_pago = $fecha_pago_cliente->addMonth()->format('Y-m-d');
                    }
                    
                    $pago_cliente_table->pago = round($redito, 2);
                    $pago_cliente_table->status = "Pendiente";
                    $pago_cliente_table->tipo_pago = "Pendiente";

                    $pago_cliente_table->save();
                }
            }
        }

        return "actualizado";
    }
}
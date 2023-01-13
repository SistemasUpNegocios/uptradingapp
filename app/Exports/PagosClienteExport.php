<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PagosClienteExport implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function __construct($fecha_inicio, $fecha_fin, $dolar)
    {
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
        $this->dolar = $dolar;
    }

    public function headings(): array
    {
        return [
            'Contrato',
            'Cliente',
            'Rendimiento (USD)',
            'Rendimiento (MXN)',
            'Pago',
        ];
    }
    public function collection()
    {

        $exportPagos = DB::table('contrato')
        ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
        ->join('amortizacion', 'amortizacion.contrato_id', '=', 'contrato.id')
        ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
        ->select(DB::raw("contrato.id as contratoid, contrato.contrato,  CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, pago_cliente.pago, contrato.tipo_id, amortizacion.serie as serie_pago"))
        ->whereBetween('amortizacion.fecha', [$this->fecha_inicio, $this->fecha_fin])
        ->distinct("clientenombre")
        ->orderBy('contratoid', 'DESC')
        ->get();

        foreach ($exportPagos as $export) {
            if (strlen($export->contrato) == 11){
                $export->contrato = str_replace($export->contrato, substr($export->contrato, 0, -2), $export->contrato);
            }else{
                $export->contrato = str_replace($export->contrato, substr($export->contrato, 0, -3), $export->contrato);
            }

            $rendimiento = $export->pago * $this->dolar;
            $export->pago = str_replace($export->pago, "$".number_format($export->pago, 2), $export->pago);

            if ($export->tipo_id == 2 && $export->serie_pago == 12){
                $export->serie_pago = str_replace($export->serie_pago, "CONTRATO COMPUESTO ($export->serie_pago/12)", $export->serie_pago);
                $export->tipo_id = str_replace($rendimiento, "$".number_format($rendimiento, 2), $rendimiento);
            }else if($export->tipo_id == 1){
                $export->serie_pago = str_replace($export->serie_pago, str_pad($export->serie_pago, 2, "0", STR_PAD_LEFT)."/12", $export->serie_pago);
                $export->tipo_id = str_replace($rendimiento, "$".number_format($rendimiento, 2), $rendimiento);
            }else{
                unset($export->contratoid);
                unset($export->contrato);
                unset($export->clientenombre);
                unset($export->pago);
                unset($export->tipo_id);
                unset($export->serie_pago);
            }
            unset($export->contratoid);
           
        }

        return $exportPagos;
    }
}
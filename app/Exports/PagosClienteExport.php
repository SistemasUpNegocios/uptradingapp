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

    public function __construct($fecha_inicio, $fecha_fin)
    {
        $this->fecha_inicio = $fecha_inicio;
        $this->fecha_fin = $fecha_fin;
    }

    public function headings(): array
    {
        return [
            'Contrato',
            'Cliente',
            'Comisión',
            'Pago',
        ];
    }
    public function collection()
    {

        $exportPagos = DB::table('contrato')
        ->join('cliente', 'cliente.id', '=', 'contrato.cliente_id')
        ->join('pago_cliente', 'pago_cliente.contrato_id', '=', 'contrato.id')
        ->select(DB::raw("contrato.contrato, CONCAT(cliente.apellido_p, ' ', cliente.apellido_m, ' ', cliente.nombre) AS clientenombre, pago_cliente.pago, pago_cliente.serie"))
        ->whereBetween('pago_cliente.fecha_pago', [$this->fecha_inicio, $this->fecha_fin])
        ->orderBy('contrato.id', 'DESC')
        ->get();

        foreach ($exportPagos as $export) {
            if (strlen($export->contrato) == 11){
                $export->contrato = str_replace($export->contrato, substr($export->contrato, 0, -2), $export->contrato);
            }else{
                $export->contrato = str_replace($export->contrato, substr($export->contrato, 0, -3), $export->contrato);
            }

            $export->pago = str_replace($export->pago, "$".number_format($export->pago, 2), $export->pago);

            if ($export->serie == 13){
                $export->serie = str_replace($export->serie, "CONTRATO COMPUESTO", $export->serie);
            }else{
                $export->serie = str_replace($export->serie, str_pad($export->serie, 2, "0", STR_PAD_LEFT)."/12", $export->serie);
            }
        }

        return $exportPagos;
    }
}
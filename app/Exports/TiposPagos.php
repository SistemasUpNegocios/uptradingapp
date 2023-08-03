<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TiposPagos implements FromCollection,WithHeadings
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
            'Efectivo',
            'Transferencia',
            'Transferencia Swissquote',
        ];
    }
    public function collection()
    {

        $clientes = DB::table('cliente')->select(DB::raw("id, codigoCliente, tipo_pago, CONCAT(nombre, ' ', apellido_p, ' ', apellido_m) AS clientenombre"))->get();

        foreach ($clientes as $cliente) {
            $tipo_pago = explode(",", $cliente->tipo_pago);

            
            unset($cliente->id);
            unset($cliente->codigoCliente);
            unset($cliente->tipo_pago);

            foreach ($tipo_pago as $tipo) {
                if ($tipo == "efectivo") {
                    $cliente->id = $cliente->clientenombre;
                }
                if ($tipo == "transferencia") {
                    $cliente->codigoCliente = $cliente->clientenombre;
                }
                if ($tipo == "transferenciaSwiss") {
                    $cliente->tipo_pago = $cliente->clientenombre;
                }
            }

            // unset($cliente->id);
            // unset($cliente->codigoCliente);
            // unset($cliente->tipo_pago);

            unset($cliente->clientenombre);

           
        }

        return $clientes;
    }
}

<?php

namespace App\Exports;

use App\User;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use App\Models\PagoCliente;
use App\Models\Contrato;
use Carbon\Carbon;

class PendientesPagoExport implements FromCollection, WithHeadings, WithEvents
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function headings(): array
    {
        return [];
    }

    public function collection()
    {
        $contratos = $this->id == "all"
            ? Contrato::join('cliente', 'contrato.cliente_id', '=', 'cliente.id')
                ->join('tipo_contrato', 'contrato.tipo_id', '=', 'tipo_contrato.id')
                ->select(
                    DB::raw('CONCAT(cliente.nombre, " ", cliente.apellido_p, " ", cliente.apellido_m) AS nombre'),
                    'contrato.contrato',
                    'contrato.fecha',
                    'tipo_contrato.tipo',
                    'contrato.inversion_us',
                    'cliente.id AS cliente_id',
                    'contrato.id as contrato_id'
                )
                ->where('contrato.status', 'Activado')
                ->where('cliente.id', "!=", 261)
                ->orderBy('contrato.contrato', 'asc')
                ->get()
            : Contrato::join('cliente', 'contrato.cliente_id', '=', 'cliente.id')
                ->join('tipo_contrato', 'contrato.tipo_id', '=', 'tipo_contrato.id')
                ->select(
                    DB::raw('CONCAT(cliente.nombre, " ", cliente.apellido_p, " ", cliente.apellido_m) AS nombre'),
                    'contrato.contrato',
                    'contrato.fecha',
                    'tipo_contrato.tipo',
                    'contrato.inversion_us',
                    'cliente.id AS cliente_id',
                    'contrato.id as contrato_id'
                )
                ->where('contrato.status', 'Activado')
                ->where('cliente.id', "!=", 261)
                ->where('cliente.id', $this->id)
                ->orderBy('contrato.contrato', 'asc')
                ->get();

        $data = [];

        foreach ($contratos as $contrato) {
            $pagos = PagoCliente::select('pago', 'fecha_pago', 'status')->where('contrato_id', $contrato->contrato_id)->groupBy('status')->orderBy('status', 'ASC')->first();

            $nombre = $contrato->nombre;
            $contra = substr($contrato->contrato, 0, 9);
            $fecha = Carbon::parse($contrato->fecha)->format('d/m/Y');
            $tipo = strtoupper(substr($contrato->tipo, 12));
            $capital = "$" . number_format($contrato->inversion_us, 2)." DLLS";
            $rendimiento = "$" . number_format($pagos->pago, 2)." DLLS";
            $pendiente = strtoupper(Carbon::parse($pagos->fecha_pago)->formatLocalized('%B')) . " HASTA LA FECHA";

            if($pagos->status != 'Pagado'){
                // Nombre de cliente en una fila sola
                $data[] = [$nombre];
    
                // Demás filas
                $data[] = ['Contrato', $contra];
                $data[] = ['Fecha de inicio', $fecha];
                $data[] = ['Tipo', $tipo];
    
                if ($tipo == 'MENSUAL') {
                    $data[] = ['Capital', $capital];
                    $data[] = ['RENDIMIENTO', $rendimiento];
                    $data[] = ['PENDIENTE', $pendiente];
                } else {
                    $data[] = ['Capital & Rendimiento', $rendimiento];
                }
    
                // Fila vacia
                $data[] = [''];
            }
        }

        return collect($data);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();

                // Establecer bordes y tamaño de fuente
                for ($row = 1; $row <= $highestRow; $row++) {
                    if (!empty(array_filter($event->sheet->getDelegate()->rangeToArray("A{$row}:{$highestColumn}{$row}")[0]))) {
                        for ($col = 'A'; $col <= $highestColumn; $col++) {
                            $cell = $col . $row;
                            $event->sheet->getDelegate()->getStyle($cell)->applyFromArray([
                                'borders' => [
                                    'allBorders' => [
                                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                                        'color' => ['argb' => '000000'],
                                    ],
                                ],
                                'font' => [
                                    'size' => 12,
                                ],
                                'alignment' => [
                                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                                ],
                            ]);
                        }
                    }
                }

                // Establecer negritas y alineación centrada solo para los nombres
                for ($i = 1; $i <= $highestRow; $i++) {
                    if ($event->sheet->getDelegate()->getCell("A{$i}")->getValue() != '' && $event->sheet->getDelegate()->getCell("B{$i}")->getValue() == '') {
                        $event->sheet->getDelegate()->mergeCells("A{$i}:B{$i}");
                        $event->sheet->getDelegate()->getStyle("A{$i}")->getFont()->setBold(true);
                        $event->sheet->getDelegate()->getStyle("A{$i}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    }
                }

                // Ajustar el ancho de las columnas automáticamente
                foreach (range('A', $highestColumn) as $col) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setAutoSize(true);
                }
            },
        ];
    }
}

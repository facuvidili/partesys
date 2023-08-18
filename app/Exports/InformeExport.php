<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutosize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Concerns\FromQuery;

class InformeExport implements FromCollection, WithCustomStartCell, WithMapping, WithHeadings, ShouldAutosize, WithStyles, WithDrawings
// WithColumnFormatting
{
    use Exportable;
   
    private $consulta;
    public function __construct($consulta)
    {
        $this->consulta = $consulta;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
       
            // dd($this->consulta);
        return $this->consulta;
    }
    
    public function startCell(): string
    {
        return 'A7';
    }
    /**
    * @var Invoice $informe
    */
    public function map($informe): array
    {   
        return [
            $informe->account_id,
            $informe->name,
            $informe->is_deficitary ? 'SI' : 'NO',
            '$'.number_format($informe->budget, 2, ',', '.'),
            '$'.number_format($informe->balance, 2, ',', '.'),
            '$'.number_format($informe->total_normal_hour, 2, ',', '.'),
            '$'.number_format($informe->total_fifty_hour, 2, ',', '.'),
            '$'.number_format($informe->total_hundred_hour, 2, ',', '.'),
            '$'.number_format($informe->total_food, 2, ',', '.'),
            '$'.number_format($informe->total_concepts->total_extraordinary_concepts, 2, ',', '.'),
            '$'.number_format($informe->total_concepts->total_discount, 2, ',', '.'),'$'.number_format($informe->total_normal_hour + $informe->total_fifty_hour + $informe->total_hundred_hour + $informe->total_food + $informe->total_concepts->total_extraordinary_concepts + $informe->total_concepts->total_discount, 2, ',', '.'),
        ];
    }
    public function headings(): array
    {
        return [
            'N° de cuenta',
            'Nombre',
            'Deficitaria',
            'Presupuesto',
            'Saldo disponible',
            'Total hora normal',
            'Total hora 50%',
            'Total hora 100%',
            'Total viandas',
            'Total conceptos extraordinarios',
            'Total descuentos',
            'Sumatoria de totales',
        ];
    }
    public function styles(Worksheet $sheet)
    {
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A3);
        $sheet->mergeCells('E1:I6');
        $sheet->getStyle('N8:L'.$sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => 'center',
            ]
        ]);
        $sheet->getStyle('E8:M'.$sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => 'right',
            ]
        ]);
        $sheet->getStyle('B8:B'.$sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => 'left',
            ]
        ]);
        $sheet->getStyle('A8:A'.$sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => 'center',
            ]
        ]);
        $sheet->getStyle('D8:D'.$sheet->getHighestRow())->applyFromArray([
            'alignment' => [
                'horizontal' => 'right',
            ]
        ]);
        $sheet->getStyle('A7:M7')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
            'alignment' => [
                'horizontal' => 'left',
            ]
        ]);
        $sheet->getStyle('A7:L' . $sheet->getHighestRow())->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => 'thin',
                ],
            ],
        ]);
        $sheet->getStyle('A7:L7')->applyFromArray([
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'argb' => 'e0e0e0',
                ]
            ],
        ]);
    }
    public function drawings()
    {
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('cabecera_IE');
        $drawing->setDescription('logo');
        $drawing->setPath("C:/xampp/htdocs/partesys/app/Exports/PARTESYS.png");
        $drawing->setHeight(100);
        $drawing->setCoordinates('E1');
        return $drawing;
    }
    public function columnFormats():array{
        return [
            'B' => \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING,
        ];
    }
}

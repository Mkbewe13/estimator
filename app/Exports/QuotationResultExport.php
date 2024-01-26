<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class QuotationResultExport implements FromArray, WithColumnFormatting, WithColumnWidths, WithStyles
{
    private array $quotationResult;
    private int $dataRowsCount;

    private const COLUMNS = [
        'Description',
        'Min',
        'Max'
    ];

    public function __construct(array $quotationResult)
    {
        $this->quotationResult = $quotationResult;
        $this->dataRowsCount = count($quotationResult);
    }

    public function array(): array
    {
        $resultArray = [];

        $resultArray[] = self::COLUMNS;
        $columnsIterator = 1;
        foreach ($this->quotationResult as $result){
            $resultArray[] = [$result['description'],$result['min'],$result['max']];
            $columnsIterator++;
        }

        $resultArray[]= [' '];
        $columnsIterator++;
        $resultArray[] = ['Min', '=SUM(B2:B' . $this->dataRowsCount + 1 .')'];
        $columnsIterator++;
        $resultArray[] = ['Max', '=SUM(C2:C' . $this->dataRowsCount + 1 .')'];
        $columnsIterator++;
        $resultArray[] = ['Avg', '=AVERAGE(B' . $columnsIterator -1 . ':B' . $columnsIterator . ')'];

        return $resultArray;
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
            'B' => NumberFormat::FORMAT_NUMBER,
            'C' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 90,
            'B' => 10,
            'C' => 10,
        ];
    }

    /**
     * @throws Exception
     */
    public function styles(Worksheet $sheet)
    {
        $styleArrayColumn = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ],
            ],
        ];

        $styleArrayData = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $styleArraySummary = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                ],
            ],
        ];


        $lastDataCell = $this->dataRowsCount + 1;

        $sheet->getStyle('A1:C1')->applyFromArray($styleArrayColumn);
        $sheet->getStyle('A2:C' . $lastDataCell)->applyFromArray($styleArrayData);
        $sheet->getStyle('B' . $lastDataCell + 2 . ':B' . $lastDataCell + 4)->applyFromArray($styleArraySummary);
        $sheet->getStyle('A2:C200')->getAlignment()->setWrapText(true);
    }
}

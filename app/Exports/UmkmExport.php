<?php

namespace App\Exports;

use App\Models\Umkm;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UmkmExport implements FromQuery, WithMapping, WithHeadings, WithColumnWidths, WithStyles
{
    use Exportable;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function query()
    {
        $builder = Umkm::query()
                    ->with(['user'])
                    ->where('status', '=', $this->status);
        return $builder;
    }

    public function headings(): array
    {
        return [
            'Tipe',
            'Status',
            'Nama UMKM',
            'Kecamatan',
            'Nama Pemilik',
            'NIK Pemilik',
            'Alamat Pemilik',
        ];
    }

    public function map($umkm): array
    {
        return [
            $umkm->type,
            $umkm->status,
            $umkm->name,
            $umkm->sub_district,
            $umkm->user ? $umkm->user->full_name : '',
            $umkm->user ? $umkm->user->nip : '',
            $umkm->user ? $umkm->user->address : '',            
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 15,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 70,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('G')->getAlignment()->setWrapText(true); 

        $sheet->getStyle('A2:A'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('B2:B'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('C2:C'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('D2:D'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('E2:E'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('F2:F'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('G2:G'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
    }

    
}

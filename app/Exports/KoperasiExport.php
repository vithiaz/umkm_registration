<?php

namespace App\Exports;

use App\Models\Koperasi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KoperasiExport implements FromQuery, WithMapping, WithHeadings, WithColumnWidths, WithStyles
{
    use Exportable;

    public function __construct(string $status)
    {
        $this->status = $status;
    }

    public function query()
    {
        $builder = Koperasi::query()
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
            'No. Badan Usaha',
            'Tanggal Badan Usaha',
            'Kota',
            'Kecamatan',
            'Desa / Kelurahan',
            'Alamat Lengkap',
            'Nama Pemilik',
            'NIK Pemilik',
            'Alamat Pemilik',
        ];
    }

    public function map($koperasi): array
    {
        return [
            'Koperasi',
            $koperasi->status,
            $koperasi->name,
            $koperasi->legal_number,
            $koperasi->legal_date,
            'Tomohon',
            $koperasi->sub_district,
            $koperasi->village,
            $koperasi->address,
            $koperasi->user ? $koperasi->user->full_name : '',
            $koperasi->user ? $koperasi->user->nip : '',
            $koperasi->user ? $koperasi->user->address : '',            
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,      // 'Tipe'
            'B' => 15,      // 'Status'
            'C' => 30,      // 'Nama UMKM'
            'D' => 30,      // 'No. Badan Usaha'
            'E' => 30,      // 'Tanggal Badan Usaha'
            'F' => 30,      // 'Kota'
            'G' => 30,      // 'Kecamatan'
            'H' => 30,      // 'Desa / Kelurahan'
            'I' => 70,      // 'Alamat Lengkap'
            'J' => 30,      // 'Nama Pemilik'
            'K' => 30,      // 'NIK Pemilik'
            'L' => 70,      // 'Alamat Pemilik'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow = $sheet->getHighestRow();
        $lastColumn = $sheet->getHighestColumn();

        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1')->getAlignment()->setHorizontal('center');

        $sheet->getStyle('L')->getAlignment()->setWrapText(true); 
        $sheet->getStyle('I')->getAlignment()->setWrapText(true); 

        $sheet->getStyle('A2:A'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('B2:B'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('C2:C'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('D2:D'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('E2:E'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('F2:F'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('G2:G'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('H2:H'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('I2:I'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('J2:J'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('K2:K'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
        $sheet->getStyle('L2:L'.$lastRow)->getAlignment()->setHorizontal('left')->setVertical('top');
    }

    
}

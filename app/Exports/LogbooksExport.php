<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LogbooksExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $internship;
    private $rowNumber = 0;

    public function __construct($internship)
    {
        $this->internship = $internship;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->internship->dailyLogbooks()->orderBy('date', 'asc')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Hari / Tanggal',
            'Aktivitas',
            'Status',
        ];
    }

    public function map($logbook): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            \Carbon\Carbon::parse($logbook->date)->isoFormat('dddd, D MMMM Y'),
            strip_tags($logbook->activity),
            ucfirst($logbook->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}

<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ClientsExport implements FromArray, WithHeadings, WithEvents, WithStyles
{
    protected $clients;
    protected $organization;
    protected $count;

    public function __construct($clients, $organization, $count)
    {
        $this->clients = $clients;
        $this->organization = $organization;
        $this->count = $count;
    }


    public function array(): array
    {
        return $this->clients;
    }

    public function headings(): array
    {
        return [
            [
                'Организация',
                ' ',
                'Директор',
                ' ',
                'Баланс',
                'Клиенты',
                'Телефон',
                'Источник',
            ],
            [
                $this->organization->name,
                ' ', $this->organization->director_name,
                ' ', $this->organization->balance, $this->organization->clients_count, $this->organization->phone,
                'Waternet'
            ],
            [
                '',
                'ФИО',
                'Телефон',
                'Область(Район)',
                'Доп. адрес',
                'Баланс',
                'Долг(Бак.)',
                'Пос. активност'
            ]
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            2 => ['font' => ['bold' => true]],
            3 => ['font' => ['bold' => true]],
        ];

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {


                $event->sheet->getDelegate()->getStyle('A1:H' . $this->count)
                    ->getAlignment()
                    ->applyFromArray(
                        array(
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            'wrap' => TRUE
                        )
                    );

                $event->sheet->mergeCells('A1:B1');
                $event->sheet->mergeCells('A2:B2');
                $event->sheet->mergeCells('C1:D1');
                $event->sheet->mergeCells('C2:D2');

                $event->sheet->getDelegate()->getStyle('A1:H' . $this->count)
                    ->getAlignment()
                    ->setWrapText(true);

                $event->sheet->getStyle('A1:H' . $this->count)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ],
                    ]
                ]);


                $event->sheet->getDelegate()->freezePane('A1');
                $event->sheet->getDelegate()->freezePane('A2');
                $event->sheet->getDelegate()->freezePane('A3');
                $event->sheet->getDelegate()->freezePane('A4');

                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(40);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(25);

                $event->sheet->getDelegate()->getStyle('A1:H2')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('002060');

                $event->sheet->getDelegate()->getStyle('A3:H3')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('8DB4E2');

                $event->sheet->getStyle('A1:H3')->applyFromArray([
                    'font' => array(
                        'color' => ['argb' => 'ffffff'],
                    )
                ]);

            },
        ];
    }


}
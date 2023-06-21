<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ResultsExport implements FromArray, WithHeadings, WithEvents, WithStyles
{
    protected $data;
    protected $summorder;
    protected $summtakeproduct;
    protected $summsoldproducts;
    protected $summsoldsumm;
    protected $summentrycon;
    protected $summpayment1;
    protected $summpayment2;
    protected $summpayment3;
    protected $takesumm;
    protected $dolgsumm;
    protected $organization;
    protected $count;

    public function __construct(
        $data,
        $summorder,
        $summtakeproduct,
        $summsoldproducts,
        $summsoldsumm,
        $summentrycon,
        $summpayment1,
        $summpayment2,
        $summpayment3,
        $takesumm,
        $dolgsumm,
        $organization,
        $count
    ) {
        $this->data = $data;
        $this->summorder = $summorder;
        $this->summtakeproduct = $summtakeproduct;
        $this->summsoldproducts = $summsoldproducts;
        $this->summsoldsumm = $summsoldsumm;
        $this->summentrycon = $summentrycon;
        $this->summpayment1 = $summpayment1;
        $this->summpayment2 = $summpayment2;
        $this->summpayment3 = $summpayment3;
        $this->takesumm = $takesumm;
        $this->dolgsumm = $dolgsumm;
        $this->organization = $organization;
        $this->count = $count;
    }


    public function array(): array
    {
        return $this->data;
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
                'Роль',
                'Получил заказ',
                'Получил товар',
                'Продал товар',
                'Сумма',
                'Получил бак',
                'Вернул бак',
                'Наличные',
                'Пластик',
                'Перечисления',
                'Долг'
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


                $event->sheet->getDelegate()->getStyle('A1:M' . $this->count)
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

                $event->sheet->getDelegate()->getStyle('A1:M' . $this->count)
                    ->getAlignment()
                    ->setWrapText(true);

                $event->sheet->getStyle('A1:H2')->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                        ],
                    ]
                ]);

                $event->sheet->getStyle('A3:M' . $this->count)->applyFromArray([
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

                $event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
                $event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
                $event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
                $event->sheet->getDelegate()->getColumnDimension('D')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('E')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('F')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('G')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('H')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('I')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('J')->setWidth(15);
                $event->sheet->getDelegate()->getColumnDimension('K')->setWidth(14);
                $event->sheet->getDelegate()->getColumnDimension('L')->setWidth(16);
                $event->sheet->getDelegate()->getColumnDimension('M')->setWidth(14);

                $event->sheet->getDelegate()->getStyle('A1:H2')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('002060');

                $event->sheet->getDelegate()->getStyle('A3:M3')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('8DB4E2');

                $event->sheet->getStyle('A1:M3')->applyFromArray([
                    'font' => array(
                        'color' => ['argb' => 'ffffff'],
                    )
                ]);

            },
        ];
    }


}
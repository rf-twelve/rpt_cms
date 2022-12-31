<?php

namespace App\Exports;

use App\Models\RptAccount;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;

class RptAccountExportAll implements FromQuery, WithHeadings, WithMapping

{
    use Exportable;

    // public function __construct(string $myQuery)
    // {
    //     $this->myQuery = $myQuery;
    // }

    public function query()
    {
        // return RptAccount::query()->where('created_at', 'like', '%' . $this->myQuery . '%')
        //     ->orderBy('last_name', 'asc');
        $data = RptAccount::get();
        // dd($data[0]->rpt_pin);
        return $data[0];
    }


    public function map($rptAcc): array
    {
        return [
            $rptAcc->rpt_pin,
            $rptAcc->rpt_kind,
            $rptAcc->rpt_class,
        ];
    }

    public function headings(): array
    {
        return [
            'PIN',
            'KIND',
            'CLASSIFICATION',
            'TD/ARP NO.',
            'NAME OF THE OWNER/S',
            'ADDRESS',
            'DATE OF TRANSFER',
            'LOT/BLK NO.',
            'STREET',
            'BARANGAY',
            'MUNICIPALITY',
            'PROVINCE',
            '1957-1966',
            '1967-1973',
            '1974-1979',
            '1980-1984',
            '1985-1993',
            '1994-1996',
            '1997-2002',
            '2003-2019',
            'PREVIOUS',
            'NEXT',
            'EFFECTIVITY',
            'BASIC',
            'SEF',
            'PENALTY',
            'TOTAL',
            'BASIC',
            'SEF',
            'PENALTY',
            'TOTAL',
            'OR. No.',
            'DATE OF PAYMENT',
            'PAYMENT COVERED',
            'REMARKS',
            'START OF PAYMENT AS OF AUGUST 2021',
        ];
    }
}

<?php

namespace App\Exports;

use App\Models\Vaslist;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class VasExport implements FromQuery, WithColumnFormatting, WithHeadings, WithMapping
{
    use Exportable;

    public function __construct(string $myQuery)
    {
        $this->myQuery = $myQuery;
    }

    public function query()
    {

        // $data = Vaslist::query()->where('created_at', 'like', '%' . $this->myQuery . '%')
        //     ->orderBy('last_name', 'asc');
        return Vaslist::query()->where('created_at', 'like', '%' . $this->myQuery . '%')
            ->orderBy('vas_last_name', 'asc');
    }

    public function map($vimvas): array
    {
        return [
            $vimvas->vas_category,
            $vimvas->vas_unique_id,
            $vimvas->vas_pwd_id,
            $vimvas->vas_indigenous_member,
            $vimvas->vas_last_name,
            $vimvas->vas_first_name,
            $vimvas->vas_mid_name,
            $vimvas->vas_suffix,
            $vimvas->vas_contact_no,
            $vimvas->vas_region,
            $vimvas->vas_province,
            $vimvas->vas_municipality,
            $vimvas->vas_barangay,
            $vimvas->vas_sex,
            Date::stringToExcel($vimvas->vas_birthdate),
            $vimvas->vas_deferral,
            $vimvas->vas_deferral_reason,
            $vimvas->vas_vac_date,
            $vimvas->vas_vac_manufacturer_name,
            $vimvas->vas_batch_no,
            $vimvas->vas_lot_no,
            $vimvas->vas_cbcr_id,
            $vimvas->vas_vaccinator,
            $vimvas->vas_dose_1st,
            $vimvas->vas_dose_2nd,
            $vimvas->vas_adverse_event,
            $vimvas->vas_adverse_ccondition,
            // $vimvas->encoder,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'O' => NumberFormat::FORMAT_DATE_XLSX14,
        ];
    }

    public function headings(): array
    {
        return [
            'CATEGORY',
            'UNIQUE_PERSON_ID',
            'PWD',
            'Indigenous Member',
            'LAST_NAME',
            'FIRST_NAME',
            'MIDDLE_NAME',
            'SUFFIX',
            'CONTACT_NO.',
            'REGION',
            'PROVINCE',
            'MUNI_CITY',
            'BARANGAY',
            'SEX',
            'BIRTHDATE',
            'DEFERRAL',
            'REASON FOR DEFERRAL',
            'VACCINATION_DATE',
            'VACCINATION_MANUFACTURER_NAME',
            'BATCH_NUMBER',
            'LOT_NO',
            'BAKUNA_CENTER_CBCR_ID',
            'VACCINATOR_NAME',
            '1ST_DOSE',
            'SECOND_DOSE',
            'Adverse Event',
            'Adverse Event Condition'
        ];
    }
}

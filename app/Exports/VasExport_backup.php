<?php

namespace App\Exports;

use App\Models\Vas;

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
        return Vas::query()->where('created_at', 'like', '%' . $this->myQuery . '%')
            ->orderBy('last_name', 'asc');
    }

    public function map($vimvas): array
    {
        return [
            $vimvas->category,
            $vimvas->cat_id,
            $vimvas->cat_id_no,
            $vimvas->phealth_id,
            $vimvas->pwd_id,
            $vimvas->last_name,
            $vimvas->first_name,
            $vimvas->mid_name,
            $vimvas->suffix,
            $vimvas->contact_no,
            $vimvas->res_bhs,
            $vimvas->res_region,
            $vimvas->res_province,
            $vimvas->res_municipality,
            $vimvas->res_barangay,
            $vimvas->sex,
            // $vimvas->birthdate,
            Date::stringToExcel($vimvas->birthdate),
            // $vimvas->age,
            // $vimvas->civil_status,
            // $vimvas->employ_status,
            // $vimvas->interact_w_covid,
            // $vimvas->profession,
            // $vimvas->emp_name,
            // $vimvas->emp_province,
            // $vimvas->emp_address,
            // $vimvas->emp_contact_no,
            $vimvas->consent,
            $vimvas->reason,
            // $vimvas->temp,
            // $vimvas->bp,
            $vimvas->morethan_16,
            $vimvas->alrgy_peg,
            $vimvas->alrgy_reaction,
            $vimvas->alrgy_food,
            $vimvas->monitor_patient,
            $vimvas->bleed_disorder,
            $vimvas->syringe_available,
            $vimvas->manifest_symptoms,
            $vimvas->specify_symptoms,
            $vimvas->covid_exposure,
            $vimvas->treated_for_covid,
            $vimvas->received_any_vaccine,
            $vimvas->not_received_antibodies,
            $vimvas->not_pregnant,
            $vimvas->pregnant_trimester,
            $vimvas->under_medication,
            $vimvas->specify_condition,
            $vimvas->medical_clearance,
            $vimvas->deferral,
            $vimvas->vaccination_date,
            $vimvas->vaccination_manufacturer,
            $vimvas->batch_no,
            $vimvas->lot_no,
            $vimvas->vaccinator_name,
            $vimvas->vaccinator_profession,
            $vimvas->first_dose,
            $vimvas->second_dose,
            // $vimvas->encoder,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'Q' => NumberFormat::FORMAT_DATE_XLSX14,
        ];
    }

    public function headings(): array
    {
        return [
            'Category',
            'Category_ID',
            'Category_ID_Number',
            'PhilHealth_ID',
            'PWD ID',
            'Last_Name',
            'First_Name',
            'Middle_Name',
            'Suffix',
            'Contact_No.',
            'Unit/Building/House_Number,_Street_Name',
            'Region',
            'Province',
            'Municipality/City',
            'Barangay',
            'Sex',
            'Birthdate_mm/dd/yyyy',
            'CONSENT',
            'Reason for Refusal',
            'Age more than 16 years old?',
            'Has no allergies to PEG or polysorbate?',
            'Has no severe allergic reaction after the 1st dose of the vaccine?',
            'Has no allergy to food, egg, medicines, and no asthma?',
            'If with allergy or asthma, will the vaccinator able to monitor the patient for 30 minutes?',
            'Has no history of bleeding disorders or currently taking anti-coagulants?',
            'if with bleeding history, is a gauge 23 - 25 syringe available for injection?',
            'Does not manifest any of the following symptoms: Fever/chills, Headache, Cough, Colds, Sore throat,  Myalgia, Fatigue, Weakness, Loss of smell/taste, Diarrhea, Shortness of breath/ difficulty in breathing',
            'If manifesting any of the mentioned symptom/s, specify all that apply',
            'Has no history of exposure to a confirmed or suspected COVID-19 case in the past 2 weeks?',
            'Has not been previously treated for COVID-19 in the past 90 days?',
            'Has not received any vaccine in the past 2 weeks?',
            'Has not received convalescent plasma or monoclonal antibodies for COVID-19 in the past 90 days?',
            'Not Pregnant?',
            'if pregnant, 2nd or 3rd Trimester?',
            'Does not have any of the following: HIV, Cancer/ Malignancy, Underwent Transplant, Under Steroid Medication/ Treatment, Bed Ridden, terminal illness, less than 6 months prognosis ',
            'If with mentioned condition/s, specify.',
            'If with mentioned condition, has presented medical clearance prior to vaccination day?',
            'Deferral',
            'Date of Vaccination ',
            'Vaccine Manufacturer Name',
            'Batch Number',
            'Lot Number',
            'Vaccinator Name',
            'Profession of Vaccinator',
            '1st Dose',
            '2nd Dose',
        ];
    }
}

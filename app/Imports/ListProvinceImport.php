<?php

namespace App\Imports;

use App\Models\ListProvince;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ListProvinceImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ListProvince([
            'name' => $row['name'],
            'index' => $row['index'],
        ]);
    }
}

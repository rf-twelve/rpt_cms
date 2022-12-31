<?php

namespace App\Imports;

use App\Models\ListBarangay;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ListBarangayImport implements ToModel, WithHeadingRow
{
    use Importable;

    public function model(array $row)
    {
        return new ListBarangay([
            'name' => $row['name'],
            'index' => $row['index'],
        ]);
    }
}

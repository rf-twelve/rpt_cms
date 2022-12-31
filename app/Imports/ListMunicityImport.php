<?php

namespace App\Imports;

use App\Models\ListMunicity;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ListMunicityImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new ListMunicity([
            'name' => $row['name'],
            'index' => $row['index'],
        ]);
    }
}

<?php

namespace App\Imports;

use Informatics\Base\Models\DataAddress;
use Maatwebsite\Excel\Concerns\ToModel;

class DataAddressImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new DataAddress([
            'province' => $row[0],
            'district' => $row[1],
            'village' => $row[2],
        ]);
    }
}

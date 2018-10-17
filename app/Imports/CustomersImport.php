<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;


class CustomersImport implements ToModel
{
    public function model(array $row)
    {
        return new Customer([
            'nume'           => $row[0],
            'contractor_ean' => $row[1],
            'adresa'         => $row[2],
            'iln'            => $row[3],
            'cui'            => $row[4]
        ]);
    }
}

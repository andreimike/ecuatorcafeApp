<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithMappedCells;
//use Maatwebsite\Excel\Concerns\ToCollection;
//use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;


class CustomersImport implements ToModel
{
    use Importable;

    public function model(array $row)
    {
        return new Customer([
            'nume' => $row[0][7][2],
            'adresa' => $row[0][9][2],
            'iln' => $row[0][8][2],
            'cui' => $row[0][10][2]
        ]);
    }
}


//class CustomersImport implements ToCollection
//{
//    public function collection(Collection $rows)
//    {
//        foreach ($rows as $row)
//        {
//            dd($row);
//        }
//    }
//}


//class CustomersImport implements WithMappedCells, ToModel
//{
//    /**
//     * @param array $row
//     *
//     * @return \Illuminate\Database\Eloquent\Model|null
//     */
//
//    public function mapping(): array
//    {
//        return
//            [
//                'nume' => 'A1',
//                'adresa' => 'A2',
//                'iln' => 'A3',
//                'cui' => 'A4'
//            ];
//    }
//
//    public function model(array $row)
//    {
//
//        return new Customer([
//            'nume' => $row['nume'],
//            'adresa' => $row['adresa'],
//            'iln' => $row['iln'],
//            'cui' => $row['cui']
//        ]);
//    }
//}
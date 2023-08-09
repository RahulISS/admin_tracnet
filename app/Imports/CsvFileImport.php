<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Concerns;
use App\Models\API\Aproduct;





class CsvFileImport implements ToModel,WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $rows)
    {
        
        foreach ($rows as $row) {
           
            // Aproduct::create([
            //     'field1' => $row[0],
            //     'field2' => $row[1],
            //     // Map other fields accordingly
            // ]);
        }
    }
}
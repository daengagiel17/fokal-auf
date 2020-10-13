<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AnggotaImport implements WithMultipleSheets 
{
    public function sheets(): array
    {
        return [
            // 'DT<97' => new FirstSheetImport(),
            // 'DT-97' => new FirstSheetImport(),
            // 'DT-98' => new FirstSheetImport(),
            // 'DT-99' => new FirstSheetImport(),
            // 'DT-00' => new FirstSheetImport(),
            // 'DT-01' => new FirstSheetImport(),
            // 'DT-02' => new FirstSheetImport(),
            // 'DT-03' => new FirstSheetImport(),
            // 'DT-04' => new FirstSheetImport(),
            // 'DT-06' => new FirstSheetImport(),
            // 'DT-07' => new FirstSheetImport(),
            // 'DT-08' => new FirstSheetImport(),
            // 'DT-09' => new FirstSheetImport(),
            // 'DT-10' => new FirstSheetImport(),
            // 'DT-11' => new FirstSheetImport(),
            // 'DT-12' => new FirstSheetImport(),
            // 'DT-13' => new FirstSheetImport(),
            // 'DT-14' => new FirstSheetImport(),
            // 'DT-15' => new FirstSheetImport(),
        ];
    }
}
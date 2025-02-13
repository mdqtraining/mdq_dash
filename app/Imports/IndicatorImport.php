<?php
namespace App\Imports;

use App\Models\Indicator;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndicatorImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Indicator([
            'branch' => $row['branch'],
            'department' => $row['department'],
            'designation' => $row['designation'],
            'rating' => $row['rating'],
            'added_by' => auth()->user()->name,
            'created_at' => now(),
        ]);
    }
}


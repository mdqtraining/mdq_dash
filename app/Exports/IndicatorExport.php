<?php
namespace App\Exports;

use App\Models\Indicator;
use Maatwebsite\Excel\Concerns\FromCollection;

class IndicatorExport implements FromCollection
{
    public function collection()
    {
        return Indicator::select('branch', 'department', 'designation', 'rating', 'added_by', 'created_at')->get();
    }
}

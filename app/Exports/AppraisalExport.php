<?php

namespace App\Exports;

use App\Models\Appraisal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AppraisalExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Appraisal::select('branch', 'department', 'designation', 'employee_name', 'target_rating', 'overall_rating', 'appraisal_date')->get();
    }

    public function headings(): array
    {
        return ['Branch', 'Department', 'Designation', 'Employee', 'Target Rating', 'Overall Rating', 'Appraisal Date'];
    }
}


<?php

namespace App\Exports;

use App\Models\GoalTracking;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GoalTrackingExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return GoalTracking::select(
            'id',
            'goal_type',
            'subject',
            'branch',
            'target',
            'start_date',
            'end_date',
            'rating',
            'progress',
            'description',
            'status',
            'created_at',
            'updated_at'
        )->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Goal Type',
            'Subject',
            'Branch',
            'Target',
            'Start Date',
            'End Date',
            'Rating',
            'Progress',
            'Description',
            'Status',
            'Created At',
            'Updated At'
        ];
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appraisal extends BaseModel
{
    use HasFactory;
    protected $table = 'appraisals';
    protected $fillable = [
        'branch',
        'department',
        'designation',
        'employee_name',
        'target_rating',
        'overall_rating',
        'appraisal_date',
    ];
}

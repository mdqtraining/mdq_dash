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
        'designation',
        'employee_name',
        'target_rating',
        'overall_rating',
        'department',
        'appraisal_date',
        'remark',
        'created_at',
        'updated_at',
    ];
}

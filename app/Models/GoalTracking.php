<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoalTracking extends BaseModel
{
    use HasFactory;
    
    protected $fillable = [
        'goal_type',
        'subject',
        'branch',
        'target',
        'status',
        'progress',
        'start_date',
        'end_date',
        'rating',
        'description',  // Corrected typo here
    ];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_name'); // Ensure 'company_id' exists in goal_trackings table
    }
}


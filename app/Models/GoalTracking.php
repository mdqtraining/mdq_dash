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
        'target_achievement',
        'start_date',
        'end_date',
        'rating',
        'discription',
    ];
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indicator extends Model
{
    use HasFactory;

    protected $table = "indicators";

    protected $fillable = [
        'branch',
        'department',
        'designation',
        'leadership',
        'project_management',
        'allocating_resources',
        'business_process',
        'oralcommunication',
    ];
    
}

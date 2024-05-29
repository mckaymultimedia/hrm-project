<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manage_leaves extends Model
{
    use HasFactory;
    protected $table = 'manage_leaves';
    protected $fillable = [
        'employee_id',
        'earn_type',
        'sick_type',
        'total_earn_leave',
        'total_sick_leave',
        'total_leaves',
        'title',
        'created_by'
    ];

}

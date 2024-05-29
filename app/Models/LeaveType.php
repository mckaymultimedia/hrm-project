<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $fillable = [
        'title',
        'days',
        'employee_id',
        'created_by',
    ];

    public function EmployeesLeave()
    {
        return $this->hasOne('App\Models\Employee', 'id', 'employee_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

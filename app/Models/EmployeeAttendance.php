<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeAttendance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'date','arrival_time','departure_time', 'status'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}

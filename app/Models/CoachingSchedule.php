<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoachingSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'date',
        'start_time',
        'end_time',
        'method',
    ];    

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}

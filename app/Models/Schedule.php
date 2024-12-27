<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'student_id', 'teacher_name', 'location', 'date', 'start_time', 'end_time', 'subject', 'method', 'note'
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
}

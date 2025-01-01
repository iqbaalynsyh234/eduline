<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PrivateSchedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'subject',
        'location',
        'teacher_id',
        'fee',
        'student_id',
    ];    
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relasi ke teacher
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}

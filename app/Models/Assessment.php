<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assessment extends Model
{
    use HasFactory, SoftDeletes; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'student_id',
        'date',
        'location',
        'time',
        'subject',
        'material',
        'notes',
    ];

    /**
     * Relationship with the User model (Student).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Accessor for formatted date and time.
     *
     * @return string
     */
    public function getFormattedDateTimeAttribute()
    {
        return $this->date . ' ' . $this->time;
    }
}

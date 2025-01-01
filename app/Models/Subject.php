<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code', 'type'];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($subject) {
            $subject->type = strtoupper(substr($subject->name, 0, 3));
        });
    }
}

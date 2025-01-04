<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subject extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'code', 'type', 'slug'];
    
    public function modules()
    {
        return $this->hasMany(EModule::class, 'subject_id', 'id');
    }    

    public static function boot()
    {
        parent::boot();

        // Generate slug saat membuat data baru
        static::creating(function ($subject) {
            $subject->slug = Str::slug($subject->name);
            $subject->type = strtoupper(substr($subject->name, 0, 3));
        });

        // Update slug saat memperbarui data
        static::updating(function ($subject) {
            $subject->slug = Str::slug($subject->name);
        });
    }

}

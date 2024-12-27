<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description', 'brand_id'];

    function users()
    {
        return $this->hasMany(User::class);
    }
    function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    function subPrograms()
    {
        return $this->hasMany(SubProgram::class);
    }

}


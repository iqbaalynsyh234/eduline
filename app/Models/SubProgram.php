<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubProgram extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'program_id', 'brand_id'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function eModules()
    {
        return $this->hasMany(EModule::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}

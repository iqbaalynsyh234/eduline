<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['subject_id', 'pdf_path', 'youtube_link', 'subprogram_id', 'brand_id', 'title'];

    public function subprogram()
    {
        return $this->belongsTo(SubProgram::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['module_id', 'title', 'description', 'slug', 'link'];

    public function module()
    {
        return $this->belongsTo(StudentModule::class, 'module_id');
    }
}

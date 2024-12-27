<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_kab';
    public $incrementing = false;
    public $timestamps = false;

    public function districts()
    {
        return $this->hasMany(District::class, 'id_kab', 'id_kab');
    }

    public function province()
    {
        return $this->belongsTo(Province::class, 'id_prov', 'id_prov');
    }
}

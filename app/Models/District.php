<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_kec';
    public $incrementing = false;
    public $timestamps = false;

    public function subdistricts()
    {
        return $this->hasMany(Subdistrict::class, 'id_kec', 'id_kec');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'id_kab', 'id_kab');
    }
}

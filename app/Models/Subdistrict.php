<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subdistrict extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_kel';
    public $incrementing = false;
    public $timestamps = false;

    public function district()
    {
        return $this->belongsTo(District::class, 'id_kec', 'id_kec');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Target extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = [
        'user_id', 'title', 'description', 'icon', 'color', 'schedule', 'time', 'slug'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kkmDetails()
    {
        return $this->hasMany(KkmDetail::class);
    }
}

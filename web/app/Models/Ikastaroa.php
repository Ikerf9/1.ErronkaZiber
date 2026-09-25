<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ikastaroa extends Model
{
    protected $table = 'ikastaroak';

    protected $primaryKey = 'id_ikastaroa';

    public $timestamps = false;

    protected $fillable = [
        'izenburua',
        'deskribapena',
        'edukiera',
        'hasiera_data',
        'amaiera_data'
    ];

    public function matrikulak()
    {
        return $this->hasMany(
            Matrikula::class,
            'id_ikastaroa',
            'id_ikastaroa'
        );
    }

    public function erabiltzaileak()
    {
        return $this->belongsToMany(
            Erabiltzailea::class,
            'matrikulak',
            'id_ikastaroa',
            'id_erabiltzailea'
        );
    }
}
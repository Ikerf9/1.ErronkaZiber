<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ikastaroa extends Model
{
    public const MAX_CAPACITY = 30;

    protected $attributes = ['edukiera' => self::MAX_CAPACITY];

    // Apply the same hard limit to enrollment checks, views and statistics.
    public function getEdukieraAttribute($value): int
    {
        return min(self::MAX_CAPACITY, max(0, (int) ($value ?? self::MAX_CAPACITY)));
    }

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
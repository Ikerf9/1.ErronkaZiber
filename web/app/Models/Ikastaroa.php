<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ikastaroa extends Model
{
    public const MAX_CAPACITY = 30;

    protected $attributes = ['edukiera' => self::MAX_CAPACITY];

    /**
     * Al leer la capacidad, devuelve un entero entre 0 y 30; si es nula, utiliza 30.
     * Así las comprobaciones de matrícula, las vistas y las estadísticas comparten el mismo límite.
     */
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

    /**
     * Define la relación con todas las matrículas del curso mediante id_ikastaroa.
     */
    public function matrikulak()
    {
        return $this->hasMany(
            Matrikula::class,
            'id_ikastaroa',
            'id_ikastaroa'
        );
    }

    /**
     * Define la relación con los usuarios inscritos usando matrikulak como tabla intermedia.
     */
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

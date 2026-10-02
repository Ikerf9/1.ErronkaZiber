<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Matrikula extends Model
{
    protected $table = 'matrikulak';

    protected $primaryKey = 'id_matrikula';

    public $timestamps = false;

    protected $fillable = [
        'id_erabiltzailea',
        'id_ikastaroa',
        'matrikula_data',
        'egoera'
    ];

    /**
     * Define la relación con el usuario al que pertenece la matrícula mediante id_erabiltzailea.
     */
    public function erabiltzailea()
    {
        return $this->belongsTo(
            Erabiltzailea::class,
            'id_erabiltzailea',
            'id_erabiltzailea'
        );
    }

    /**
     * Define la relación con el curso de la matrícula mediante id_ikastaroa.
     */
    public function ikastaroa()
    {
        return $this->belongsTo(
            Ikastaroa::class,
            'id_ikastaroa',
            'id_ikastaroa'
        );
    }
}

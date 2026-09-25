<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Erabiltzailea extends Authenticatable
{
    protected $table = 'erabiltzaileak';

    protected $primaryKey = 'id_erabiltzailea';

    public $timestamps = false;

    protected $fillable = [
        'izena',
        'abizenak',
        'emaila',
        'pasahitza',
        'id_rola',
        'aktibo'
    ];

    protected $hidden = [
        'pasahitza'
    ];

    public function getAuthPassword()
    {
        return $this->pasahitza;
    }

    public function rola()
    {
        return $this->belongsTo(
            Rola::class,
            'id_rola',
            'id_rola'
        );
    }

    public function matrikulak()
    {
        return $this->hasMany(
            Matrikula::class,
            'id_erabiltzailea',
            'id_erabiltzailea'
        );
    }

    public function ikastaroak()
    {
        return $this->belongsToMany(
            Ikastaroa::class,
            'matrikulak',
            'id_erabiltzailea',
            'id_ikastaroa'
        );
    }
}
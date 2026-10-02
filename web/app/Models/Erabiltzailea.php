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

    /**
     * Indica a Laravel que la columna de contraseña de este modelo se llama pasahitza.
     */
    public function getAuthPasswordName()
    {
        return 'pasahitza';
    }

    /**
     * Devuelve la contraseña almacenada para que Laravel compruebe las credenciales.
     */
    public function getAuthPassword()
    {
        return $this->pasahitza;
    }

    /**
     * Define la relación con el rol del usuario mediante la clave id_rola.
     */
    public function rola()
    {
        return $this->belongsTo(
            Rola::class,
            'id_rola',
            'id_rola'
        );
    }

    /**
     * Define la relación con todas las matrículas del usuario mediante id_erabiltzailea.
     */
    public function matrikulak()
    {
        return $this->hasMany(
            Matrikula::class,
            'id_erabiltzailea',
            'id_erabiltzailea'
        );
    }

    /**
     * Define la relación con los cursos del usuario usando matrikulak como tabla intermedia.
     */
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

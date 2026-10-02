<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rola extends Model
{
    protected $table = 'rolak';

    protected $primaryKey = 'id_rola';

    public $timestamps = false;

    protected $fillable = [
        'rola_izena',
        'deskribapena'
    ];

    /**
     * Define la relación con todos los usuarios que tienen este rol mediante id_rola.
     */
    public function erabiltzaileak()
    {
        return $this->hasMany(
            Erabiltzailea::class,
            'id_rola',
            'id_rola'
        );
    }
}

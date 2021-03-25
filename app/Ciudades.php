<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ciudades extends Model
{

    protected $table = 'ciudades';

    protected $fillable = [
        'provincia_id',
        'descripcion',
        'estado'
    ];


    public function provincia()
    {
        return $this->belongsTo(Provincias::class);
    }

    public function cliente()
    {
        return $this->hasMany(Clientes::class);
    }
}

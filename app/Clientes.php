<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'discapacidad_id',
        'ciudad_id',
        'priNombre',
        'segNombre',
        'priApellido',
        'segApellido',
        'fechNacimiento',
        'numCedula',
        'codigoCli',
        'direccion',
        'email',
        'telefono',
        'genero',
        'estado',
        'nivelDiscapacidad'
    ];


    public function discapacidad()
    {
        return $this->belongsTo(Discapacidades::class);
    }

    public function ciudad()
    {
        return $this->belongsTo(Ciudades::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincias extends Model
{

    protected $table = 'provincias';

    protected $fillable = [
        'descripcion',
        'estado'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function ciudades()
    {
        return $this->hasMany(Ciudades::class);
    }
}

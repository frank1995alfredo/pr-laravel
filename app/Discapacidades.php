<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discapacidades extends Model
{
    protected $table = 'discapacidades';

    protected $fillable = [
         'descripcion',
         'estado'
    ];
 
        protected $hidden = [
         'created_at', 'updated_at'
     ]; 
    
     public function cliente()
    {
        return $this->hasMany(Clientes::class);
    }

}

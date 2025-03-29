<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    //
    //protected $table = 'wp_persona'; //esto es para cuando la tabla se llama difente en la bd
    
    //protected $primaryKey = 'id_persona';
    //public $incrementing = false; // si la llave primaria no es incrementable
    //protected $keyType = 'string'; // si la llave primara es string

    //public $timestamps = false; // cuando no tengo campos created_at, updated_at

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function documentos(){
        return $this->hasMany(Documento::class);
    }
}

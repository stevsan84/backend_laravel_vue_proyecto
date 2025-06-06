<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    //
    public function categoria(){
        return $this->belongsTo(Categoria::class);
    }

    public function pedidos(){
        return $this->belongsToMany(Pedido::class)
            ->withTimestamps()
            ->withPivot(["cantidad"]);
    }
}

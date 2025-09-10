<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
       public function autores() {
        return $this->belongsToMany(Autor::class, 'libro_autor');
    }

    public function editorial() {
        return $this->belongsTo(Editorial::class, 'id_editorial');
    }

    public function ejemplares() {
        return $this->hasMany(Ejemplar::class, 'libro_id');
    }

}

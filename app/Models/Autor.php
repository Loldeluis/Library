<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autor extends Model
{
    public function libros() {
        return $this->belongsToMany(Libro::class, 'libro_autor');
    }

}

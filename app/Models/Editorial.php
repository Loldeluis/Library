<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    public function libros() {
        return $this->hasMany(Libro::class, 'id_editorial');
    }

}

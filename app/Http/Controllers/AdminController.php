<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    
     public function index()
    {
        // Por ahora puedes devolver un texto simple para probar
        return 'Bienvenido al panel de administración';
        
        // Cuando tengas la vista, usa:
        // return view('admin.index');
    }

    
}

<?php

namespace App\Http\Controllers;

use APP\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    //

    public function edit() {
    return view('perfil.edit', ['user' => auth()->user()]);
}

public function update(Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
    ]);

$user     = User::find(Auth::id());
$user->update($request->only('name', 'email'));


    return redirect('/perfil')->with('success', 'Perfil actualizado');
}

}

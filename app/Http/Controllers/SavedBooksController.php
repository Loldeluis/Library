<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SavedBooksController extends Controller
{
    public function index(Request $request)
{
    $q = $request->get('q');
    $query = auth()->user()->ejemplares()->with('libro');

    if ($q) {
        $query->whereHas('libro', function($b) use ($q) {
            $b->where('titulo', 'like', "%{$q}%")
              ->orWhere('isbn', 'like', "%{$q}%");
        });
    }

    $ejemplares = $query->paginate(12);

    return view('books.saved', compact('ejemplares', 'q'));
}

}

<?php
namespace App\Http\Controllers;

use App\Services\GoogleBooks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookLookupController extends Controller
{
    public function __construct(private GoogleBooks $google) {}

public function byIsbn(string $isbn)
{
    $key = 'gbooks:isbn:' . $isbn;

    try {
        $raw = Cache::remember($key, now()->addHours(6), function () use ($isbn) {
            return $this->google->searchByIsbn($isbn);
        });
    } catch (\Throwable $e) {
        return response()->json([
            'message' => 'Excepción consultando Google Books',
            'error'   => $e->getMessage()
        ], 500);
    }

    // Si la respuesta trae un error controlado desde el servicio
    if (!empty($raw['error'])) {
        return response()->json([
            'message' => 'Error consultando Google Books',
            'detail'  => $raw
        ], 502);
    }

    // Aseguramos que siempre sea un array
    $items = collect($raw['items'] ?? [])
        ->map(fn($i) => $this->google->mapVolumeToBook($i))
        ->values();

    return response()->json([
        'query'   => ['isbn' => $isbn],
        'count'   => $items->count(),
        'results' => $items,
    ]);
}


public function search(Request $request)
{
    $request->validate([
    'q' => ['required', 'string', ',min:2'],
    'max' => ['nulleable', 'integer' , 'min:1', 'max:40'],
    ]);

    $q = $request->string('q');
    $max = (int) $request->input('max' , 10);

    $key = 'gbooks:q:' . md5($q . '|' . $max);

    $raw = Cache::remember($key, now()->addHours(6), function () use ($q, $max) {
    return $this->google->searchByText($q, $max); 
    });

    if(!empty($raw['error'])){
        return response()->json(['message' => 'Error consultando Google Books', 'detail' => $raw], 502);
    }
    
    $items = collect($raw['items'] ?? []) -> map(fn($i) => $this->google->mapVolumeToBook($i))->values();

    return response()->json([
        'query' => ['q' => $q, 'max' => $max],
        'counts' => $items->count(),
        'result' => $items,
    ]);
  }

public function byQuery(Request $request)
{
    $q   = $request->string('q')->trim();
    $max = $request->integer('max', 20);

    // 1. Si parecen solo dígitos (10–13), lo tratamos como ISBN
    if (preg_match('/^\d{10,13}$/', $q)) {
        // a) Primero intentamos Google Books con searchByIsbn
        $raw = Cache::remember("gbooks:isbn:{$q}", now()->addHours(6), fn() =>
            $this->google->searchByIsbn($q)
        );

        $items = collect($raw['items'] ?? [])->map(fn($i) =>
            $this->google->mapVolumeToBook($i)
        )->values();

        if ($items->isNotEmpty()) {
            return response()->json([
                'source'  => 'google_isbn',
                'query'   => ['isbn' => $q],
                'count'   => $items->count(),
                'results' => $items,
            ]);
        }

        // b) Si Google no lo tiene, buscamos en tu BD local
        $local = Libro::with('autores','editorial')
                      ->where('isbn', $q)
                      ->get()
                      ->map(fn($libro) => [
                          'titulo'         => $libro->titulo,
                          'autores'        => $libro->autores->pluck('nombre_completo')->toArray(),
                          'editorial'      => $libro->editorial->nombre,
                          'portada_medium' => $libro->portada_medium,
                      ]);

        if ($local->isNotEmpty()) {
            return response()->json([
                'source'  => 'local_db',
                'query'   => ['isbn' => $q],
                'count'   => $local->count(),
                'results' => $local,
            ]);
        }

        // c) Finalmente devolvemos empty
        return response()->json([
            'source'  => 'none',
            'query'   => ['isbn' => $q],
            'count'   => 0,
            'results' => [],
        ]);
    }

    // 2. Caso general de búsqueda por texto
    $cacheKey = 'gbooks:search:' . md5($q . '|' . $max);

    $raw = Cache::remember($cacheKey, now()->addHours(6), fn() =>
        $this->google->search($q, $max)
    );

    if (!empty($raw['error'])) {
        return response()->json(['message'=>'Error Google Books','detail'=>$raw], 502);
    }

    $items = collect($raw['items'] ?? [])->map(fn($i)=>
        $this->google->mapVolumeToBook($i)
    )->values();

    return response()->json([
        'source'  => 'google_text',
        'query'   => ['q'=>$q,'max'=>$max],
        'count'   => $items->count(),
        'results' => $items,
    ]);
}



}




?>
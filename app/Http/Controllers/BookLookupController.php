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

        $raw = Cache::remember($key, now()->addHours(6), function () use ($isbn) {
            return $this->google->searchByIsbn($isbn);
        });
        
        if(!empty($raw['error'])) {
            return response()->json(['message' => 'Error consultando Google Books', 'detail' => $raw], 502);
        }

        $items = collect($raw['items'] ?? []) -> map(fn($i) => $this->google->mapVolumeToBook($i))->values();

        return response()->json([
            'query' => ['isbn' => $isbn],
            'count' => $items->count(),
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
}



?>
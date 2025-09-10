<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GoogleBooks
{

protected string $baseUrl = 'https://www.googleapis.com/books/v1';
protected ?string $apiKey = null;

public function __construct()
{
    $this->apiKey = config('services.google.books_key');
}

public function searchByIsbn(string $isbn): array
{
    $params = ['q' => "isbn:{$isbn}"];
    if (!empty($this->apiKey)) {
        $params['key'] = $this->apiKey;
    }

    $response = Http::baseUrl($this->baseUrl)->get('volumes', $params);

    if ($response->failed()) {
        return [
            'items'  => [],
            'error'  => 'google_books_request_failed',
            'status' => $response->status()
        ];
    }

    return $response->json() ?? ['items' => []];
}

public function search(string $query, int $maxResults = 20): array
{
    $params = [
      'q'          => $query,
      'maxResults' => $maxResults,
    ];

    if (!empty($this->apiKey)) {
        $params['key'] = $this->apiKey;
    }

    $response = Http::baseUrl($this->baseUrl)
                    ->get('volumes', $params);

    if ($response->failed()) {
        return [
            'items'  => [],
            'error'  => 'google_books_request_failed',
            'status' => $response->status(),
        ];
    }

    return $response->json() ?? ['items' => []];
}


public function searchByText(string $query, int $max = 10 ): array 
{
    $response = Http::baseUrl($this->baseUrl)->get('volumes', [
            'q'          => $query,
            'key'        => $this->apiKey,
            'maxResults' => $max,
        ]);
        
        if ($response->failed()) {
            return ['items' => [], 'error' => 'google_books_request_failed', 'status' => $response->status()];
        }

        return $response->json() ?? ['items' => []];

}

public function mapVolumeToBook (array $item): array
{
        $v = $item['volumeInfo'] ?? [];
        $ids = collect($v['industryIdentifiers'] ?? []);

        $isbn10 = optional($ids->firstWhere('type', 'ISBN_10'))['identifier'] ?? null;
        $isbn13 = optional($ids->firstWhere('type', 'ISBN_13'))['identifier'] ?? null;

        return [
            // Campos de libros (título)
            'titulo'           => $v['title'] ?? null,
            'subtitulo'        => $v['subtitle'] ?? null,
            'autores'          => $v['authors'] ?? [],                  // array
            'editorial'        => $v['publisher'] ?? null,
            'anio_publicacion' => $this->yearOnly($v['publishedDate'] ?? null),
            'edicion'          => null,                                  // Google no siempre da edición
            'idioma'           => $v['language'] ?? null,
            'paginas'          => $v['pageCount'] ?? null,
            'sinopsis'         => $v['description'] ?? null,
            'formato'          => 'impreso',                             // por defecto, ajusta según flujo
            'serie'            => $this->extractSeries($v),
            'categorias'       => $v['categories'] ?? [],                // array
            'palabras_clave'   => [],

            // ISBN
            'isbn_10'          => $isbn10,
            'isbn_13'          => $isbn13,

            // Portadas
            'portada_small'    => $v['imageLinks']['smallThumbnail'] ?? null,
            'portada_medium'   => $v['imageLinks']['thumbnail'] ?? null,

            // Datos útiles para ejemplares o referencias
            'fuente_api'       => 'google_books',
            'google_volume_id' => $item['id'] ?? null,
        ];

}

protected function normalizeIsbn(string $isbn): string
{
    return preg_replace('/[^0-9Xx]/', '', $isbn);
}

protected function yearOnly(?string $date): ?int
{
    if(!$date) return null ;
    if(preg_match('/^\d{4}/', $date, $m)){
        return (int) $m[0];
    }
    return null;
}

protected function extractSeries(array $v): ?string
{
   return null; 
}

}




?>
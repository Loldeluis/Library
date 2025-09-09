<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Models\Autor;
use App\Models\Editorial;
use App\Models\Libro;
use App\Models\Ejemplar;
use Illuminate\Support\Facades\DB;

class BookRegistrationController extends Controller
{
    public function create()
    {

        return view('books.create');
    }

    public function store(StoreBookRequest $request)
    {
        $data = $request->validated();

        DB::transaction(function() use ($data) {
            $editorial = Editorial::firstOrCreate(
                ['nombre' => $data['editorial']]
            );

            $libro = Libro::create([
                'titulo'           => $data['titulo'],
                'isbn'             => $data['isbn'],
                'anio_publicacion' => $data['anio_publicacion'] ?? null,
                'idioma'           => $data['idioma'] ?? null,
                'paginas'          => $data['paginas'] ?? null,
                'sinopsis'         => $data['sinopsis'] ?? null,
                'formato'          => $data['formato'],
                'serie'            => $data['serie'] ?? null,
                'id_editorial'     => $editorial->id,
            ]);

            foreach ($data['autores'] as $nombre) {
                $autor = Autor::firstOrCreate(['nombre_completo' => $nombre]);
                $libro->autores()->syncWithoutDetaching($autor->id);
            }

            Ejemplar::create([
                'libro_id'         => $libro->id,
                'codigo_interno'   => $data['codigo_interno'],
                'fecha_adquisicion'=> $data['fecha_adquisicion'],
                'estado_actual'    => $data['estado_actual'],
                'ubicacion'        => $data['ubicacion'],
                'estado_fisico'    => $data['estado_fisico'] ?? 'bueno',
                'fuente'           => $data['fuente'] ?? 'desconocida',
            ]);
        });

        return redirect()->route('books.create')
                         ->with('success', 'Libro registrado correctamente.');
    }
}
?>

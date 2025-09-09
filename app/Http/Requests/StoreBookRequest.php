<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
        'isbn'               => ['required', 'string', 'min:10'],
        'titulo'             => ['required', 'string', 'max:255'],
        'autores'            => ['required', 'array', 'min:1'],
        'autores.*'          => ['string', 'max:100'],
        'editorial'          => ['required', 'string', 'max:255'],
        'anio_publicacion'   => ['nullable', 'integer', 'digits:4'],
        'paginas'            => ['nullable', 'integer', 'min:1'],
        'sinopsis'           => ['nullable', 'string'],
        'formato'            => ['required', 'in:impreso,digital,audio'],
        'serie'              => ['nullable', 'string', 'max:100'],
        'fecha_adquisicion'  => ['required', 'date'],
        'estado_actual'      => ['required', 'in:disponible,prestado,reservado,extraviado'],
        // campos de ejemplar
        'codigo_interno'     => ['required', 'string', 'max:50'],
        'ubicacion'          => ['required', 'string', 'max:100'],

        ];
    }
}

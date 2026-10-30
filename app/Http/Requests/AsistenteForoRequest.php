<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AsistenteForoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'correo'    => strtolower(trim((string) $this->input('correo'))),
            'matricula' => trim((string) $this->input('matricula')),
        ]);
    }

    public function rules(): array
    {
        $asistente = $this->route('asistente'); // null al crear, el modelo al editar

        $reglas = [
            'nombre'           => ['required', 'string', 'max:50'],
            'apellido_paterno' => ['required', 'string', 'max:50'],
            'apellido_materno' => ['required', 'string', 'max:50'],
            'edad'             => ['required', 'integer', 'min:15', 'max:99'],
            'matricula'        => ['required', 'digits:8', Rule::unique('asistentes_foro', 'matricula')->ignore($asistente)],
            'carrera_id'       => ['required', 'exists:carreras,id'],
            'cuatrimestre'     => ['required', Rule::in([1, 4, 7, 10])],
            'correo'           => ['required', 'email:rfc', 'max:100', Rule::unique('asistentes_foro', 'correo')->ignore($asistente)],
            'telefono'         => ['nullable', 'digits:10'],
        ];

        // Solo el admin puede cambiar el taller (al editar)
        if ($asistente) {
            $reglas['taller_id'] = ['nullable', 'exists:talleres,id'];
        }

        return $reglas;
    }

    public function messages(): array
    {
        return [
            'required'          => 'El campo :attribute es obligatorio.',
            'matricula.digits'  => 'La matrícula debe tener exactamente 8 números.',
            'matricula.unique'  => 'Esta matrícula ya está registrada en el Foro.',
            'correo.email'      => 'El correo debe ser válido y llevar @ (ej. nombre@correo.com).',
            'correo.unique'     => 'Este correo ya está registrado en el Foro.',
            'telefono.digits'   => 'El teléfono debe tener exactamente 10 números.',
            'cuatrimestre.in'   => 'Selecciona un cuatrimestre válido (1, 4, 7 o 10).',
            'carrera_id.exists' => 'Selecciona una carrera válida.',
            'taller_id.exists'  => 'Selecciona un taller válido.',
            'edad.integer'      => 'La edad debe ser un número.',
        ];
    }
}
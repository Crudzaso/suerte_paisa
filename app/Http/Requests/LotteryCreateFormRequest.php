<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LotteryCreateFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Asegúrate de que la autorización esté habilitada según tus necesidades.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'banner_url' => 'nullable|url|max:255',
            'logo_url' => 'nullable|url|max:255',
            'date_play' => 'required|date|after:today',
            'result' => 'nullable|string|max:255',
            'prize' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:1',
        ];
    }

    /**
     * Mensajes de validación personalizados.
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre de la lotería es obligatorio.',
            'name.string' => 'El nombre de la lotería debe ser una cadena de caracteres.',
            'name.max' => 'El nombre de la lotería no puede superar los 255 caracteres.',
            'description.string' => 'La descripción debe ser una cadena de caracteres.',
            'description.max' => 'La descripción no puede superar los 500 caracteres.',
            'banner_url.url' => 'La URL del banner debe ser una URL válida.',
            'logo_url.url' => 'La URL del logo debe ser una URL válida.',
            'date_play.required' => 'La fecha de juego es obligatoria.',
            'date_play.date' => 'La fecha de juego debe ser una fecha válida.',
            'date_play.after' => 'La fecha de juego debe ser posterior a hoy.',
            'price.required' => 'El precio de la lotería es obligatorio.',
            'price.numeric' => 'El precio debe ser un número válido.',
            'price.min' => 'El precio debe ser al menos 1.',
        ];
    }

    /**
     * Atributos de los campos.
     */
    public function attributes()
    {
        return [
            'name' => 'nombre',
            'description' => 'descripción',
            'banner_url' => 'URL del banner',
            'logo_url' => 'URL del logo',
            'date_play' => 'fecha de juego',
            'result' => 'resultado',
            'prize' => 'premio',
            'price' => 'precio',
        ];
    }
}

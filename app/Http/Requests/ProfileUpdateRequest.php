<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // --- Datos Académicos ---
            'name' => ['nullable', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/', 'max:255'],
            'ape_pat' => ['nullable', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/', 'max:255'],
            'ape_mat' => ['nullable', 'string', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s]+$/', 'max:255'],
            'university_code' => ['nullable', 'string', 'regex:/^[0-9]+$/', 'max:10'],
            'academic_department' => ['nullable', 'string', 'max:255'],
            'dedication' => ['nullable', 'string', 'max:255'],
            'condition' => ['nullable', 'string', 'max:255'],

            // --- Datos Personales ---
            'gender' => ['nullable', 'string', 'in:Masculino,Femenino'],
            'birthdate' => ['nullable', 'date', 'before:today'],
            'dni' => ['nullable', 'string', 'regex:/^[0-9]{8}$/', 'size:8'],
            'phone' => ['nullable', 'string', 'regex:/^[0-9]{9}$/', 'size:9'],
            'ruc' => ['nullable', 'string', 'regex:/^[0-9]{11}$/', 'size:11'],
            'military_lib' => ['nullable', 'string', 'regex:/^[0-9]+$/', 'max:20'],
            'license_category' => ['nullable', 'string', 'max:50'],
            'vehicle_info' => ['nullable', 'string', 'max:255'],

            // --- Estado Civil ---
            'marital_status' => ['nullable', 'string', 'in:Soltero(a),Casado(a),Viudo(a),Divorciado(a)'],
            'marriage_date' => ['nullable', 'date', 'before_or_equal:today'],
            'blood_type' => ['nullable', 'string', 'in:A+,A-,B+,B-,AB+,AB-,O+,O-'],

            // --- Contacto ---
            'personal_email' => ['nullable', 'email', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            // --- Ubicación ---
            'birthplace' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
        ];
    }

    /**
     * Mensajes de validación personalizados en español.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Nombres y apellidos
            'name.regex' => 'El nombre solo puede contener letras y espacios.',
            'ape_pat.regex' => 'El apellido paterno solo puede contener letras y espacios.',
            'ape_mat.regex' => 'El apellido materno solo puede contener letras y espacios.',

            // Código universitario
            'university_code.regex' => 'El código universitario solo puede contener números.',
            'university_code.max' => 'El código universitario no puede exceder los 10 caracteres.',

            // DNI
            'dni.regex' => 'El DNI debe contener exactamente 8 dígitos numéricos.',
            'dni.size' => 'El DNI debe tener exactamente 8 caracteres.',

            // Teléfono/Celular
            'phone.regex' => 'El celular debe contener exactamente 9 dígitos numéricos. No se permiten letras ni espacios.',
            'phone.size' => 'El celular debe tener exactamente 9 dígitos.',

            // RUC
            'ruc.regex' => 'El RUC debe contener exactamente 11 dígitos numéricos.',
            'ruc.size' => 'El RUC debe tener exactamente 11 caracteres.',

            // Libreta Militar
            'military_lib.regex' => 'La libreta militar solo puede contener números.',

            // Género
            'gender.in' => 'El sexo seleccionado no es válido.',

            // Estado Civil
            'marital_status.in' => 'El estado civil seleccionado no es válido.',

            // Grupo Sanguíneo
            'blood_type.in' => 'El grupo sanguíneo debe ser uno de: A+, A-, B+, B-, AB+, AB-, O+, O-.',

            // Fechas
            'birthdate.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'birthdate.date' => 'La fecha de nacimiento no tiene un formato válido.',
            'marriage_date.before_or_equal' => 'La fecha de matrimonio no puede ser futura.',
            'marriage_date.date' => 'La fecha de matrimonio no tiene un formato válido.',

            // Email
            'email.required' => 'El correo institucional es obligatorio.',
            'email.email' => 'El correo institucional debe ser una dirección válida.',
            'email.unique' => 'Este correo institucional ya está registrado por otro usuario.',
            'personal_email.email' => 'El correo personal debe ser una dirección válida.',
        ];
    }
}

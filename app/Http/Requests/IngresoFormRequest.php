<?php

namespace grado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngresoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
           'descripcion'=>'required|max:150',
           'fecha'=>'required',
           'alumno'=>'required',
           'valor'=>'required'
           

        ];
    }
}

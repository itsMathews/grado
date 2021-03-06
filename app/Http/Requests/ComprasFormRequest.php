<?php

namespace grado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComprasFormRequest extends FormRequest
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
            'valor'=>'required',
            'fecha'=>'required'
        ];
    }
}

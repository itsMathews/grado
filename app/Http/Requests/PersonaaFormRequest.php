<?php

namespace grado\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersonaaFormRequest extends FormRequest
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
            'iden'=>'required|max:12',
            'nombres'=>'required|max:40',
            'apellidos'=>'required|max:40',
            'direccion'=>'required|max:80',
            'tel'=>'required|max:12'
        ];
    }
}

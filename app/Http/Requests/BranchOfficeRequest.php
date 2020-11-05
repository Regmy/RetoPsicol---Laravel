<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BranchOfficeRequest extends FormRequest
{
    const UNPROCESSABLE_ENTITY = 422;
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
            //
            'name'              => 'required | min:3 | unique:branch_offices',
            'tickets_quantity'  => 'required | numeric',
            'tickets_sold'      => '',
        ];
    }

    public function messages(){
        return [
            'name.required'                 => 'El campo Nombre es olbigatorio',
            'name.min'                      => 'El campo Nombre debe tener minimo 3 caracteres',
            'name.unique'                   => 'El Nombre seleccionado ya existe, elija otro por favor',
            'tickets_quantity.required'     => 'El campo Cantidad de tickets es olbigatorio',
            'tickets_quantity.numeric'      => 'El campo Cantidad de tickets debe ser numerico',
        ];
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), self::UNPROCESSABLE_ENTITY));
    }
}

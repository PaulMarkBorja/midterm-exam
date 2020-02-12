<?php

namespace App\Models\Stores\Requests;

use App\Models\Base\BaseFormRequest;

class CreateStoreTypeRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
        ];
    }

    public function messages()
    {
        return [
           'name.required' => 'The name field is required.'
        ];
    }
}

<?php

namespace App\Models\Stores\Requests;

use App\Models\Base\BaseFormRequest;

class CreateStoreRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type_id' => ['required'],
            'name' => ['required', 'unique:stores'],
            'email' => ['required', 'email', 'unique:stores'],
            'phone' => ['required'],
        ];
    }

    public function messages()
    {
        return [
           'name.required' => 'The name field is required.',
           'type_id.required' => 'The type field is required.',
        ];
    }
}

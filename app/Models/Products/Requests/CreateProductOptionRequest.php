<?php

namespace App\Models\Products\Requests;

use App\Models\Base\BaseFormRequest;

class CreateProductOptionRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'unique:product_options']
        ];
    }
}

<?php

namespace App\Models\Categories\Requests;

use App\Models\Base\BaseFormRequest;

class CreateCategoryRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required']
            // 'name' => ['required', 'unique:categories']
        ];
    }
}

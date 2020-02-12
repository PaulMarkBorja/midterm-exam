<?php

namespace App\Models\Customers\Requests;

use App\Models\Base\BaseFormRequest;

class UpdateCustomerRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
        'first_name' => ['required'],
        'last_name' => ['required'],
      ];
    }
}

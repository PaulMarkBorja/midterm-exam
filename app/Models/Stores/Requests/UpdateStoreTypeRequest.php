<?php

namespace App\Models\Stores\Requests;

use App\Models\Base\BaseFormRequest;

class UpdateStoreTypeRequest extends BaseFormRequest
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
}

<?php

namespace App\Models\Cuisines\Requests;

use App\Models\Base\BaseFormRequest;

class UpdateCuisineRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
      return [
          'name' => ['required', 'unique:cuisines,name,' . $this->id]
      ];
    }
}

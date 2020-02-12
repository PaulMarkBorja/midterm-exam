<?php

namespace App\Models\Stores\Requests;

use App\Models\Base\BaseFormRequest;

class UpdateStoreRequest extends BaseFormRequest
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
          'name' => ['required', 'unique:stores,name,' . $this->id],
      ];
    }
}

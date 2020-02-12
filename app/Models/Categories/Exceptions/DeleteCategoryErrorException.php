<?php

namespace App\Models\Categories\Exceptions;

class DeleteCategoryErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_category_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}

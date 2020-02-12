<?php

namespace App\Models\Cuisines\Exceptions;

class DeleteCuisineErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_cuisine_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}

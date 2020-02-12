<?php

namespace App\Models\Stores\Exceptions;

class DeleteStoreErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_store_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}

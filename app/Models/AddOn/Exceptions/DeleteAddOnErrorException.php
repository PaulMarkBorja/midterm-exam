<?php

namespace App\Models\AddOn\Exceptions;

class DeleteAddOnErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_add_on_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}

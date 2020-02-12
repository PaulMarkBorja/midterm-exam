<?php

namespace App\Models\Orders\Exceptions;

class DeleteOrderErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_order_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}

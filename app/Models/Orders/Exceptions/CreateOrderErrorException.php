<?php

namespace App\Models\Orderss\Exceptions;

class CreateOrderErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_order_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

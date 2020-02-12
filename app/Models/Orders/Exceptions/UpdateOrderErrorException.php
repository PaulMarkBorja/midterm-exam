<?php

namespace App\Models\Orders\Exceptions;

class UpdateOrderErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_order_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

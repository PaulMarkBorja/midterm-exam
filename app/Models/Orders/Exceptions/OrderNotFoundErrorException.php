<?php

namespace App\Models\Orders\Exceptions;

class OrderNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'Order_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}

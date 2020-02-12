<?php

namespace App\Models\Customers\Exceptions;

class CustomerNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'Customer_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}

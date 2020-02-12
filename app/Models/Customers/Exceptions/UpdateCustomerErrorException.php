<?php

namespace App\Models\Customers\Exceptions;

class UpdateCustomerErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_customer_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

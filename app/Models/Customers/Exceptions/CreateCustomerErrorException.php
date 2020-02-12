<?php

namespace App\Models\Customers\Exceptions;

class CreateCustomerErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_customer_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

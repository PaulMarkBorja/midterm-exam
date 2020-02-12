<?php

namespace App\Models\Customers\Exceptions;

class DeleteCustomerErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_customer_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}

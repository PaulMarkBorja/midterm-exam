<?php

namespace App\Models\Products\Exceptions;

class DeleteProductOptionErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_product_option_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}

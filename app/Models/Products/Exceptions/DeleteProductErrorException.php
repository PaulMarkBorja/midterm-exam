<?php

namespace App\Models\Products\Exceptions;

class DeleteProductErrorException extends \Exception
{

  public function render($request)
  {
       return response()->json([
            'error' => 'delete_product_query_exception',
            'message' => $this->getMessage()
        ],500);
  }

}

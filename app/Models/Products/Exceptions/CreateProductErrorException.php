<?php

namespace App\Models\Products\Exceptions;

class CreateProductErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_product_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

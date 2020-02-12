<?php

namespace App\Models\Products\Exceptions;

class CreateProductOptionErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_product_option_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

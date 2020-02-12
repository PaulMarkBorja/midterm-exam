<?php

namespace App\Models\Products\Exceptions;

class UpdateProductErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_product_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

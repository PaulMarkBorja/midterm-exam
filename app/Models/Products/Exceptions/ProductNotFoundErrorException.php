<?php

namespace App\Models\Products\Exceptions;

class ProductNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'Product_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}

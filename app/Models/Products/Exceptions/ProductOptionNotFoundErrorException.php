<?php

namespace App\Models\Products\Exceptions;

class ProductOptionNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'ProductOption_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}

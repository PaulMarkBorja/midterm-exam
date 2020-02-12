<?php

namespace App\Models\Products\Exceptions;

class UpdateProductOptionErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_ProductOption_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

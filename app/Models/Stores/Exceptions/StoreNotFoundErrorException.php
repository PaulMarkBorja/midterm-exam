<?php

namespace App\Models\Stores\Exceptions;

class StoreNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'store_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}

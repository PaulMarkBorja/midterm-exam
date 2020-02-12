<?php

namespace App\Models\Stores\Exceptions;

class UpdateStoreErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_store_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

<?php

namespace App\Models\Stores\Exceptions;

class CreateStoreErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_store_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

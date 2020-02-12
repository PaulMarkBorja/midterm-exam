<?php

namespace App\Models\AddOn\Exceptions;

class CreateAddOnErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_add_on_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

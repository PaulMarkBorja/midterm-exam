<?php

namespace App\Models\AddOn\Exceptions;

class UpdateAddOnErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_add_on_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

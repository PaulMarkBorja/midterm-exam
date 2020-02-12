<?php

namespace App\Models\Cuisines\Exceptions;

class UpdateCuisineErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_cuisine_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

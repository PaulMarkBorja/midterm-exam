<?php

namespace App\Models\Cuisines\Exceptions;

class CreateCuisineErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_cuisine_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

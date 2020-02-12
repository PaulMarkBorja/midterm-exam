<?php

namespace App\Models\Cuisines\Exceptions;

class CuisineNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'Cuisine_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}

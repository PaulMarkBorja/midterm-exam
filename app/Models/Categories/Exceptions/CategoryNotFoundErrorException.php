<?php

namespace App\Models\Categories\Exceptions;

class CategoryNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'category_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}

<?php

namespace App\Models\Categories\Exceptions;

class UpdateCategoryErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'update_category_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

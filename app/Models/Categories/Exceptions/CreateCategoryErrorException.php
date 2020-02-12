<?php

namespace App\Models\Categories\Exceptions;

class CreateCategoryErrorException extends \Exception
{

    public function render($request)
    {
         return response()->json([
              'error' => 'create_category_query_exception',
              'message' => $this->getMessage()
          ],500);
    }

}

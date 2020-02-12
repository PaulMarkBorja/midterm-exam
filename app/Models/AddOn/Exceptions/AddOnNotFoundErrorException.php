<?php

namespace App\Models\AddOn\Exceptions;

class AddOnNotFoundErrorException extends \Exception
{
    public function render($request)
    {
         return response()->json([
              'error' => 'AddOn_not_found',
              'message' => $this->getMessage()
          ],404);
    }
}

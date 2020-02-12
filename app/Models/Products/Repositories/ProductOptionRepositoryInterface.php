<?php

namespace App\Models\Products\Repositories;

interface ProductOptionRepositoryInterface
{

    function getById($id);

    function create(array $request);

    function update($id, array $request);

    function delete($id);
}

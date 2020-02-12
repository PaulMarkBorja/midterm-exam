<?php

namespace App\Models\Products\Repositories;

interface ProductRepositoryInterface
{
    function getAll($request);

    function getById($id);

    function create(array $request);

    function update($id, array $request);

    function delete($id);
}
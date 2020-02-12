<?php

namespace App\Models\Cuisines\Repositories;

use App\Models\Base\BaseRepositoryInterface;
use App\Models\Cuisines\Cuisine;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface CuisineRepositoryInterface extends BaseRepositoryInterface
{
    public function createCuisine(array $data): Cuisine;

    public function findCuisineById(int $id) : Cuisine;

    public function updateCuisine(array $data) : bool;

    public function deleteCuisine() : bool;

    public function listCuisines($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    function getAllCuisines(Request $request);
}

<?php

namespace App\Models\Categories\Repositories;

use App\Models\Base\BaseRepositoryInterface;
use App\Models\Categories\Category;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function createCategory(array $data): Category;

    public function findCategoryById(int $id) : Category;

    public function updateCategory(array $data) : bool;

    public function deleteCategory() : bool;

    public function listCategories($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    function getCategories() : Collection; //Unpaginated response

    function getAllCategories(Request $request);
}

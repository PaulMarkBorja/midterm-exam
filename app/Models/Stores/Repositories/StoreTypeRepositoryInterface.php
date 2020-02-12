<?php

namespace App\Models\Stores\Repositories;

use App\Models\Base\BaseRepositoryInterface;
use App\Models\Stores\StoreType;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface StoreTypeRepositoryInterface extends BaseRepositoryInterface
{
    public function createStoreType(array $data): StoreType;

    public function findStoreTypeById(int $id): StoreType;

    public function updateStoreType(array $data): bool;

    public function deleteStoreType(): bool;

    public function listStoreTypes($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    function getAllStoreTypes(Request $request);
}

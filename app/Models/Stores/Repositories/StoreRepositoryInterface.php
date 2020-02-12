<?php

namespace App\Models\Stores\Repositories;

use App\Models\Base\BaseRepositoryInterface;
use App\Models\Stores\Store;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

interface StoreRepositoryInterface extends BaseRepositoryInterface
{
    public function createStore(array $data): Store;

    public function findStoreById(int $id): Store;

    public function updateStore(array $data): bool;

    public function deleteStore(): bool;

    public function listStores($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc'): Collection;

    function getAllStores(Request $request);
}

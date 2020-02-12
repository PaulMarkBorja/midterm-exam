<?php

namespace App\Models\Stores\Repositories;

use App\Models\Base\BaseRepository;
use App\Models\Stores\StoreType;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class StoreTypeRepository extends BaseRepository implements StoreTypeRepositoryInterface
{
    /**
     * StoreTypeRepository constructor.
     *
     * @param StoreType $storeType
     */
    public function __construct(StoreType $storeType)
    {
        parent::__construct($storeType);
        $this->model = $storeType;
    }

    /**
     * @param array $data
     *
     * @return StoreType
     * @throws CreateStoreTypeErrorException
     */
    public function createStoreType(array $data): StoreType
    {
        return $this->create($data);
    }

    /**
     * @param int $id
     *
     * @return StoreType
     * @throws StoreTypeNotFoundErrorException
     */
    public function findStoreTypeById(int $id): StoreType
    {
        return $this->findOneOrFail($id);
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UpdateStoreTypeErrorException
     */
    public function updateStoreType(array $data): bool
    {
        return $this->update($data);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteStoreType(): bool
    {
        return $this->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listStoreTypes($columns = array('*'), string $orderBy = 'name', string $sortBy = 'asc'): Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function getAllStoreTypes(Request $request)
    {
        $r = $request;

        if (isset($r["sort"])) {
            $sort = explode("|", $r["sort"]);
        }

        if (isset($r["filter"])) {
            $types = $this->model->where('name', 'like', '%' . $r["filter"] . '%')->orderBy($sort[0], $sort[1])->paginate(5);
        } else if (!isset($r["sort"])) {
            $types = $this->model->paginate(5);
            return response()->json(compact('types'));
        } else {
            //$types = $this->model->orderBy($sort[0], $sort[1])->paginate(5);
            $types = $this->model->orderBy($sort[0], $sort[1])->paginate(5);
        }
        return $types;
    }
}

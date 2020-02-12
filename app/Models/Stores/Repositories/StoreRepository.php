<?php

namespace App\Models\Stores\Repositories;

use App\Models\Base\BaseRepository;
use App\Models\Stores\Store;
use App\Models\Stores\Exceptions\StoreNotFoundErrorException;
use App\Models\Stores\Exceptions\CreateStoreErrorException;
use App\Models\Stores\Exceptions\UpdateStoreErrorException;
use App\Models\Stores\Exceptions\DeleteStoreErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class StoreRepository extends BaseRepository implements StoreRepositoryInterface
{
    /**
     * StoreRepository constructor.
     *
     * @param Store $store
     */
    public function __construct(Store $store)
    {
        parent::__construct($store);
        $this->model = $store;
    }

    /**
     * @param array $data
     *
     * @return Store
     * @throws CreateStoreErrorException
     */
    public function createStore(array $data): Store
    {
        try {

            if ($data["image"]) {

                $img = \Image::make($data["image"]);
                $save_path = public_path() . '/uploads/stores/';
                $filename = str_random(40) . '.jpeg';
                $filepath = $save_path . $filename;
                $url = '/uploads/stores/' . $filename;

                if (!file_exists($save_path)) {
                    mkdir($save_path, 666, true);
                }

                $img->save($filepath);
                $data["image"] = $url;
            } else {
                $data["image"] = "";
            }

            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateStoreErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Store
     * @throws StoreNotFoundErrorException
     */
    public function findStoreById(int $id): Store
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new StoreNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UpdateStoreErrorException
     */
    public function updateStore(array $data): bool
    {
        try {

            $tempImage  = $this->model->image;

            if ($data["image"]) {

                if ($data["image"] !=  $this->model->image) {
                    $img = \Image::make($data["image"]);
                    $save_path = public_path() . '/uploads/stores/';
                    $filename = str_random(40) . '.jpeg';
                    $filepath = $save_path . $filename;
                    $url = '/uploads/stores/' . $filename;

                    if (!file_exists($save_path)) {
                        mkdir($save_path, 666, true);
                    }

                    $img->save($filepath);
                    $data['image'] = $url;
                }

                \File::delete(public_path() . $tempImage);
            } else {

                $data['image'] = '';

                \File::delete(public_path() . $tempImage);
            }

            return $this->update($data);
        } catch (QueryException $e) {
            throw new UpdateStoreErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteStore(): bool
    {

        try {
            $tempImage = $this->model->image;
            $this->delete();
            return \File::delete(public_path() . $tempImage);
        } catch (QueryException $e) {
            throw new DeleteStoreErrorException($e);
        }
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listStores($columns = array('*'), string $orderBy = 'name', string $sortBy = 'asc'): Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function getAllStores(Request $request)
    {
        $r = $request;

        if (isset($r["sort"])) {
            $sort = explode("|", $r["sort"]);
        }

        if (isset($r["filter"])) {
            $stores = $this->model->where('name', 'like', '%' . $r["filter"] . '%')->orderBy($sort[0], $sort[1])->paginate(7);
        } else if (!isset($r["sort"])) {
            $stores = $this->model->paginate(7);
            return response()->json(compact('stores'));
        } else {
            //$stores = $this->model->orderBy($sort[0], $sort[1])->paginate(5);
            $stores = $this->model->orderBy($sort[0], $sort[1])->paginate(7);
        }
        return $stores;
    }
}

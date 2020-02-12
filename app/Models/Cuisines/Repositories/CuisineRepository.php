<?php

namespace App\Models\Cuisines\Repositories;

use App\Models\Base\BaseRepository;
use App\Models\Cuisines\Cuisine;
use App\Models\Cuisines\Exceptions\CuisineNotFoundErrorException;
use App\Models\Cuisines\Exceptions\CreateCuisineErrorException;
use App\Models\Cuisines\Exceptions\UpdateCuisineErrorException;
use App\Models\Cuisines\Exceptions\DeleteCuisineErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CuisineRepository extends BaseRepository implements CuisineRepositoryInterface
{
    /**
     * CuisineRepository constructor.
     *
     * @param Cuisine $cuisine
     */
    public function __construct(Cuisine $cuisine)
    {
        parent::__construct($cuisine);
        $this->model = $cuisine;
    }

    /**
     * @param array $data
     *
     * @return Cuisine
     * @throws CreateCuisineErrorException
     */
    public function createCuisine(array $data) : Cuisine
    {
        try {

          if ($data["image"]) {

             $img = \Image::make($data["image"]);
             $save_path = public_path().'/uploads/cuisines/';
             $filename = str_random(40).'.jpeg';
             $filepath = $save_path . $filename;
             $url = '/uploads/cuisines/'. $filename;

             if (!file_exists($save_path)) {
                mkdir($save_path, 666, true);
              }

             $img->save($filepath);
             $data["image"] = $url;

          }else{
             $data["image"] = "";
          }

          return $this->create($data);


        } catch (QueryException $e) {
            throw new CreateCuisineErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Cuisine
     * @throws CuisineNotFoundErrorException
     */
    public function findCuisineById(int $id) : Cuisine
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CuisineNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UpdateCuisineErrorException
     */
    public function updateCuisine(array $data) : bool
    {
        try {

          $tempImage  = $this->model->image ;

           if ($data["image"]) {

            if ($data["image"] !=  $this->model->image) {
              $img = \Image::make($data["image"]);
              $save_path = public_path().'/uploads/cuisines/';
              $filename = str_random(40).'.jpeg';
              $filepath = $save_path . $filename;
              $url = '/uploads/cuisines/'. $filename;

              if (!file_exists($save_path)) {
               mkdir($save_path, 666, true);
             }

              $img->save($filepath);
              $data['image'] = $url;
            }

            \File::delete(  public_path(). $tempImage);

          }else{

            $data['image'] = '';

            \File::delete(  public_path(). $tempImage);
          }

            return $this->update($data);
        } catch (QueryException $e) {
            throw new UpdateCuisineErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCuisine() : bool
    {

        try{
          $tempImage = $this->model->image;
          $this->delete();
          return \File::delete(  public_path(). $tempImage);
          
        } catch (QueryException $e) {
            throw new DeleteCuisineErrorException($e);
        }
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listCuisines($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function getAllCuisines(Request $request)
    {

       $r = $request;

       if (isset($r["sort"])){
            $sort = explode("|",$r["sort"]);
          }

          if (isset($r["filter"])) {
            $cuisines = $this->model->where('name', 'like', '%' . $r["filter"] . '%')->orderBy( $sort[0] ,$sort[1])->paginate(5);
          }else if(!isset($r["sort"])){
               $cuisines = $this->model->paginate(5);
               return response()->json(compact('cuisines'));
          }else{
            $cuisines = $this->model->orderBy( $sort[0] ,$sort[1])->paginate(5);
          }
      return $cuisines;
    }


}

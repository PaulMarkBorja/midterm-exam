<?php

namespace App\Models\Categories\Repositories;

use App\Models\Base\BaseRepository;
use App\Models\Categories\Category;
use App\Models\Categories\Exceptions\CategoryNotFoundErrorException;
use App\Models\Categories\Exceptions\CreateCategoryErrorException;
use App\Models\Categories\Exceptions\UpdateCategoryErrorException;
use App\Models\Categories\Exceptions\DeleteCategoryErrorException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->model = $category;
    }

    /**
     * @param array $data
     *
     * @return Category
     * @throws CreateCategoryErrorException
     */
    public function createCategory(array $data) : Category
    {
        try {

          if ($data["image"]) {


             $img = \Image::make($data["image"]);
             $save_path = public_path().'/uploads/categories/';
             $filename = str_random(40).'.jpeg';
             $filepath = $save_path . $filename;
             $url = '/uploads/categories/'. $filename;

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
            throw new CreateCategoryErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Category
     * @throws CategoryNotFoundErrorException
     */
    public function findCategoryById(int $id) : Category
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UpdateCategoryErrorException
     */
    public function updateCategory(array $data) : bool
    {
        try {



          $tempImage  = $this->model->image ;

           if ($data["image"]) {

            if ($data["image"] !=  $this->model->image) {
              $img = \Image::make($data["image"]);
              $save_path = public_path().'/uploads/categories/';
              $filename = str_random(40).'.jpeg';
              $filepath = $save_path . $filename;
              $url = '/uploads/categories/'. $filename;

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
            throw new UpdateCategoryErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteCategory() : bool
    {

        try{
          $tempImage = $this->model->image;
          $this->delete();
          return \File::delete(  public_path(). $tempImage);
          
        } catch (QueryException $e) {
            throw new DeleteCategoryErrorException($e);
        }
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listCategories($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    public function getCategories(): Collection
    {
      return $this->model->where('store_id', Auth::user()->store_id)->get();
    }

    public function getAllCategories(Request $request)
    {

       $r = $request;

       if (isset($r["sort"])){
            $sort = explode("|",$r["sort"]);
          }

          if (isset($r["filter"])) {
            $categories = $this->model->where('name', 'like', '%' . $r["filter"] . '%')->orderBy( $sort[0] ,$sort[1])->paginate(5);
          }else if(!isset($r["sort"])){
               $categories = $this->model->paginate(5);
               return response()->json(compact('categories'));
          }else{
            $categories = $this->model->where('store_id', Auth::user()->store_id)
            ->orderBy( $sort[0] ,$sort[1])->paginate(5);
          }
      return $categories;
    }


}

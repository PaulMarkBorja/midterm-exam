<?php

namespace App\Models\Products\Repositories;

use Illuminate\Http\Request;
use App\Models\Products\ProductOption;
use Image;

class ProductOptionRepository implements ProductOptionRepositoryInterface
{
  /**
   * @var $model
   */
  private $model;

  /**
   * EloquentCategory constructor.
   *
   * @param App\Models\ProductOption $model
   */
  public function __construct(ProductOption $model)
  {
    $this->model = $model;
  }



  /**
   * Get product option by id.
   *
   * @param integer $id
   *
   * @return App\Models\ProductOption
   */
  public function getById($id)
  {
    return $this->model->find($id);
  }

  /**
   * Create a new Product Option.
   *
   * @param array $request
   *
   * @return App\Models\ProductOption
   */
  public function create(array $request)
  {

    $input = $request;
    $this->model->create($input)->save();
    return response('success', 200)
      ->header('Content-Type', 'application/json');
  }

  /**
   * Update a Product Option
   *
   * @param integer $id
   * @param array $request
   *
   * @return App\Models\ProductOption
   */
  public function update($id, array $request)
  {

    $input = $request;
    $product_option = $this->model->find($id);
    $product_option->name = $input['name'];
    $product_option->description = $input['description'];
    $product_option->price = $input['price'];

    $product_option->save();
    return response('success', 200)
      ->header('Content-Type', 'application/json');
  }

  /**
   * Delete a Product Option.
   *
   * @param integer $id
   *
   * @return boolean
   */
  public function delete($id)
  {
    $product_option = $this->model->find($id);
    $product_option->delete();
    return response()->json('Success');
  }
}

<?php

namespace App\Models\Products\Repositories;

use Illuminate\Http\Request;
use App\Models\Products\Product;
use Illuminate\Support\Facades\Auth;
use Image;

class ProductRepository implements ProductRepositoryInterface
{
  /**
   * @var $model
   */
  private $model;

  /**
   * ProductRepository constructor.
   *
   * @param App\Models\Product $model
   */
  public function __construct(Product $model)
  {
    $this->model = $model;
  }

  /**
   * Get all product.
   *
   * @return Illuminate\Database\Eloquent\Collection
   */
  public function getAll($request)
  {

    $r = $request;

    if (isset($r["sort"])) {
      $sort = explode("|", $r["sort"]);
    }

    if (isset($r["filter"])) {
      $products = $this->model->where('name', 'like', '%' . $r["filter"] . '%')->orderBy($sort[0], $sort[1])->paginate(5);
    } else if (!isset($r["sort"])) {
      $products = $this->model->all();
      return response()->json(compact('products'));
    } else {
      $products = $this->model->where('store_id', Auth::user()->store_id)
      ->orderBy($sort[0], $sort[1])->paginate(5);
    }

    return $products;
  }

  /**
   * Get product by id.
   *
   * @param integer $id
   *
   * @return App\Models\Product
   */
  public function getById($id)
  {
    return $this->model->with('tags')->find($id);
  }

  /**
   * Create a new Product.
   *
   * @param array $request
   *
   * @return App\Models\Product
   */
  public function create(array $request)
  {

    \DB::transaction(function () use ($request) {

      $input = $request;


      if ($input["image"]) {


        $img = Image::make($input["image"]);
        $save_path = public_path() . '/uploads/products/';
        $filename = str_random(40) . '.jpeg';
        $filepath = $save_path . $filename;
        $url = '/uploads/products/' . $filename;

        if (!file_exists($save_path)) {
          mkdir($save_path, 666, true);
        }

        $img->save($filepath);
        $input["image"] = $url;
      } else {
        $input["image"] = "";
      }


      $product = Product::create($input);
      $id = array();
      //if ($request->has('tags')) {
        foreach ($input['tags'] as $tag) {
          if (in_array('new', $tag)) {
            $tag_id = \DB::table('tags')->insertGetId([
              "name" => $tag['name']
            ]);
            array_push($id, $tag_id);
          } else {
            array_push($id, $tag['id']);
          }
        }
        $product->tags()->attach($id);
      //}
      // \DB::table('products')->insertGetId([
      //   "name" => $input['name'],
      //   "description" => $input['description'],
      //   "image" => $input['image'],
      //   "category_id" => $input['category_id'],
      //   "store_id" => $input['store_id'],
      //   "preparation_time" => $input['preparation_time'],
      //   "price" => $input['price'],

      // ]);

      
      // foreach ($input['product_options'] as $product_option) {

      //   \DB::table('product_options')->insert([
      //     "product_id" => $product_id,
      //     "name" => $product_option['name'],
      //     "description" => $product_option['description'],
      //     "price" => $product_option['price'],
      //   ]);
      // }
    });



    return response('success', 200)
      ->header('Content-Type', 'application/json');
  }

  /**
   * Update a Product.
   *
   * @param integer $id
   * @param array $request
   *
   * @return App\Models\Product
   */
  public function update($id, array $request)
  {

    \DB::transaction(function () use ($request, $id) {

      $input = $request;

      $product = $this->model->with('tags')->find($id);
      $tempImage =   $product->image;

      if ($input["image"]) {

        if ($input["image"] != $product->image) {
          $img = Image::make($input["image"]);
          $save_path = public_path() . '/uploads/products/';
          $filename = str_random(40) . '.jpeg';
          $filepath = $save_path . $filename;
          $url = '/uploads/products/' . $filename;

          if (!file_exists($save_path)) {
            mkdir($save_path, 666, true);
          }

          $img->save($filepath);
          $product->image = $url;
        }

        $product->save();
        \File::delete(public_path() . $tempImage);
      } else {

        $product->image = '';
        $product->save();
        \File::delete(public_path() . $tempImage);
      }

      $product->name = $input['name'];
      $product->description = $input['description'];
      $product->category_id = $input['category_id'];
      $product->preparation_time = $input['preparation_time'];
      $product->available = $input['available'];
      $product->price = $input['price'];

      $product->save();

      $product->tags()->detach();

      $id = array();
      foreach ($input['tags'] as $tag) {
        if (in_array('new', $tag)) {
          $tag_id = \DB::table('tags')->insertGetId([
            "name" => $tag['name']
          ]);
          array_push($id, $tag_id);
        } else {
          array_push($id, $tag['id']);
        }
      }
      $product->tags()->attach($id);

      // foreach ($input['product_options'] as $product_options) {

      //   \DB::table('product_options')
      //     ->where('id', $product_options['id'])
      //     ->update([
      //       "name" => $product_options['name'],
      //       "description" => $product_options['description'],
      //       "price" => $product_options['price']
      //     ]);
      // }
      return response('success', 200)
        ->header('Content-Type', 'application/json');
    });
  }

  /**
   * Delete a Product.
   *
   * @param integer $id
   *
   * @return boolean
   */
  public function delete($id)
  {
    $product = $this->model->find($id);
    $product->delete();
    return response('success', 200)
      ->header('Content-Type', 'application/json');
  }
}
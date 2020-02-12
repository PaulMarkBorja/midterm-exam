<?php

namespace App\Models\Orders\Repositories;

use Illuminate\Http\Request;
use App\Models\Orders\Order;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrderRepository implements OrderRepositoryInterface
{
  /**
   * @var $model
   */
  private $model;

  /**
   * OrderRepository constructor.
   *
   * @param App\Models\Order $model
   */
  public function __construct(Order $model)
  {
    $this->model = $model;
  }

  /**
   * Get all order.
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
   * Get order by id.
   *
   * @param integer $id
   *
   * @return App\Models\Order
   */
  public function getById($id)
  {
    return $this->model->find($id);
  }

  /**
   * Create a new Order.
   *
   * @param array $request
   *
   * @return App\Models\Order
   */
  public function create(array $request)
  {
    \DB::transaction(function () use ($request) {

      $input = $request->all();

      $input['order_code'] = uniqid();

      if ($input['total_amount'] < 150)
        $input['total_amount'] = 150;

      $input['total_amount'] += 40;

      $date = Carbon::parse($input['order_date']);
      $time = Carbon::parse($input['order_time']);
      $datetime = Carbon::create($date->year, $date->month, $date->day, $time->hour, $time->minute, $time->second, 'Asia/Manila');
      $input['order_datetime'] = $datetime;

      $customer = Customer::where('user_id', Auth::id())->first();
      $input['customer_id'] = $customer->id;
      $message = "New order request from " . $customer->firstname . " " . $customer->lastname;

      $business = Business::where('id', $input['business_id'])->first();
      $input['pickupaddress'] = $business->business_address;

      $order = Order::create($input);

      foreach ($input['orders'] as $product) {
        \DB::table('order_product')->insertGetId([
          "order_id" => $order->id,
          "product_id" => $product['id'],
          "quantity" => $product['quantity']
        ]);
      }

      $user_id = BusinessUser::where('business_id', $input['business_id'])->pluck('user_id');

      $user = User::where('id', $user_id)->first();

      $user->notify(new OrderRequest($order, $message));

      $notify = $user->unreadNotifications()->first();

      event(new OrderRequestEvent($message, $notify->id, $user));

      \DB::table('logs')->insertGetId([
        "order_id" => $order->id,
        "status" => 'pending',
        "created_at" => Carbon::now()
      ]);

      $address = AddressCustomer::where('address', $input['delivery_address'])->first();

      if (!($request->exists('platform'))) {
        if (!$address) {
          \DB::table('customer_address')->insertGetId([
            "address" => $input['delivery_address'],
            "lat" => $input['lat'],
            "lng" => $input['lng'],
            "customer_id" => $customer->id,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
          ]);
        } else {
          $address["updated_at"] = Carbon::now();
          $address->save();
        }
      } else {
        if (!$address) {
          \DB::table('customer_address')->insertGetId([
            "address" => $input['delivery_address'],
            "lat" => $input['lat'],
            "lng" => $input['lng'],
            "customer_id" => $input['customer_id'],
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now()
          ]);
        } else {
          $address["updated_at"] = Carbon::now();
          $address->save();
        }
      }
    });


    return response('success', 200)
      ->header('Content-Type', 'application/json');
  }

  /**
   * Update a Order.
   *
   * @param integer $id
   * @param array $request
   *
   * @return App\Models\Order
   */
  public function update($id, array $request)
  {

    \DB::transaction(function () use ($request, $id) {

      $input = $request;

      $product = $this->model->find($id);

      $product->name = $input['name'];
      $product->description = $input['description'];
      $product->category_id = $input['category_id'];
      $product->preparation_time = $input['preparation_time'];
      $product->available = $input['available'];
      $product->price = $input['price'];

      $product->save();

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
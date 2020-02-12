<?php

namespace App\Models\AddOn\Repositories;

use App\Models\AddOn\Exceptions\DeleteAddOnErrorException;
use Illuminate\Http\Request;
use App\Models\AddOn\AddOn;
use Illuminate\Support\Facades\Auth;
use Image;

class AddOnRepository implements AddOnRepositoryInterface
{
	/**
	 * @var $model
	 */
	private $model;

	/**
	 * EloquentCategory constructor.
	 *
	 * @param App\Models\AddOn $model
	 */
	public function __construct(AddOn $model)
	{
		$this->model = $model;
	}

	/**
	 * Get all add on.
	 *
	 * @return Illuminate\Database\Eloquent\Collection
	 */
	public function getAll($request)
	{

		 $r = $request;

		 if (isset($r["sort"])){
	        $sort = explode("|",$r["sort"]);
	      }

	      if (isset($r["filter"])) {
	        $add_ons = $this->model->where('name', 'like', '%' . $r["filter"] . '%')->orderBy( $sort[0] ,$sort[1])->paginate(5);
	      }else if(!isset($r["sort"])){
	           $add_ons = $this->model->all();
	           return response()->json(compact('add_ons'));
	      }else{
			$add_ons = $this->model->where('store_id', Auth::user()->store_id)
			->orderBy( $sort[0] ,$sort[1])->paginate(5);
	      }

		return $add_ons;
	}

	/**
	 * Get add on by id.
	 *
	 * @param integer $id
	 *
	 * @return App\Models\AddOn
	 */
	public function getById($id)
	{
		return $this->model->with('add_on_options')->find($id);
	}

	/**
	 * Create a new add on.
	 *
	 * @param array $request
	 *
	 * @return App\Models\AddOn
	 */
	public function create(array $request)
	{

		\DB::transaction(function() use ($request)
		{

			$input = $request;
			$add_on_id =  \DB::table('add_ons')->insertGetId([
						 "name" => $input['name'],
						 "description" => $input['description'],
						 "store_id" => $input['store_id']
					 ]);

			foreach ($input['add_on_options'] as $add_on_option) {

			   \DB::table('add_on_options')->insert([
								"add_on_id" => $add_on_id,
								"name" => $add_on_option['name'],
								"description" => $add_on_option['description'],
								"price" => $add_on_option['price'],
							]);

			}

		});

		return response('success', 200)
		                  ->header('Content-Type', 'application/json');


	}

	/**
	 * Update a Add On.
	 *
	 * @param integer $id
	 * @param array $request
	 *
	 * @return App\Models\AddOn
	 */
	public function update($id, array $request)
	{

			\DB::transaction(function() use ($request , $id)
			{

				$input = $request;

				$add_on = $this->model->find($id);

				$add_on->name = $input['name'];
				$add_on->description = $input['description'];
				$add_on->save();

				foreach ($input['add_on_options'] as $add_on_option) {

				   \DB::table('add_on_options')
					 			->where('id', $add_on_option['id'])
					 			->update([
									"name" => $add_on_option['name'],
									"description" => $add_on_option['description'],
									"price" => $add_on_option['price']
								]);

				}

			});

			return response('success', 200)
												->header('Content-Type', 'application/json');
	}

	/**
	 * Delete a AddOn.
	 *
	 * @param integer $id
	 *
	 * @return boolean
	 */
	public function delete($id)
	{
		try {
			$add_on = $this->model->find($id);
			$add_on->delete();
		} catch (QueryException $e) {
			throw new DeleteAddOnErrorException($e);
		}
	}

}
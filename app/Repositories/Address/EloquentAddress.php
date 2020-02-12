<?php

namespace App\Repositories\Address;

use Illuminate\Http\Request;
use App\Models\Address;
use Auth;


class EloquentAddress implements AddressRepository
{
	/**
	 * @var $model
	 */
	private $model;

	/**
	 * EloquentAddress constructor.
	 *
	 * @param App\Models\Address $model
	 */
	public function __construct(Address $model)
	{
		$this->model = $model;
	}

	/**
	 * Get all vehicles.
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

	        $address = Address::where('driver_id', $r['driver_id'])->where('street', 'like', '%' . $r["filter"] . '%')
	        			 ->orWhere('barangay', 'like', '%' . $r["filter"] . '%')
	        			 ->orderBy( $sort[0] ,$sort[1])
	        			 ->with('municipality', 'province')
	        			 ->paginate(5);

	      }else if(!isset($r["sort"])){

	           $address = Address::all();

	      }else{

	        $address = Address::where('driver_id', $r['driver_id'])->with('municipality', 'province')
	                  ->orderBy( $sort[0] ,$sort[1])
	                  ->paginate(5);
	        
	      }

	      return $address;
	}

	public function getById($id)
	{
		return $this->model->find($id);
	}

	public function create(array $request)
	{

      	$input = $request;
        Address::create($input);
        return response()->json('Success');

	}

	public function update($id, array $request)
	{	
		$input = $request;
        $address = $this->model->find($id);
        $address->update($input);
        return response()->json("Success");
	}

	public function delete($id)
	{
		$address = $this->model->find($id);
        $address->delete();
        return response()->json('Success');
	}
}
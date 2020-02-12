<?php

namespace App\Repositories\Driver;

use Illuminate\Http\Request;
use App\Models\DriverEmergencyContact;

class EloquentDriverEmergencyContact implements DriverEmergencyContactRepository
{
	public function __construct(DriverEmergencyContact $model)
	{
		$this->model = $model;
	}

	public function getAll($request)
	{	

		 $r = $request;

		 if (isset($r["sort"])){
	        $sort = explode("|",$r["sort"]);
	      }
	       
	      if (isset($r["driver_id"])) {
	        $emergencycontacts = $this->model->where('driver_id', $r["driver_id"])->orderBy( $sort[0] ,$sort[1])->paginate(5);
	      }else if(!isset($r["sort"])){
	           $emergencycontacts = $this->model->all();
	      }else{
	        $emergencycontacts = $this->model->orderBy( $sort[0] ,$sort[1])->paginate(5);
	      }

		return $emergencycontacts;
	}

	public function getById($id)
	{
		return $this->model->find($id);
	}

	public function create(array $request)
	{

      $input = $request;

      $this->model->create($input)->save();

      return response()->json('Success');

	}

	public function update($id, array $request)
	{	

		$input = $request;
		$emergencycontact = $this->model->find($id);

      	$emergencycontact->update($input);
      	return response()->json('Success');
	}

	public function delete($id)
	{
		$emergencycontact = $this->model->find($id);
        $emergencycontact->delete();
        return response()->json('Success');
	}
}
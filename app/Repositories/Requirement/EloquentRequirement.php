<?php

namespace App\Repositories\Requirement;

use Illuminate\Http\Request;
use App\Models\Requirement;
use Auth;


class EloquentRequirement implements RequirementRepository
{
	/**
	 * @var $model
	 */
	private $model;

	/**
	 * EloquentRequirement constructor.
	 *
	 * @param App\Models\Requirement $model
	 */
	public function __construct(Requirement $model)
	{
		$this->model = $model;
	}

	/**
	 * Get all Requirements.
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

	        $requirements = Requirement::where('name', 'like', '%' . $r["filter"] . '%')
	        			 ->orderBy( $sort[0] ,$sort[1])
	        			 ->paginate(5);

	      }else if(!isset($r["sort"])){

	           $requirements = Requirement::where('indicator', 0)->get();

	      }else{

	        $requirements = Requirement::where('indicator', 0)->orderBy( $sort[0] ,$sort[1])->paginate(5);
	        
	      }

	      return $requirements;
	}

	/**
	 * Get Requirement by id.
	 *
	 * @param integer $id
	 *
	 * @return App\Models\Requirement
	 */
	public function getById($id)
	{
		return $this->model->find($id);
	}

	/**
	 * Create a new Requirement.
	 *
	 * @param array $request
	 *
	 * @return App\Models\Requirement
	 */
	public function create(array $request)
	{

      	$input = $request;
        Requirement::create($input);
        return response()->json('Success');

	}

	/**
	 * Update a Requirement.
	 *
	 * @param integer $id
	 * @param array $request
	 *
	 * @return App\Models\Requirement
	 */
	public function update($id, array $request)
	{	
		$input = $request;
        $requirement = $this->model->find($id);
        $requirement->update($input);
        return response()->json("Success");
	}

	/**
	 * Delete a Requirement.
	 *
	 * @param integer $id
	 *
	 * @return boolean
	 */
	public function delete($id)
	{
		$requirement = $this->model->find($id);
        $requirement->delete();
        return response()->json('Success');
	}

	public function getDriverRequirements(){
		$requirements = Requirement::where('indicator', 1)->paginate(5);

		return $requirements;
	}
}
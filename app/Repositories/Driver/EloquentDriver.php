<?php

namespace App\Repositories\Driver;

use Auth;
use Illuminate\Http\Request;
use App\Models\Drivers\Driver;
use App\Models\User;
use App\Models\Customers\Customer;
use Carbon\Carbon;

class EloquentDriver implements DriverRepository
{
	/**
	 * @var $model
	 */
	private $model;

	/**
	 * EloquentDriver constructor.
	 *
	 * @param App\Models\Driver $model
	 */
	public function __construct(Driver $model)
	{
		$this->model = $model;
	}

	/**
	 * Get all drivers.
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

	        $drivers = Driver::where('driver_code', 'like', '%' . $r["filter"] . '%')
	        			 ->orderBy( $sort[0] ,$sort[1])
	        			 ->paginate(5);

	      }else if(!isset($r["sort"])){

	           $drivers = Driver::all();

	      }else{

			// $drivers = Driver::with('user')->orderBy( $sort[0] ,$sort[1])
			//           ->paginate(5);
			$drivers = Driver::orderBy($sort[0], $sort[1])
				->paginate(5);
	        
	      }

	      return $drivers;
	}

	public function getById($id)
	{
		return $this->model->with(['user', 'address.municipality', 'address.province'])->find($id);
	}

	/**
	 * Create a new driver.
	 *
	 * @param array $request
	 *
	 * @return App\Models\Driver
	 */
	public function create(array $request)
	{

      	\DB::transaction(function() use ($request){
      		$input = $request;

      		$input['password'] = bcrypt('12345678');
        	$input['name'] = $input['first_name'] . ' ' . $input['last_name'];
        	$input['number'] = $input['mobile_number'];
        	$input['firstname'] = $input['first_name'];
        	$input['lastname'] = $input['last_name'];

        	$user = User::create($input);
        	$user->level = 3;
        	$user->verified = 1;
            $user->save();

            $user->assignRole(['Driver']);

            $input['user_id'] = $user->id;
      		$input['driver_code'] = "D-". Carbon::now()->year . "-" .str_random(10);
      		//$requirements = $request['requirements'];
      		$driver = $this->model->create($input);
			$driver->save();
        	//Customer::create($input);

			//$driver->requirements()->attach($requirements);

			// \DB::table('driver_locations')->insertGetId([
      		// 	"lat" => 0,
      		// 	"long" => 0,
      		// 	"driver_id" => $driver->id
      		// ]);

      		// \DB::table('driver_player_i_ds')->insertGetId([
      		// 	"player_id" => " ",
      		// 	"user_id" => $user->id
      		// ]);

      		\DB::table('addresses')->insertGetId([
      			"street" => $input['street'],
      			"barangay" => $input['barangay'],
      			"zip_code" => $input['zip_code'],
      			"municipality_id" => $input['municipality_id'],
      			"province_id" => $input['province_id'],
      			"driver_id" => $driver->id
      		]);

      		// foreach($input['emergencycontact'] as $data){
      		// 	\DB::table('driver_emergency_contacts')->insertGetId([
      		// 		"name" => $data['name'],
      		// 		"address" => $data['address'],
      		// 		"contact_number" => $data['contact_number'],
      		// 		"driver_id" => $driver->id
      		// 	]);
      		// }

      		// foreach($input['driver_images'] as $data){
      		// 	if(!empty($data['images'])){
	      	// 		foreach ($data['images'] as $value) {
	      	// 			$image = \DB::table('images')->insertGetId([
			// 		      			"image" => $value['image']
			// 		      		]);

	      	// 			\DB::table('driver_images')->insertGetId([
			//       			"driver_id" => $driver->id,
			//       			"image_id" => $image,
			//       			"requirement_id" => $data['requirement_id']
			//       		]);
	      	// 		}
	      	// 	}
      		// }

      		// $driver->restaurants()->attach($input['restaurant']);

      		return response()->json('Success');
      	});
	}

	/**
	 * Update a driver.
	 *
	 * @param integer $id
	 * @param array $request
	 *
	 * @return App\Models\Driver
	 */
	public function update($id, array $request)
	{	
		$input = $request;
        $driver = $this->model->find($id);

        $tempImage = $driver->image;
        if ($driver->image !== $input["image"]) {
            $img = Image::make($input["image"]);
            $save_path = public_path().'/uploads/driver/';
            $filename = str_random(40).'.jpeg';
            $filepath = $save_path . $filename;
            $url = '/uploads/driver/'. $filename;

            if (!file_exists($save_path)) {
                mkdir($save_path, 666, true);
            }

            $img->save($filepath);
            $input["image"] = $url;

        }

        $driver->update($input);
        
        return response()->json("success");
	}

	/**
	 * Delete a driver.
	 *
	 * @param integer $id
	 *
	 * @return boolean
	 */
	public function delete($id)
	{
		$driver = $this->model->find($id);
        $driver->delete();
        return response()->json('Success');
	}
}
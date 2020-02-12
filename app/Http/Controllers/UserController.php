<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Traits\Authorizable;
use Carbon\Carbon;

class UserController extends Controller
{

    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $r = $request;

     		if (isset($r["sort"])){
     	    $sort = explode("|", $r["sort"]);
     	  }

     	  if (isset($r["filter"])) {
       	  $users = User::where('name', 'like', '%' . $r["filter"] . '%')
                         ->orWhere('email', 'like', '%' . $r["filter"] . '%')
                         ->orWhereHas('roles', function($q) use ($r){
                              $q->where('name', 'LIKE', '%' . $r['filter'] . '%');
                          })
                         ->orderBy( $sort[0] ,$sort[1])->paginate(5);
     	  }
        // else if(!isset($r["sort"])){
     	  //   $users = User::all()->paginate(5);
     	  //   return response()->json(compact('users'));
     	  // }
        else{
          if(Auth::user()->roles[0]->name == 'SuperAdmin')
            $users = User::orderBy($sort[0], $sort[1])->paginate(5);
            else
            {
               $users = User::where('store_id', Auth::user()->store_id)
                ->orderBy( $sort[0] ,$sort[1])->paginate(5);
            }
     	  }

     		return $users;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request['roles'])
        {
            $this->validate($request, [
              'name' => 'bail|required|min:2',
              'password' => 'required|min:6',
              'roles' => 'required|min:1',
          ]);
        }
        else
        {
          $this->validate($request, [
            'name' => 'bail|required|min:2',
            'password' => 'required|min:6',
          ]);
        }

        // hash password
        $request->merge(['password' => bcrypt($request->get('password'))]);

        // Create the user
        if ( $user = User::create($request->except('roles', 'permissions')) ) {

            $this->syncPermissions($request, $user);

            return response('Success | User has been created.', 200)
      			                  ->header('Content-Type', 'application/json');
        } else {
            return response('Error | Unable to create user.', 500)
                              ->header('Content-Type', 'application/json');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $user['pass'] = '';
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        if($request['pass'])
        {
          $request['password'] = $request['pass'];

          $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'min:6',
            'roles' => 'required|min:1',
          ]);
        }
        else {
          $this->validate($request, [
            'name' => 'bail|required|min:2',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required|min:1',
          ]);
        }

        // Get the user
        $user = User::findOrFail($id);

        // Update user
        $user->fill($request->except('roles', 'permissions', 'password'));

        // check for password change
        if($request->get('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        // Handle the user roles
        $this->syncPermissions($request, $user);

        $user->save();

        return response('Success | User has been updated.', 200)
                          ->header('Content-Type', 'application/json');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     * @internal param Request $request
     */
    public function destroy($id)
    {
        if ( Auth::user()->id == $id ) {
          $error = ['fail' => 'You are not allowed to delete your account'];
          return $error;
        }
        $user = User::findOrFail($id);
        $user->driver()->delete();
        if( $user->delete() ) {
          return response('Success | User has been deleted.', 200)
                            ->header('Content-Type', 'application/json');
        } else {
          return response('Error | Failed in deleting the user.', 500)
                            ->header('Content-Type', 'application/json');
        }
    }

    /**
     * Sync roles and permissions
     *
     * @param Request $request
     * @param $user
     * @return string
     */
    private function syncPermissions(Request $request, $user)
    {
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if( ! $user->hasAllRoles( $roles ) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);


        return $user;
    }

    // public function activate($id){

    //      $user = User::findOrFail($id);
    //      $user->isactivated = '0';

    //      $user->save();

    //     // if( User::findOrFail($id)->delete() ) {
    //     //     flash()->success('User has been deleted');
    //     // } else {
    //     //     flash()->success('User not deleted');
    //     // }

    //     return redirect()->back();
    // }

    //  public function deactivateUser($id){

    //      if ( Auth::user()->id == $id ) {
    //         flash()->warning('Deactivation of currently logged in user is not allowed :(')->important();
    //         return redirect()->back();
    //     }

    //      $user = User::findOrFail($id);
    //      $user->isactivated = '0';

    //      $user->save();

    //      return redirect()->route('users.index');
    // }
}

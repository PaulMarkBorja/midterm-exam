<?php

namespace App\Http\Controllers;

use App\Models\Traits\Authorizable;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use Authorizable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $roles = Role::all();

        return $roles;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:roles']);

        if( Role::create($request->only('name')) ) {
          return response('Success | Role Added', 200)
                            ->header('Content-Type', 'application/json');
        }
        else {
          return response('Error | Failed in adding role', 500)
                            ->header('Content-Type', 'application/json');
        }
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
        if($role = Role::findOrFail($id)) {
            // admin role has everything
            if($role->name === 'SuperAdmin') {
                $role->syncPermissions(Permission::all());
            }

            $permissions = $request['rolePermissions'];

            sort($permissions);
            $role->syncPermissions($permissions);

            $message = ['role' => $role->name];
            return $message;
        } else {
            $message = ['id' => $id];
            return $message;
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPermissions()
    {
        $permissions = Permission::all();

        return $permissions;
    }

    public function checkRolePermission()
    {

      $roles = Role::all();

      $roleHasPermission = [];
      foreach ($roles as $role) {
          // $permission = Role::findByName($role->name)->permissions;
          // array_push($roleHasPermission, $permission);
          $query = \DB::table('role_has_permissions')->where('role_id', $role->id)->get()->pluck('permission_id');
          array_push($roleHasPermission, $query);
}
      return $roleHasPermission;
    }
}

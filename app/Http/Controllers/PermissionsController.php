<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Permission;
use App\PermissionRole;

class PermissionsController extends Controller
{

    public function allPermissions()
    {
        $permission = Permission::all();
        if ($permission) {
            $data['status'] = true;
            $data['permissions'] = $permission;
            return response()->json($data,200);
        }else{
            $data['status'] = true;
            $data['message'] = 'no permissions for now';
            return response()->json($data,200);
        }
    }
    public function allPermissionsFor($id)
    {
        $permission = Permission::all();
        if ($permission) {
            $rolePermissionsIdswithobject = PermissionRole::select('permission_id')->where('role_id',$id)->get();
            $rolePermissionsIds = [];
            foreach ($rolePermissionsIdswithobject as $perm_id) {
                $rolePermissionsIds[]=$perm_id->permission_id;
            }
            foreach ($permission as $perm) {
                $perm->can = (in_array($perm->id,array_values($rolePermissionsIds)))?true:false;
            }
            $data['status'] = true;
            $data['permissions'] = $permission;
            return response()->json($data,200);
        }else{
            $data['status'] = true;
            $data['message'] = 'no permissions for now';
            return response()->json($data,200);
        }
    }
    public function addPermissionsRole(Request $request)
    {
        if ($request->roles && $request->id) {
            // delete old permission
            PermissionRole::where('role_id',$request->id)->delete();
            // sync new permission
            $role = Role::find($request->id);
            $role->perms()->sync($request->roles);
            $data['status'] = true;
            $data['permissions'] = Role::find($request->id)->permissionrole()->with('permission')->get();
            return response()->json($data,200);
        }else{
            $data['status'] = FALSE;
            $data['message'] = 'bad parameters check the DOCX file';
            return response()->json($data,400);
        }
    }
    public function getRolePermissions($id)
    {
        $role = Role::find($id)->permissionrole()->with('permission')->get();
        if ($role) {
            $data['status']  = true ;
            $data['role'] = $role;
            return response()->json($data,200);
        }else{
            $data['status'] = false;
            $data['mesasage'] = 'record not found';
            return response()->json($data,400);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {
         //
     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    

       /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return \Illuminate\Http\Response
        */
       public function destroy($id)
       {
           //
       }

}

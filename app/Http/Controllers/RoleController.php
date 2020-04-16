<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;


class RoleController extends Controller
{
    public function getRoles()
    {
        $roles = Role::all();
        $data['status'] = true;
        $data['roles'] = $roles;
        return response()->json($data , 200);
    }
    public function getRole($id)
     {
       $role = Role::find($id)->first();
       if ($role) {
         $data['status'] = true;
         $data['role'] = $role;
         return response()->json($data , 200);
       }else{
        $data['status'] = false;
        $data['message'] = 'record not found';
         return response()->json($data , 400);
       }
     }
    public function addRole(Request $request)
    {
        if ($request->name) {
            if (Role::where('name',$request->name)->first()) {
                $data['status'] = false;
                $data['message'] = 'Role name mast be unique';
                return response()->json($data,400);
            }
            $role = new Role();
            $role->name         = $request->name;
            $role->display_name = $request->display_name; // optional
            $role->description = $request->description; // optional
            $role->delete  = "0"; // optional
            $role->save();
            $data['status'] =  True;
            $data['role']  = $role;
            return response()->json($data,201);
        }else{
            $data['status'] =  false;
            $data['message']  = 'bad parameter please chech the docx file';
            return response()->json($data,400);
        }

    }

    public function editRole(Request $request)
    {
        if ($request->name&&$request->id) {
            $role = Role::where(['id'=>$request->id,'delete'=>"0"])->first();
            if (!$role) {
                $data['status']  = false;
                $data['message'] = 'record not found';
                return response()->json($data,400);
            }
            $datatostore['name']         = $request->name;
            $datatostore['display_name'] = $request->display_name; // optional
            $datatostore['description']  = $request->description; // optional
            $update_status = Role::where('id',$request->id)->update($datatostore);
            if ($update_status) {
                $data['status'] =  True;
                $data['role']  = Role::where(['id'=>$request->id,'delete'=>"0"])->first();
                return response()->json($data,200);
            }else{
                $data['status'] =  false;

            $data['message']  = 'bad parameter please chech the docx file';
                return response()->json($data,400);
            }
        }else{
            $data['status'] =  false;
            $data['message']  = 'bad parameter please chech the docx file';
            return response()->json($data,400);
        }

    }
    public function deleteRole($id)
    {
        $role = Role::where(['id'=>$id,'delete'=>"0"])->first();
        if ($role) {
            $role = Role::find($id)->update(['delete'=>"1"]); // Pull back a given role
            $data['status'] = true;
            $data['message'] = 'Record deleted succefully';
            return response()->json($data , 200);
        }else{
            $data['status'] = false;
            $data['message'] = 'record not found';
            return response()->json($data , 400);
        }
    }
    public function getBackRole($id)
    {
        $role = Role::where(['id'=>$id,'delete'=>"1"])->first();
        if ($role) {
            $role = Role::find($id)->update(['delete'=>"0"]); // Pull back a given role
            $data['status'] = true;
            $data['message'] = 'Record Backed with success';
            return response()->json($data , 200);
        }else{
            $data['status'] = false;
            $data['message'] = 'record not found';
            return response()->json($data , 400);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // silance is golden
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

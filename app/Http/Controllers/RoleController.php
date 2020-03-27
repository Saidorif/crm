<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;
use Validator;

class RoleController extends Controller
{
    
    public function index()
    {
        $roles = Role::paginate(12);
        return response()->json(['success' => true, 'result' => $roles]);
    }

    public function list()
    {
        $roles = Role::all();
        return response()->json(['success' => true, 'result' => $roles]);
    }


    public function edit(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json(['error' => true, 'message' => 'Role not found']);
        }
        return response()->json(['succcess' => true, 'result' => $role]);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'label' => 'required|string',
            'name' => 'required|string|unique:roles,name',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $inputs = $request->all();
        $role = Role::create($inputs);
        return response()->json(['success' => true, 'message' => 'Role created']);
    }


    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json(['error' => true, 'message' => 'Role not found']);
        }
        $validator = Validator::make($request->all(),[
            'label' => 'required',
            'name' => 'required|string|unique:roles,name,'.$role->id
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $inputs = $request->all();
        $role->update($inputs);
        return response()->json(['success' => true, 'message' => 'Role updated']);
    }

    public function destroy(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role){
            return response()->json(['error' => true, 'message' => 'Role not found']);
        }

        $role->delete();
        return response()->json(['success' => true, 'message' => 'Role deleted']);
    }
}

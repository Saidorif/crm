<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Image;
use App\User;

class EmployeeController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', '!=', 1)->paginate(12);
        return response()->json(['success' => true, 'result' => $users]);
    }

    public function list()
    {
        $users = User::where('role_id', '!=', 1)->get();
        return response()->json(['success' => true, 'result' => $users]);
    }

    public function checkemail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
        ]);
        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        return response()->json(['success' => true, 'message' => 'Email is free to use']);
    }

    public function edit($id)
    {
        $user = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        if(!$user){
            return response()->json(['error' => true, 'message' => 'User not found']);
        }
        return response()->json(['success' => true, 'result' => $user]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'email'             => 'required|email|unique:users,email,'.$user->id,
            'password'          => 'required|string|min:6',
            'confirm_password'  => 'required|string|min:6',
            'role_id'   => 'required|integer',
            'phone'     => 'string|nullable',
            'image'     => 'nullable',
            'file'      => 'nullable',
            'address'   => 'string|nullable',
            'text'      => 'string|nullable',
            'role_id'           => 'required|integer',
            'phone'             => 'string|nullable',
            'image'             => 'string|nullable',
            'file'              => 'string|nullable',
            'address'           => 'string|nullable',
            'text'              => 'string|nullable',
            'category_id'       => 'integer|nullable',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($inputs['password'] !== $inputs['confirm_password']){
            return response()->json(['error' => true,'message' => 'Passwords are not same']);
        }
        $inputs['password'] = Hash::make($inputs['password']);
        //Upload file and image
        if($request->image){
            $strpos = strpos($request->image,';');
            $sub = substr($request->image, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $img_name = time().".".$ex;

            $img = Image::make($request->image);
            $img_path = public_path()."/users/";
            $img->save($img_path.$img_name);
            $inputs['image'] = $img_name;
        }
        if($request->file){
            $strpos = strpos($request->file,';');
            $sub = substr($request->file, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $img_name = time().".".$ex;

            $img = Image::make($request->file);
            $img_path = public_path()."/users/";
            $img->save($img_path.$img_name);
            $inputs['file'] = $img_name;
        }

        $employee = User::create($inputs);
        return response()->json(['success' => true, 'message' => 'Employee created successfuly']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $employee = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        if(!$employee){
            return response()->json(['error' => true, 'message' => 'Employee not found']);
        }
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'email'             => 'required|email|unique:users,email,'.$employee->id,
            'password'          => 'nullable|string|min:6',
            'confirm_password'  => 'nullable|string|min:6',
            'role_id'           => 'required|integer',
            'phone'             => 'string|nullable',
            'image'             => 'string|nullable',
            'file'              => 'string|nullable',
            'address'           => 'string|nullable',
            'text'              => 'string|nullable',
            'category_id'       => 'integer|nullable',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($request->has('password') && $request->has('confirm_password')){
            if($inputs['password'] != '' || strlen($inputs['password']) >= 6){
                if($inputs['password'] !== $inputs['confirm_password']){
                    return response()->json(['error' => true,'message' => 'Passwords are not same']);
                }
                $inputs['password'] = Hash::make($inputs['password']);
            }else{
                unset($inputs['password']);
            }
        }else{
            unset($inputs['password']);
        }
        //Upload file and image
        if($request->hasFile('image')){
            $strpos = strpos($request->image,';');
            $sub = substr($request->image, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $img_name = time().".".$ex;

            $img = Image::make($request->image);
            $img_path = public_path()."/users/";
            $img->save($img_path.$img_name);
            $inputs['image'] = $img_name;
        }
        if($request->hasFile('file')){
            $strpos = strpos($request->file,';');
            $sub = substr($request->file, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $img_name = time().".".$ex;

            $img = Image::make($request->file);
            $img_path = public_path()."/users/";
            $img->save($img_path.$img_name);
            $inputs['file'] = $img_name;
        }

        $employee->update($inputs);
        return response()->json(['success' => true, 'message' => 'Employee updated successfuly']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $employee = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        if(!$employee){
            return response()->json(['error' => true, 'message' => 'Employee not found']);
        }
        $employee->delete();
        return response()->json(['error' => true, 'message' => 'Employee deleted']);
    }
}

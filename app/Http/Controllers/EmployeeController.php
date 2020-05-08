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
        // $users = User::with('role')->where('role_id', '!=', 1)->paginate(12);
        $users = User::with(['role','position'])->paginate(12);
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
        // $user = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        $user = User::with(['role','position'])->find($id);
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
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|string|min:6',
            'confirm_password'  => 'required|string|min:6',
            'role_id'           => 'required|integer',
            'position_id'       => 'required|integer',
            'phone'             => 'string|nullable',
            'image'             => 'nullable',
            'file'              => 'nullable',
            'address'           => 'string|nullable',
            'text'              => 'string|nullable',
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
            $img_name = time()."image.".$ex;

            $img = Image::make($request->image);
            $img_path = public_path()."/users/";
            $img->save($img_path.$img_name);
            $inputs['image'] = $img_name;
        }
        if($request->file){
            $strposfile = strpos($request->file,';');
            $subfile = substr($request->file, 0,$strposfile);
            $exfile = explode('/',$subfile)[1];
            $file_name = time()."file.".$exfile;

            $file = Image::make($request->file);
            $file_path = public_path()."/users/";
            $file->save($file_path.$file_name);
            $inputs['file'] = $file_name;
        }

        $employee = User::create($inputs);
        return response()->json(['success' => true, 'message' => 'Employee created successfuly']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        // $employee = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        $employee = User::findOrFail($id);
        if(!$employee){
            return response()->json(['error' => true, 'message' => 'Employee not found']);
        }
        $validator = Validator::make($request->all(), [
            'name'              => 'required|string',
            'email'             => 'required|email|unique:users,email,'.$employee->id,
            'password'          => 'nullable|string|min:6',
            'confirm_password'  => 'nullable|string|min:6',
            'role_id'           => 'required|integer',
            'position_id'       => 'required|integer',
            'phone'             => 'string|nullable',
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
        if ($request->image != $user->image) {
            $strpos = strpos($request->image,';');
            $sub = substr($request->image, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $name = time()."image.".$ex;
            $img = Image::make($request->image);
            $img_path = public_path()."/users/";
            $img->save($img_path.$name);
            $image = $img_path.$user->image;
            if (file_exists($image)) {
                @unlink($image);
            }
        }
        else{
            $name = $user->image;
        }

        if ($request->file != $user->file) {
            $strposFile = strpos($request->file,';');
            $subFile = substr($request->file, 0,$strposFile);
            $exFile = explode('/',$subFile)[1];
            $nameFile = time()."file.".$exFile;
            $imgFile = Image::make($request->file);
            $file_path = public_path()."/users/";
            $imgFile->save($file_path.$nameFile);
            $imageFile = $file_path.$user->file;
            if (file_exists($imageFile)) {
                @unlink($imageFile);
            }
        }
        else{
            $nameFile = $user->file;
        }
        $inputs['image'] = $name;
        $inputs['file'] = $nameFile;
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

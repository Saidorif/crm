<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Image;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $user = $request->user();
        return response()->json(['success' => true, 'result' => $user]);
    }

    public function changePasword(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'password'    => 'required|string|min:6',
            'confirm_password'    => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($inputs['password'] !== $inputs['confirm_password']){
            return response()->json(['error' => true, 'message' => 'Passwords are not same']);
        }

        $user->password = Hash::make($inputs['password']);
        $user->save();
        return response()->json(['success' => true, 'message' => 'Passwords changed successul']);
    }

    public function update(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'email'       => 'required|email|unique:users,email,'.$user->id,
            'role_id'     => 'required|integer',
            'phone'       => 'string|nullable',
            'image'       => 'file|nullable',
            'file'        => 'file|nullable',
            'address'     => 'string|nullable',
            'text'        => 'string|nullable',
            'category_id' => 'integer|nullable',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        //Upload file and image
        if($request->file('image')){
            if($request->file('image')->isValid()){
                $strpos = strpos($request->image,';');
                $sub = substr($request->image, 0,$strpos);
                $ex = explode('/',$sub)[1];
                $img_name = time().".".$ex;

                $img = Image::make($request->image);
                $img_path = public_path()."/users/";
                $img->save($img_path.$img_name);
                $inputs['image'] = $img_name;
            }
        }else{
            unset($inputs['image']);
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
        }else{
            unset($inputs['file']);
        }
        unset($inputs['password']);
        $user->update($inputs);
        return response()->json(['success' => true, 'result' => $user]);
    }
}

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

    public function update(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string',
            'email'       => 'required|email|unique:users,email,'.$user->id,
            'password'    => 'string|nullable|min:6',
            'role_id'     => 'required|integer',
            'phone'       => 'string|nullable',
            'image'       => 'string|nullable',
            'file'        => 'string|nullable',
            'address'     => 'string|nullable',
            'text'        => 'string|nullable',
            'category_id' => 'integer|nullable',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($request->has('password')){
            if($inputs['password'] != '' || strlen($inputs['password']) >= 6){
                $inputs['password'] = Hash::make($request->input('password'));
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
        $user->update($inputs);
        return response()->json(['success' => true, 'result' => $user]);
    }
}

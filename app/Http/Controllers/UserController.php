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
            'address'     => 'string|nullable',
            'text'        => 'string|nullable',
            'category_id' => 'integer|nullable',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
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
        unset($inputs['password']);
        $user->update($inputs);
        return response()->json(['success' => true, 'result' => $user]);
    }
}

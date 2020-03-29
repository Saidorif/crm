<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;

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
        $user->update($inputs);
        return response()->json(['success' => true, 'result' => $user]);
    }
}

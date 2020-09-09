<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Image;
use App\User;
use App\UserExperience;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // $users = User::with('role')->where('role_id', '!=', 1)->paginate(12);
        $builder = [];
        if (auth()->user()->role_id == 1) {
            $builder = User::query()->with(['role']);
        }else{
            $builder = User::query()->where('role_id', '!=', 1)->with(['role']);
        }
        $params = $request->all();
        if(count($params) > 0){
            if(!empty($params['name'])){
                $builder->where('name','LIKE','%'.$params['name'].'%');
            }
            $users = $builder->orderBy('id','DESC')->paginate(12);
        }else{
            $users = User::with(['role'])->orderBy('id','DESC')->paginate(12);
        }
        // $users = User::with(['role','position'])->paginate(12);
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
        return response()->json(['success' => true, 'message' => 'Электронная почта свободно для использования']);
    }

    public function edit($id)
    {
        // $user = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        $user = User::with(['role'])->find($id);
        if(!$user){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден']);
        }
        return response()->json(['success' => true, 'result' => $user]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'status'                    => ['required',Rule::in(['active', 'inactive']),],
            'name'                      => 'required|string',
            'email'                     => 'required|email|unique:users,email',
            'password'                  => 'required|string|min:6',
            'confirm_password'          => 'required|string|min:6',
            'role_id'                   => ['required',Rule::in([2, 3,4]),],
            'position'                  => 'required|string',
            'image'                     => 'string|nullable',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($inputs['password'] !== $inputs['confirm_password']){
            return response()->json(['error' => true,'message' => 'Пароли не совпадают']);
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

        $employee = User::create($inputs);

        return response()->json(['success' => true, 'message' => 'Пользователь создан успешно']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $validRoles = auth()->user()->role_id == 1 ? [1,2, 3,4] : [2, 3,4];
        // $employee = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        $employee = User::where(['id' => $id])->first();
        $employee = User::findOrFail($id);
        if(!$employee){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден']);
        }
        $validator = Validator::make($request->all(), [
            'status'                    => ['required',Rule::in(['active', 'inactive']),],
            'name'                      => 'required|string',
            'email'                     => 'required|email|unique:users,email,'.$employee->id,
            'password'                  => 'nullable|string|min:6',
            'confirm_password'          => 'nullable|string|min:6',
            'role_id'                   => ['required',Rule::in($validRoles),],
            'position'                  => 'required|string',
            'image'                     => 'string|nullable',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        if($request->has('password') && $request->has('confirm_password')){
            if($inputs['password'] != '' || strlen($inputs['password']) >= 6){
                if($inputs['password'] !== $inputs['confirm_password']){
                    return response()->json(['error' => true,'message' => 'Пароли не совпадают']);
                }
                $inputs['password'] = Hash::make($inputs['password']);
            }else{
                unset($inputs['password']);
            }
        }else{
            unset($inputs['password']);
        }
        // Upload file and image
        if ($request->image != $employee->image){
            $strpos = strpos($request->image,';');
            $sub = substr($request->image, 0,$strpos);
            $ex = explode('/',$sub)[1];
            $name = time()."image.".$ex;
            $img = Image::make($request->image);
            $img_path = public_path()."/users/";
            $img->save($img_path.$name);
            $image = $img_path.$employee->image;
            if (file_exists($image)){
                @unlink($image);
            }
        }
        else{
            $name = $employee->image;
        }
        $inputs['image'] = $name;
        $employee->update($inputs);
        return response()->json(['success' => true, 'message' => 'Пользователь успешно обновлен']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $employee = User::where('role_id', '!=', 1)->where(['id' => $id])->first();
        if(!$employee){
            return response()->json(['error' => true, 'message' => 'Пользователь не найден']);
        }

        $exps = $employee->experience;
        //Delete User
        $employee->delete();
        //Delete user experience
        foreach ($exps as $key => $value) {
            $value->delete();
        }
        return response()->json(['error' => true, 'message' => 'Пользователь удален']);
    }
}

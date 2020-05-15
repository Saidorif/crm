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
            $builder = User::query()->with(['role','position','category']);
        }else{
            $builder = User::query()->where('role_id', '!=', 1)->with(['role','position','category']);
        }
        $params = $request->all();
        if(count($params) > 0){
            if(!empty($params['name'])){
                $builder->where('name','LIKE','%'.$params['name'].'%');
            }
            if(!empty($params['position_id'])){
                $builder->where(['position_id' => $params['position_id']]);
            }
            if(!empty($params['category_id'])){
                $builder->where(['category_id' => $params['category_id']]);
            }
            $users = $builder->orderBy('id','DESC')->paginate(12);
        }else{
            $users = User::with(['role','position','category'])->orderBy('id','DESC')->paginate(12);
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
        $user = User::with(['role','position','experience'])->find($id);
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
            'role_id'                   => 'required|integer',
            'position_id'               => 'required|integer',
            'phone'                     => 'string|nullable',
            'birthday'                  => 'date|nullable',
            'image'                     => 'nullable',
            'file'                      => 'nullable',
            'address'                   => 'required|string|nullable',
            'text'                      => 'required|string|nullable',
            'role_id'                   => 'required|integer',
            'image'                     => 'string|nullable',
            'file'                      => 'string|nullable',
            'address'                   => 'string|nullable',
            'text'                      => 'string|nullable',
            'category_id'               => 'integer|nullable',
            'order_date'                => 'date|nullable',
            'leave_date'                => 'date|nullable',
            'working'                   => 'boolean|nullable',
            'experience'                => 'array|nullable',
            'experience.*.date_from'    => 'required|date|nullable',
            'experience.*.date_to'      => 'required|date|nullable',
            'experience.*.company'      => 'required|string|nullable',
            'experience.*.address'      => 'string|nullable',
            'experience.*.position'     => 'required|string|nullable',
            'experience.*.description'  => 'string|nullable',
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

        //Save user experience
        if(!empty($inputs['experience'])){
            foreach ($inputs['experience'] as $key => $item) {
                $item['user_id'] = $employee->id;
                $experience = UserExperience::create($item);
            }
        }

        return response()->json(['success' => true, 'message' => 'Пользователь создан успешно']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
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
            'role_id'                   => 'required|integer',
            'position_id'               => 'required|integer',
            'phone'                     => 'string|nullable',
            'address'                   => 'string|nullable',
            'text'                      => 'string|nullable',
            'category_id'               => 'integer|nullable',
            'order_date'                => 'date|nullable',
            'leave_date'                => 'date|nullable',
            'working'                   => 'boolean|nullable',
            'experience'                => 'array|nullable',
            'experience.*.date_from'    => 'required|date|nullable',
            'experience.*.date_to'      => 'required|date|nullable',
            'experience.*.company'      => 'required|string|nullable',
            'experience.*.address'      => 'string|nullable',
            'experience.*.position'     => 'required|string|nullable',
            'experience.*.description'  => 'string|nullable',
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

        if ($request->file != $employee->file) {
            $strposFile = strpos($request->file,';');
            $subFile = substr($request->file, 0,$strposFile);
            $exFile = explode('/',$subFile)[1];
            $nameFile = time()."file.".$exFile;
            $imgFile = Image::make($request->file);
            $file_path = public_path()."/users/";
            $imgFile->save($file_path.$nameFile);
            $imageFile = $file_path.$employee->file;
            if (file_exists($imageFile)) {
                @unlink($imageFile);
            }
        }
        else{
            $nameFile = $employee->file;
        }
        $inputs['image'] = $name;
        $inputs['file'] = $nameFile;
        $employee->update($inputs);

        //Update user experience
        if(!empty($inputs['experience'])){
            $exps = $employee->experience;
            foreach ($exps as $key => $value) {
                $value->delete();
            }
            foreach ($inputs['experience'] as $key => $item) {
                $item['user_id'] = $employee->id;
                $experience = UserExperience::create($item);
            }
        }

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

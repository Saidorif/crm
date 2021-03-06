<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TestCategory;
use Validator;

class TestCategoryController extends Controller
{
    public function index()
    {
        $categories = TestCategory::paginate(12);
        return response()->json(['success' => true,'result' => $categories]);
    }

    public function edit(Request $request, $id)
    {
        $category = TestCategory::find($id);
        if(!$category){
            return response()->json(['error' => true, 'message' => 'Категория не найдена']);
        }
        return response()->json(['success' => true, 'result' => $category]);
    }

    public function list()
    {
        $categories = TestCategory::all();
        return response()->json(['success' => true, 'result' => $categories]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => 'required|string',
            'status' => 'string|nullable',
            'qty' => 'string|required',
            'time' => 'string|required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $category = TestCategory::create($request->all());
        return response()->json(['success' => true,'result' => $category]);
    }

    public function update(Request $request,$id)
    {
        $category = TestCategory::find($id);
        if(!$category){
            return response()->json(['error' => true, 'message' => 'Категория не найдена']);
        }

        $validator = Validator::make($request->all(), [
            'name'   => 'required|string',
            'status' => 'string|nullable',
            'qty' => 'string|required',
            'time' => 'string|required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $category->update($request->all());
        return response()->json(['success' => true,'result' => $category]);
    }

    public function destroy(Request $request, $id)
    {
        $category = TestCategory::find($id);
        if(!$category){
            return response()->json(['error' => true, 'message' => 'Категория не найдена']);
        }

        $category->delete();
        return response()->json(['success' => true,'message' => 'Категория удалена']);
    }


}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Position;
use Validator;

class PositionController extends Controller
{
    public function index()
    {
        $result = Position::paginate(12);
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function list()
    {
        $result = Position::all();
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function edit($id)
    {
        $result = Position::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Должность не найдено']);
        }
        return response()->json(['success' => true, 'result' => $result]);
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result = Position::create($inputs);
        return response()->json(['success' => true, 'message' => 'Должность успешно создана']);
    }

    public function update(Request $request, $id)
    {
        $user = $request->user();
        $result = Position::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Должность не найдено']);
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string'
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();
        $result->update($inputs);
        return response()->json(['success' => true, 'message' => 'Должность успешно обновлено']);
    }

    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $result = Position::find($id);
        if(!$result){
            return response()->json(['error' => true, 'message' => 'Должность не найдено']);
        }
        $result->delete();
        return response()->json(['error' => true, 'message' => 'Должность удален']);
    }
}
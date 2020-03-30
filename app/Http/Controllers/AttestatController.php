<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Question;

class AttestatController extends Controller
{
    public function index(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'category_id' => 'required|integer',
    		'limit' => 'required|integer',
    	]);

    	if($validator->fails()){
    		return response()->json(['error' => true, 'message' => $validator->messages()]);
    	}
    	$inputs = $request->all();

    	$questions = Question::with('variantsWHA')->where(['category_id' => $inputs['category_id']])->get();
    	return response()->json(['success' => true, 'result' => $questions]);
    }



}

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

    	$questions = Question::with(['variants'])->where(['category_id' => $inputs['category_id']])->get();
    	foreach ($questions as $key => $value) {
    		$variants = $value->variants;
		    foreach ($variants as $key => $item) {
		    	unset($item['is_true']);
		    }
		    return $value;
    	}

		// $questions->getCollection()->transform(function ($value) {
		    
		// });
    	return response()->json(['success' => true, 'result' => $questions]);
    }



}

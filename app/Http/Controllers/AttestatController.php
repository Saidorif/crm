<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Question;
use App\Attestat;

class AttestatController extends Controller
{
    public function index(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'category_id' => 'required|integer',
    		'limit' => 'required|integer',
            'fio' => 'required|string',
            'user_id' => 'integer|nullable'
    	]);

    	if($validator->fails()){
    		return response()->json(['error' => true, 'message' => $validator->messages()]);
    	}
    	$inputs = $request->all();

    	$questions = Question::with(['variants'])->where(['category_id' => $inputs['category_id']])->limit($inputs['limit'])->get();
        if(count($questions) < $inputs['limit']){
            return response()->json(['error' => true, 'message' => 'Big limit...']);
        }
        $ex_time = 0;
    	foreach ($questions as $key => $value) {
    		$variants = $value->variants;
		    foreach ($variants as $key => $item) {
		    	unset($item['is_true']);
		    }
            $ex_time += $value->time;
    	}
        $start = date('Y-m-d H:m:s');
        $end = date("Y-m-d H:i:s", (strtotime(date($start)) + $ex_time));
        $inputs['started_at'] = $start;
        $inputs['ended_at'] = $end;
        $inputs['time'] = $ex_time;
        $attestat = Attestat::create($inputs);
    	return response()->json(['success' => true,'total_time'=> $ex_time,'start' => $start,'end' => $end, 'result' => $questions]);
    }



}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Question;
use App\Attestat;
use App\User;

class AttestatController extends Controller
{

    public function index()
    {
        $attestats = Attestat::with(['category'])->orderBy('id','DESC')->paginate(12);
        return response()->json(['success' => true, 'result' => $attestats]);
    }

    public function userindex()
    {
        $user = request()->user();
        $attestats = Attestat::where(['user_id' => $user->id])->with(['category'])->orderBy('id','DESC')->paginate(12);
        return response()->json(['success' => true, 'result' => $attestats]);
    }


    public function attestat(Request $request)
    {
    	$validator = Validator::make($request->all(),[
    		'category_id' => 'required|integer',
    		'limit' => 'required|integer',
            'fio' => 'string|nullable',
            'user_id' => 'integer|nullable',
            'type' => 'required|string',
    	]);

    	if($validator->fails()){
    		return response()->json(['error' => true, 'message' => $validator->messages()]);
    	}
    	$inputs = $request->all();
        $status = 'progress';
        if($inputs['type'] == 'employee'){
            $status = 'start';
        }
        if($inputs['type'] == 'guest'){
            $guestvalidator = Validator::make($request->all(),[
                'fio' => 'required|string',
            ]);

            if($guestvalidator->fails()){
                return response()->json(['error' => true, 'message' => $guestvalidator->messages()]);
            }
        }

    	$questions = Question::with(['variants'])->where(['category_id' => $inputs['category_id']])->limit($inputs['limit'])->get();
        if(count($questions) < $inputs['limit']){
            return response()->json(['error' => true, 'message' => 'Big limit...']);
        }
        $ex_time = 0;
        //Question ids
        $q_ids = [];
        $q_answers = [];
    	foreach ($questions as $key => $value) {
    		$variants = $value->variants;
		    foreach ($variants as $key => $item) {
		    	unset($item['is_true']);
		    }
            $ex_time += $value->time;
            $q_ids[] = $value->id; 
            $q_answers[] = $value->id; 
    	}
        $start = date('Y-m-d H:m:s');
        $end = date("Y-m-d H:i:s", (strtotime(date($start)) + $ex_time));
        $inputs['started_at'] = $start;
        $inputs['ended_at'] = $end;
        $inputs['time'] = $ex_time;
        $inputs['question_ids'] = json_encode($q_ids);
        $inputs['status'] = $status;
        
        if($status == 'start'){
            $employees = User::where(['category_id' => $inputs['category_id']])->get();
            foreach ($employees as $key => $employee) {
                $inputs['user_id'] = $employee->id;
                $inputs['fio'] = $employee->name;
                $attestat = Attestat::create($inputs);
            }
            return response()->json(['success' => true, 'message' => 'Tests created for '. count($employees) .' employees']);
        }
        if($status == 'progress'){
            $attestat = Attestat::create($inputs);
            return response()->json(['success' => true,'total_time'=> $ex_time,'start' => $start,'end' => $end, 'result' => $questions, 'attestat' => $attestat]);
        }
        return response()->json(['error' => true,'message' => 'Something went wrong...']);
    }

    public function complete(Request $request,$id)
    {
        $validator = Validator::make($request->all(),[
            'questions' => 'required|array',
            'questions.*.id' => 'required|integer',
            'questions.*.answer_id' => 'required|integer',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $attestat = Attestat::find($id);
        if(!$attestat){
            return response()->json(['error' => true, 'message' => 'Not found...']);
        }
        if($attestat->status == 'complete'){
            return response()->json(['error' => true, 'message' => 'Doucument is already completed ...']);
        }

        $inputs = $request->all();

        if(count($inputs['questions']) != $attestat->limit){
            return response()->json(['error' => true, 'message' => 'Something wrong with limit' ,'limit' => $attestat->limit]);
        }
        $true_answers = 0;
        $wrong_answers = 0;

        foreach ($inputs['questions'] as $key => $variant) {
            $the_variant = Question::find($variant['id']);
            if($the_variant->check($variant['answer_id'])){
                $true_answers++;
            }else{
                $wrong_answers++;
            }
        }
        $attestat->answer = json_encode($inputs['questions']);
        $attestat->true_answers = $true_answers;
        $attestat->wrong_answers = $wrong_answers;
        $attestat->status = 'complete';
        $attestat->save();
        // if(date('Y-m-d H:m:s') > $attestat->ended_at){
        //     return response()->json(['error' => true,'message' => 'Time over...']);
        // }
        
        return response()->json(['success' => true, 'wrong_answers' => $wrong_answers,'true_answers' => $true_answers, 'ended_at' => $attestat->ended_at,'the_time' => date('Y-m-d H:m:s')]);
    }

    public function show($id)
    {
        $attestat = Attestat::with(['category'])->find($id);
        if(!$attestat){
            return response()->json(['error' => true, 'message' => 'Not found...']);
        }
        if($attestat->status == 'start'){
            $result = [
                'attestat' => $attestat,
                'questions' => $attestat->getQuestions(),
            ];
            return response()->json(['success' => true, 'result' => $result]);
        }
        $result = [
            'attestat' => $attestat,
            'questions' => $attestat->questionsWithResult(),
        ];
        return response()->json(['success' => true, 'result' => $result]);
    }



}

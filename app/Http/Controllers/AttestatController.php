<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Question;
use App\Attestat;
use App\User;
use Carbon\Carbon;

class AttestatController extends Controller
{

    public function index(Request $request)
    {
        $builder = Attestat::query()->with(['category']);
        $params = $request->all();
        if(count($params) > 0){
            if(!empty($params['fio'])){
                $builder->where('fio','LIKE','%'.$params['fio'].'%');
            }
            if(!empty($params['status'])){
                $builder->where(['status' => $params['status']]);
            }
            if(!empty($params['category_id'])){
                $builder->where(['category_id' => $params['category_id']]);
            }
            $attestats = $builder->orderBy('id','DESC')->paginate(12);
        }else{
            $attestats = Attestat::with(['category'])->orderBy('id','DESC')->paginate(12);
        }

        return response()->json(['success' => true, 'result' => $attestats]);
    }

    public function userindex(Request $request)
    {
        $user = request()->user();

        $builder = Attestat::query()->where(['user_id' => $user->id])->with(['category']);
        $params = $request->all();
        if(count($params) > 0){
            if(!empty($params['date'])){
                $builder->whereBetween('created_at', [$params['date']." 00:00:00", $params['date']." 23:59:59"]);
            }
            if(!empty($params['status'])){
                $builder->where(['status' => $params['status']]);
            }
            $attestats = $builder->orderBy('id','DESC')->paginate(12);
        }else{
            $attestats = Attestat::with(['category'])->orderBy('id','DESC')->paginate(12);
        }

        // $attestats = Attestat::where(['user_id' => $user->id])->with(['category'])->orderBy('id','DESC')->paginate(12);
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
            return response()->json(['error' => true, 'message' => 'Большой лимит...']);
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
        //Set times for test exam
        $currentTime = Carbon::now();
        $startTime = $currentTime->toDateTimeString();
        $endTime = $currentTime->addSeconds($ex_time)->toDateTimeString();

        $inputs['started_at'] = $startTime;
        $inputs['ended_at'] = $endTime;
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
            return response()->json(['success' => true, 'message' => 'Тесты созданы для '. count($employees) .' сотрудников']);
        }
        if($status == 'progress'){
            $attestat = Attestat::create($inputs);
            return response()->json(['success' => true,'total_time'=> $ex_time,'start' => $start,'end' => $end, 'result' => $questions, 'attestat' => $attestat]);
        }
        return response()->json(['error' => true,'message' => 'Что-то пошло не так...']);
    }

    public function startTestUser(Request $request,$id)
    {
        $user = request()->user();
        $attestat = Attestat::with(['category'])->where(['user_id' => $user->id])->find($id);
        if(!$attestat){
            return response()->json(['error' => true, 'message' => 'Тест не найден']);
        }
        $ex_time = 0;
        //Questions
        $questions = $attestat->getQuestions();

        foreach ($questions as $key => $value) {
            $ex_time += $value->time;
        }
        if($attestat->status == 'start'){
            $currentTime = Carbon::now();
            $startTime = $currentTime->toDateTimeString();
            $endTime = $currentTime->addSeconds($ex_time)->toDateTimeString();
            $attestat->started_at = $startTime;
            $attestat->ended_at = $endTime;
            $attestat->status = 'progress';
            $attestat->save();
            return response()->json(['success' => true,'total_time'=> $ex_time,'result' => $questions,'attestat' => $attestat]);
        }
        //If attestat already passed
        if($attestat->status == 'complete'){
            return response()->json(['error' => true, 'message' => 'завершено']);
        }
        return response()->json(['error' => true,'message' => 'Что-то пошло не так...']);
    }

    public function complete(Request $request,$id)
    {
        $user = request()->user();

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
            return response()->json(['error' => true, 'message' => 'Не найден...']);
        }
        //If attestat already passed
        if($attestat->status == 'complete'){
            return response()->json(['error' => true, 'message' => 'завершено']);
        }

        //If the test not for this user
        if($attestat->user_id != $user->id){
            return response()->json(['error' => true, 'message' => 'Вам не разрешено']);
        }

        //Check for time
        $currentTime = Carbon::now();
        if($currentTime->toDateTimeString() > $attestat->ended_at){
            if($attestat->status == 'progress'){
                $attestat->status = 'fail';
                $attestat->save();
            }
            return response()->json([
                'error' => true,
                'message' => 'Time over...',
                'now' => $currentTime->toDateTimeString(),
                'ended_at' => $attestat->ended_at
            ]);
        }

        $inputs = $request->all();

        if(count($inputs['questions']) != $attestat->limit){
            return response()->json(['error' => true, 'message' => 'Что-то пошло не так' ,'limit' => $attestat->limit]);
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
        
        
        return response()->json(['success' => true, 'wrong_answers' => $wrong_answers,'true_answers' => $true_answers, 'ended_at' => $attestat->ended_at,'the_time' => date('Y-m-d H:m:s')]);
    }

    public function show($id)
    {
        $attestat = Attestat::with(['category'])->find($id);
        if(!$attestat){
            return response()->json(['error' => true, 'message' => 'Не найден...']);
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

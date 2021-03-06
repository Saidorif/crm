<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Question;
use App\Attestat;
use App\TestCategory;
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
                // $builder->where(['category_id' => $params['category_id']]);
                $builder->whereJsonContains('category_id', [$params['category_id']]);
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
    		'category_id' => 'required|array',
            'category_id.*' => 'required|integer',
            'date_birth' => 'required|date',
            'pasport_seriya' => 'required|string',
            'pasport_number' => 'required|string',
            'fio' => 'required|string',
            'phone' => 'required|string',
            'position' => 'required|string',
    	]);

    	if($validator->fails()){
    		return response()->json(['error' => true, 'message' => $validator->messages()]);
    	}
        $inputs = $request->all();        
        $user = request()->user();
        $status = 'progress';
        $limit = 0;
        $ex_time = 0;
        $questionsArr = [];
        $questions = [];
        foreach ($inputs['category_id'] as $key => $category) {
            $cat = TestCategory::find((int)$category);
            if($cat){
                $limit += $cat->qty;
                $ex_time += (int)$cat->time * 60;
            }
            $questionsArr[] = Question::with(['variants'])->where('category_id','=', $category)->limit($cat->qty)->get();
        }
    	// $questions = Question::with(['variants'])->whereIn('category_id', $inputs['category_id'])->limit($limit)->get();

        foreach ($questionsArr as $key => $q) {
            foreach ($q as $key => $v) {
                $questions[] = $v;
            }
        }
        
        // return response()->json(['error' => true, 'message' => array_values($questions)]);
        // if(count($questions) < $inputs['limit']){
        //     return response()->json(['error' => true, 'message' => 'Большой лимит...']);
        // }
        
        //Question ids
        $q_ids = [];
        $q_answers = [];
    	foreach ($questions as $key => $value) {
    		$variants = $value->variants;
		    foreach ($variants as $key => $item) {
		    	unset($item['is_true']);
		    }
            
            $q_ids[] = $value->id; 
            $q_answers[] = $value->id; 
    	}
        //Set times for test exam
        $currentTime = Carbon::now();
        $startTime = $currentTime->toDateTimeString();
        $endTime = $currentTime->addSeconds($ex_time)->toDateTimeString();

        $post = [];

        $post['started_at'] = $startTime;
        $post['ended_at'] = $endTime;
        $post['time'] = $ex_time;
        $post['question_ids'] = json_encode($q_ids);
        $post['status'] = $status;
        $post['user_id'] = $user->id;
        $post['fio'] = $inputs['fio'];
        $post['phone'] = $inputs['phone'];
        $post['position'] = $inputs['position'];
        $post['date_birth'] = $inputs['date_birth'];
        $post['pasport_seriya'] = $inputs['pasport_seriya'];
        $post['pasport_number'] = $inputs['pasport_number'];
        $post['limit'] = $limit;
        $post['category_id'] = json_encode($inputs['category_id']);

        if($status == 'progress'){
            $attestat = Attestat::create($post);
            return response()->json(['success' => true,'total_time'=> $ex_time, 'result' => $questions, 'attestat' => $attestat]);
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
            'questions.*.answer_id' => 'required',
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

        // if(count($inputs['questions']) != $attestat->limit){
        //     return response()->json(['error' => true, 'message' => 'Что-то пошло не так' ,'limit' => $attestat->limit]);
        // }
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
        $attestat->variants = json_encode($attestat->questionsWithResult());
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
        $questions = json_decode( $attestat->variants, true);
        $arrRes = [];
        foreach ($questions as $key => $question) {
            if(array_key_exists($question['category'], $arrRes)){
                $arrRes[$question['category']]['trues'] = $arrRes[$question['category']]['trues'] + $question['pass_test'];
            }else{
                $arrRes[$question['category']]['trues'] = $question['pass_test'];
                $arrRes[$question['category']]['all'] = 0;
            }
            $arrRes[$question['category']]['all'] = $arrRes[$question['category']]['all'] + 1;
        }
        $result = [
            'attestat' => $attestat,
            'questions' => $questions,
            'arrRes' => $arrRes,
            // 'questions' => $attestat->questionsWithResult(),
        ];
        return response()->json(['success' => true, 'result' => $result]);
    }

}

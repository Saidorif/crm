<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attestat extends Model
{
    protected $fillable = ['fio','user_id','started_at','ended_at','time','question_ids', 'limit','wrong_answers','true_answers','answer','status','category_id','phone','date_birth','pasport_seriya','pasport_number','position'];

    public function getQuestions()
    {
    	$ids = json_decode($this->question_ids);
    	$questions = Question::whereIn('id', $ids)->get();
    	$results = [];
        foreach ($questions as $key => $item) {
            $variants = $item->variants;
            foreach ($variants as $key => $value) {
                unset($value->is_true);
            }
            $res = new \StdClass();
            $res->id = $item->id;
            $res->title = $item->title;
            $res->time = $item->time;
            $res->category = $item->category->name;
            $res->variants = $variants;
            $results[] = $res;
        }
    	return $results;
    }

    public function questionsWithResult()
    {
    	$ids = json_decode($this->question_ids);
    	$questions = Question::whereIn('id', $ids)->get();
    	if(count($questions) < 1){
    		return response()->json(['error' => true, 'message' => 'Something went wrong...']);
    	}
    	if(count($questions) != count($ids)){
    		return response()->json(['error' => true, 'message' => 'Some questions deleted... Showing result unavailable...']);
    	}
    	$results = [];
    	foreach ($questions as $key => $item) {
    		$answers = json_decode($this->answer);
    		$res = new \StdClass();
    		$res->id = $item->id;
    		$res->title = $item->title;
    		$res->time = $item->time;
    		$res->category = $item->category->name;
    		$res->pass_test = $item->check($answers[$key]->answer_id);
    		$res->user_choose = $answers[$key]->answer_id;
    		$res->variants = $item->variants;
    		$results[] = $res;
    	}
    	return $results;
    }

    public function category()
    {
        return $this->belongsTo(TestCategory::class,'category_id');
    }

    public function getAge()
    {
        $date1 = Carbon::create($this->date_birth);
        return $date1->diffInYears(Carbon::now());
    }
}

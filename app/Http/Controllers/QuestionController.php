<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\TestCategory;
use App\QuestionVariant;
use Validator;

class QuestionController extends Controller
{
    public function index()
    {
        $categories = TestCategory::paginate(12);
        if(!empty($categories)){
            $categories->getCollection()->transform(function ($value) {
                $question_count = $value->questions->count();
                $value->question_count = $question_count;
                unset($value['questions']);
                return $value;
            });
        }
        return response()->json(['success' => true, 'result' => $categories]);
    }

    public function edit($id)
    {
        $category = TestCategory::with('questions')->find($id);
        if(!$category){
            return response()->json(['error' => true, 'message' => 'Вопрос не найден']);
        }

        return response()->json(['success' => true, 'result' => $category]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'category_id' => 'required|integer',
            'variants' => 'required|array',
            'variants.*.question_title' => 'required|string',
            'variants.*.answers' => 'required|array',
            'variants.*.answers.*.title' => 'required|string',
            'variants.*.answers.*.is_true' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }
        $inputs = $request->all();

        foreach ($inputs['variants'] as $key => $value) {
            // return response()->json(['success' => true, 'result' => $inputs]);
            $question = Question::create([
                'title' => $value['question_title'],
                'category_id' => $inputs['category_id'],
            ]);
            $variants = $value['answers'];
            foreach ($variants as $key => $variant) {
                $item = QuestionVariant::create([
                    'title' => $variant['title'],
                    'is_true' => (int)$variant['is_true'],
                    'question_id' => $question->id,
                ]);
            }
        }
        return response()->json(['success' => true, 'result' => $question]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'title'       => 'required|string',
            'category_id' => 'required|integer',
            'time' => 'required|integer',
            'variants' => 'required|array',
            'variants.*.title' => 'required|string',
            'variants.*.is_true' => 'required',
        ]);

        if($validator->fails()){
            return response()->json(['error' => true, 'message' => $validator->messages()]);
        }

        $question = Question::with('variants')->find($id);
        if(!$question){
            return response()->json(['error' => true, 'message' => 'Вопрос не найден']);
        }
        $question->update($request->all());
        //delete old variants
        $old_variants = $question->variants;
        foreach ($old_variants as $key => $value) {
            $value->delete();
        }

        $variants = $request->input('variants');
        foreach ($variants as $key => $variant) {
            $item = QuestionVariant::create([
                'title' => $variant['title'],
                'is_true' => (int)$variant['is_true'],
                'question_id' => $question->id,
            ]);
        }
        return response()->json(['success' => true, 'result' => $question]);
    }

    public function destroy(Request $request, $id)
    {
        $question = Question::find($id);
        if(!$question){
            return response()->json(['error' => true, 'message' => 'Вопрос не найден']);
        }

        $question->delete();

        return response()->json(['error' => true, 'message' => 'Вопрос успешно удален']);
    }


}

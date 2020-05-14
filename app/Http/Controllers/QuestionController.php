<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use App\QuestionVariant;
use Validator;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('category')->paginate(12);
        return response()->json(['success' => true, 'result' => $questions]);
    }

    public function edit($id)
    {
        $question = Question::with('variants')->find($id);
        if(!$question){
            return response()->json(['error' => true, 'message' => 'Вопрос не найден']);
        }

        return response()->json(['success' => true, 'result' => $question]);
    }

    public function store(Request $request)
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

        $question = Question::create($request->all());
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

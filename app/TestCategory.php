<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCategory extends Model
{
    protected $fillable = ['name','status','qty','score','time'];

    public function questions()
    {
        return $this->hasMany(\App\Question::class, 'category_id');
    }

    public function questionscount()
    {
        return $questions = \App\Question::where(['category_id' => $this->id])->count();
    }
}

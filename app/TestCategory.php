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

    public function questionsWithVariant()
    {
        return $this->hasMany(\App\Question::class, 'category_id')->with('variants');
    }
}

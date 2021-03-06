<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TestCategory extends Model
{
    protected $fillable = ['name','status','qty','time'];

    public function questions()
    {
        return $this->hasMany(\App\Question::class, 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(\App\Question::class, 'category_id')->with('variants');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'category_id'];

    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(QuestionVariant::class,'question_id');
    }
}

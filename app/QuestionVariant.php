<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionVariant extends Model
{
    protected $fillable = ['title', 'question_id','is_true'];

    protected $hidden = ['is_true'];

    public function question()
    {
        return $this->belongsTo(Question::class,'question_id');
    }
}

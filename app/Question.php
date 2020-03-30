<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['title', 'category_id','time'];

    public function category()
    {
        return $this->belongsTo(TestCategory::class, 'category_id');
    }

    public function variants()
    {
        return $this->hasMany(QuestionVariant::class,'question_id');
    }

    public function variantsWHA()
    {
    	return $this->variants()->where('is_true','=', 0);
    }

    public function check($is_true)
    {
        $variants = $this->variants;
        foreach ($variants as $key => $variant) {
            if($variant->id == (int)$is_true){
                if($variant->is_true == 1){
                    return 1;
                }
            }
        }
        return 0;
    }
}

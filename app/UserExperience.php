<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserExperience extends Model
{
    protected $fillable = ['user_id','date_from', 'date_to','company','address','position','description'];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }
}

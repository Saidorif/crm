<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attestat extends Model
{
    protected $fillable = ['fio','user_id','started_at','ended_at','time'];
}

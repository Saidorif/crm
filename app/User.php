<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;
use Carbon\Carbon;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','role_id','image','position','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(\App\Role::class, 'role_id');
    }

    public function getAge()
    {
        $date1 = Carbon::create($this->birthday);
        return $date1->diffInYears(Carbon::now());
    }

    public function getStaj()
    {
        $staj = 0;
        $experience = $this->experience;
        if(count($experience) > 0){
            foreach ($experience as $key => $value) {
                $date_from = Carbon::create($value->date_from);
                $date_to = Carbon::create($value->date_to);
                $staj = $staj + $date_from->diffInMonths($date_to);
            }
        }
        return $staj;
    }
}

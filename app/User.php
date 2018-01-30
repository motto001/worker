<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\softDeletes;
class User extends Authenticatable
{
//use SoftDeletes;   
 use Notifiable;
 use  HasRoles;  //crudgeneratorhoz

 //protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function Worker()
    {
        return $this->hasOne('App\Worker','id','user_id');
    }
    /*
    public function Worker(){
        return $this->belongsTo('App\Workeruser','user_id','id');
        }
*/
}

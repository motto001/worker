<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workers';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'status_id', 'workertype_id', 'workergroup_id', 'salary', 'salary_type', 'position', 'foto', 'fullname', 'cim', 'tel', 'birth', 'ado', 'tb', 'start', 'end', 'note', 'pub'];
   
    public function timeframes()
    {
        
        return $this->belongsToMany('App\Timeframe', 'worker_timeframes', 'worker_id', 'timeframe_id');
    }
 
    public function workerday()
    {
        return $this->hasMany('App\Workerday');
    }
    public function workergroup()
    {
        return $this->belongsTo('App\Workergroup');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function workertime()
    {
        return $this->hasMany('App\Workertime');
       // return $this->belongsToMany('App\Workertimeframe', 'worker_timeframes', 'worker_id', 'timeframe_id');
    }


//---------------------------------------
/*
    public function workertimeframe()
    {
        return $this->hasMany('App\Workertimeframe');
       // return $this->belongsToMany('App\Workertimeframe', 'worker_timeframes', 'worker_id', 'timeframe_id');
    }
    public function workerworkergroup()
    {
        return $this->hasMany('App\Workerworkergroup');
    }
    public function workergroupwish()
    {
        return $this->hasMany('App\Workergroupwish');
    }
 
    public function workertimewish()
    {
        return $this->hasMany('App\Workertimewish');
    }
 public function workerwroleunit()
    {
        return $this->hasMany('App\Workerwroleunit');
    }
 public function wishwroleunit()
    {
        return $this->hasMany('App\Wishwroleunit');
    }

   
    public function workerwrole()
    {
        return $this->hasMany('App\Workerwrole');
    }
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    public function workertype()
    {
        return $this->belongsTo('App\Workertype');
    }

    public function day()
    {
        return $this->hasMany('App\Day');
    }
    public function chworkerday()
    {
        return $this->hasMany('App\Chworkerday');
    }
    public function chworkertime()
    {
        return $this->hasMany('App\Chworkertime');
    }
  */  
}

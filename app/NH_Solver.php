<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Solver extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'solver';

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
    protected $fillable = ['worker_id','ev','ho','name', 'note', 'pub','act'];
  
    public function worker()
	{
		return $this->belongsTo('App\Worker');
	}
    public function solverlday()
	{
		return $this->hasMany('App\SolverDay');
	}
    public function solverdaytime()
	{
		return $this->hasMany('App\SolverDayTime');
	}
    public function solvertimeframe()
	{
		return $this->hasMany('App\SolverDayTime');
	}
}

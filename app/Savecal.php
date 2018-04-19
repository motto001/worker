<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Savecal extends Model
{

    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'savecals';

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
  

    public function savecalday()
	{
		return $this->hasMany('App\SavecalDay');
	}
    public function savecaldaytime()
	{
		return $this->hasMany('App\SavecalDayTime');
	}

}

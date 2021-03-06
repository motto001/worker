<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavecalDay extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'savecal_days';

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
    protected $fillable = ['savecal_id', 'daytype_id', 'datum','note','workday','pub'];

    public function savecal()
	{
		 return $this->belongsTo('App\Savecal');
	}
  public function daytype()
	{
		 return $this->belongsTo('App\Daytype');
  }
  /*
  public function savecaldaytime()
	{
		return $this->hasMany('App\SavecalDayTime');
	}
  public function times()
	{
		return $this->hasMany('App\SavecalDayTime');
  }
  */
}

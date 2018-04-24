<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavecalDayTime extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'savecal_day_times';

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
    protected $fillable = ['savecal_day_id', 'timetype_id', 'note','start','end','hour'];

    public function saveday()
	{
		 return $this->belongsTo('App\SavecalDay');
	}
  public function Timetype()
	{
		 return $this->belongsTo('App\Timetype');
	}

}

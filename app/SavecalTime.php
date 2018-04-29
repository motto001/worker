<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SavecalTime extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'savecal_times';

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
    protected $fillable = ['savecal_id', 'timetype_id', 'datum', 'note','start','end','hour','pub'];

    public function savecal()
	{
		 return $this->belongsTo('App\Savecal');
	}
  public function Timetype()
	{
		 return $this->belongsTo('App\Timetype');
	}

}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timeframe extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timeframes';

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
    protected $fillable = ['name', 'unit', 'long', 'start', 'hourmax', 'hourmin', 'note', 'pub'];

    public function worker()
	{
		return $this->belongsToMany('App\Worker','worker_timeframes','worker_id','timeframe_id');
	}
    public function daytype()
    {
        return $this->belongsToMany('App\Daytype','daytype_timeframe');
    }
}

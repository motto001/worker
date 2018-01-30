<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workertimeframe extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'worker_timeframes';

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
    protected $fillable = ['worker_id', 'timeframe_id', 'start', 'end'];
    //protected $guarded = [];
    public function worker_with_user()
    {
        return $this->belongsTo('App\Worker')->with('user');;
    }
   
    public function worker()
    {
        return $this->belongsTo('App\Worker');
    }
    public function timeframe()
    {
        return $this->belongsTo('App\Timeframe');
    }
    public function wroleFull()
    {
        return $this->belongsTo('App\Wrole')->with('wroletime','daytype');
    }
    
}

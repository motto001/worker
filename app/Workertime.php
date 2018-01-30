<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workertime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workertimes';

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
    protected $fillable = ['worker_id', 'timetype_id','wish_id','datum', 'start', 'end', 'hour','pub'];
   
    public function worker()
    {
        return $this->belongsTo('App\Worker');
    }
    public function timetype()
    {
        return $this->belongsTo('App\Timetype');
    }
}

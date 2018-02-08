<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workertimewish extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workertimeswish';

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
    protected $fillable = ['worker_id', 'timetype_id','datum', 'start', 'end', 'hour', 'managernote', 'workernote','pub'];
   
    public function worker()
    {
        return $this->belongsTo('App\Worker')->with('user');
    }
    public function timetype()
    {
        return $this->belongsTo('App\Timetype');
    }
}

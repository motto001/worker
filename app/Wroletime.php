<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wroletime extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wroletimes';

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
    protected $fillable = ['wroleunit_id', 'timetype_id', 'start', 'end', 'hour', 'managernote', 'workernote'];

    public function wroleunit()
    {
         return $this->belongsTo('App\Wroleunit'); 
    }
    public function timetype()
    {
        return $this->belongsTo('App\Timetype');
    }
     
}

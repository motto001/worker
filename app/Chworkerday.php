<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chworkerday extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chworkerdays';

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
    protected $fillable = ['workerday_id', 'daytype_id', 'managernote', 'workernote', 'pub'];
   
    public function day()
    {
        return $this->belongsTo('App\Day');
    } 
    
    public function daytype()
    {
        return $this->belongsTo('App\Daytype');
    }
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Daytype extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'daytypes';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    public $timestamps = false;
    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'szorzo', 'fixplusz', 'color', 'note'];
  
    public function wroleunit()
    {
        return $this->belongsToMany('App\Wroleunit','wroleunit_daytype');
    } 
    public function users()
    {
      return $this->belongsToMany('User', 'user_tasks'); // assuming user_id and task_id as fk
    }
    
    public function day()
    {
        return $this->hasOne('App\Day');
    }  
    public function chworkerday()
    {
        return $this->hasOne('App\chworkerday');
    } 
    public function timeframe()
    {
        return $this->belongsToMany('App\Timeframe','daytype_timeframe');
    }
    
}

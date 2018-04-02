<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Groupwrole extends Model
{
   // use SoftDeletes;
  //  protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wroles';

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
    protected $fillable = ['group_id', 'wrole_id', 'datum'];
    /*
    public function workertime()
    {
        return $this->hasMany('App\Workertime');
    }
    public function chworkerday()
    {
        return $this->hasOne('App\Chworkerday');
    }*/
    public function wrole()
    {
        return $this->belongsTo('App\Wrole');
    } 
    public function group()
    {
        return $this->belongsTo('App\Group');
    } 
    
    
}

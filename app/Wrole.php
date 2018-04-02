<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class Wrole extends Model
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
    protected $fillable = ['name', 'note', 'start', 'pub'];
    /*
    public function workertime()
    {
        return $this->hasMany('App\Workertime');
    }
    public function chworkerday()
    {
        return $this->hasOne('App\Chworkerday');
    }*/
    public function wroletime()
    {
        return $this->hasMany('App\Wroletime');
    } 
    public function groupwrole()
    {
        return $this->hasMany('App\Groupwrole');
    } 
    public function workerwrole()
    {
        return $this->hasMany('App\Workerwrole');
    } 
    
}

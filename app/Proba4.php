<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proba4 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proba4';

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
    protected $fillable = ['proba2_id','name'];
    //protected $guarded = [];
    public function proba2()
    {
        return $this->belongsTo('App\Proba2');
    }
 
/*
    public function proba23()
    {
        return $this->morphMany('App\Proba2','proba2with3');
    }
   
 */   
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proba3 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proba3';

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
    protected $fillable = ['name'];
    //protected $guarded = [];
    public function proba2()
    {
        return $this->belongsToMany('App\Proba','proba2_proba3');
    }
 
/*
    public function proba23()
    {
        return $this->morphMany('App\Proba2','proba2with3');
    }
   
 */   
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proba2 extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proba2';

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
    public function proba()
    {
        return $this->belongsToMany('App\Proba','proba_proba2');
    }
    public function proba3()
    {
        return $this->belongsToMany('App\Proba3','proba2_proba3');
    }
    public function proba4()
    {
        return $this->hasMany('App\Proba4');
    }
    public function proba4_hasone()
    {
        return $this->hasOne('App\Proba4');
        //return $this->hasOne('App\Proba4')->select( 'proba2_id');
       // return $this->hasOne('App\Proba4')->pluck('sss', 'proba2_id');
    }
}
<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proba extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proba';

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
        return $this->belongsToMany('App\Proba2','proba_proba2');
    }
    /*
    public function proba3()
    {
        return $this->morphToMany('App\Proba2','proba_proba2')->with('proba3');
    }*/
    public function proba23()
    {
        return $this->belongsToMany('App\Proba2','proba_proba2')->with('proba3','proba4');
    }
    
}

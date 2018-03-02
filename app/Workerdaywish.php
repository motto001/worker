<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workerdaywish extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workerdayswish';

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
    protected $fillable = ['worker_id', 'daytype_id',  'datum', 'managernote', 'usernote', 'pub'];
    

    public function worker()
    {
        return $this->belongsTo('App\Worker')->with('user');
    } 
    public function daytype()
    {
        return $this->belongsTo('App\Daytype');
    }
    
    
}

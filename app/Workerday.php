<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workerday extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workerdays';

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
    protected $fillable = ['worker_id', 'daytype_id', 'wish_id', 'datum', 'managernote', 'usernote'];
    
    public function workertime()
    {
        return $this->hasMany('App\Workertime');
    }
    public function chworkerday()
    {
        return $this->hasOne('App\Chworkerday');
    }
    public function worker()
    {
        return $this->belongsTo('App\Worker')->with('user');
    } public function daytype()
    {
        return $this->belongsTo('App\Daytype');
    }
    
    
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Timetype extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'timetypes';
    public $timestamps = false;
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
    protected $fillable = ['name', 'szorzo', 'fixplusz', 'color', 'note'];
    
    public function wroletime()
    {
        return $this->hasOne('App\Wroletime');
    }
    public function workertime()
    {
        return $this->hasOne('App\Workertime');
    }   
    
}

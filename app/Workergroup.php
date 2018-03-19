<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workergroup extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workergroups';

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
    protected $fillable = ['name', 'note', 'sum'];

    public function worker()
	{
		return $this->hasMany('App\Worker');
	}
    

}

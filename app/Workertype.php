<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workertype extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'workertypes';

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
    protected $fillable = ['name', 'note'];

    public function worker()
	{
		return $this->hasOne('App\Worker');
	}
	
}

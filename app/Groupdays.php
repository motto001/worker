<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workergroup extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groupdays';

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
    protected $fillable = ['daytype_id', 'group_id', 'datum', 'note', 'pub'];

    public function timetypes()
	{
		return $this->belongsTo('App\Daytype');
	}
    public function group()
	{
		return $this->belongsTo('App\Group');
	}
    

}

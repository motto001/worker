<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chemail extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chemails';

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
    protected $fillable = ['email', 'password', 'password2'];

    
}

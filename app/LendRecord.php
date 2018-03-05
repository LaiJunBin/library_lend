<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class LendRecord extends Model
{
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'unit','teacher','lendTime','date','purpose'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
}

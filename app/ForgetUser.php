<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class ForgetUser extends Model
{
    use Notifiable;
    protected $table = 'forget_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email','verification','password'
    ];
}

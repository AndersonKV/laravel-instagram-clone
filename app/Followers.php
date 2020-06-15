<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Followers extends Model
{
    use Notifiable;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $table = 'users_followers';

    //
    protected $fillable = [
        'id', 'id_user', 'id_user_followers', 'created_at', 'updated_at',
    ];
}

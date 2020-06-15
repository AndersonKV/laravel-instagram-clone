<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class Following extends Model
{
    use Notifiable;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $table = 'users_following';

    protected $fillable = [
        'id_user', 'id_user_following'
    ];

    public function checkedFollow($id_user)
    {
        //verifica se esta logado
        if (Auth::user()) {
            $id = Auth::user()->id;
            $cheked = Following::where('id_user', '=', $id)->where('id_user_following',  '=', $id_user)->get();

            if (!$cheked->isEmpty()) {
                return true;
            }
        } else if (!Auth::user()) {
            return false;
        }
    }

    public function getFollowings($id_user)
    {
        $followings = Following::where('id_user', '=', $id_user)->latest()->get();

        if ($followings->isEmpty()) {
            return null;
        } else {
            return $followings;
        }
    }

    public function getFollowers($id_user)
    {
        $followers = Following::where('id_user_following', '=', $id_user)->get();
        if ($followers->isEmpty()) {
            return null;


            // $followers_array = [];

            // for ($i = 0; $i < count($followers); $i++) {
            //     $followers_array[] = [
            //         'id_user' => $followers[$i]['id_user'],
            //     ];
            // }

            //return $followers_array;
        } else {
            return $followers;

            //dd($post);
        }
    }
}

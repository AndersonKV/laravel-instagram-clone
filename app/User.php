<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user', 'email', 'password', 'image',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUser($user)
    {
        $user = User::where('user', '=', $user)->latest()->get();

        if ($user->isEmpty()) {
            return null;
        } else {
            return $user;
        }
    }

    public function sortUsers($my_id)
    {

        $users = User::where('id', '!=', $my_id)->simplePaginate(15);


        if ($users->isEmpty()) {
            return null;
        } else {
            $post_array = [];


            for ($i = 0; $i < count($users); $i++) {
                $post_array[] = [
                    'img' => $users[$i]['image'],
                    'user' => $users[$i]['user'],
                ];
            }

            return $post_array;
        }
    }

    public function searchUsers($word)
    {

        //$post = User::where('user', 'like', "%$word%")->getAll();

        if (strlen($word) >= 2) {
            $post = User::where('user', 'like', "%$word%")->get();
        } else {
            return ['response' => 'empty'];
        }

        if (!empty($post[0])) {
            $post_array = [];

            for ($i = 0; $i < count($post); $i++) {
                $post_array[] = [
                    'img' => $post[$i]['image'],
                    'user' => $post[$i]['user'],
                ];
            }
            //mysql_close($post);

            return $post_array;
        } else {
            return ['response' => 'empty'];

            //dd($post);
        }
    }
    public function ajaxGetFollowers($data)
    {

        //$post = User::where('user', 'like', "%$word%")->getAll();
        if (!empty($data[0])) {

            $post_array = [];

            for ($i = 0; $i < count($data); $i++) {
                $user = User::where('id', '=', $data[$i]['id_user'])->latest()->get();
                $post_array[] = [
                    'img' => $user[0]['image'],
                    'user' => $user[0]['user'],
                ];
            }

            return $post_array;
        } else {
            return ['response' => 'empty'];

            //dd($post);
        }
    }
    public function ajaxGetFollowings($data)
    {

        //$post = User::where('user', 'like', "%$word%")->getAll();
        if (!empty($data[0])) {

            $post_array = [];

            for ($i = 0; $i < count($data); $i++) {
                $user = User::where('id', '=', $data[$i]['id_user_following'])->latest()->get();
                $post_array[] = [
                    'img' => $user[0]['image'],
                    'user' => $user[0]['user'],
                ];
            }

            return $post_array;
        } else {
            return ['response' => 'empty'];

            //dd($post);
        }
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Post;
use App\User;

class Like extends Model
{
    protected $fillable = [
        'id', 'id_user', 'id_post',
    ];
    protected $table = 'like_photos';



    public function likes($id_post)
    {
        $post = Post::where('id', '=', $id_post)->latest()->get();

        if ($post->isEmpty()) {
            return null;
        } else {
            $id_user = Auth::user()->id;
            $verifyLike = Like::where('id_user', '=', $id_user)->where('id_post',  '=', $id_post)->latest()->get();

            if (count($verifyLike) == 0) {
                $like = new Like;

                $like->id_user = $id_user;
                $like->id_post = $id_post;
                $like->save();

                $getUsers = Like::where('id_post', '=', $id_post)->latest()->get();

                $array_users = [];

                for ($i = 0; $i < count($getUsers); $i++) {
                    $id_user = $getUsers[$i]['id_user'];

                    $getUser = User::where('id', '=', $id_user)->latest()->get();

                    $array_users[] = [
                        'user' => $getUser[0]->user,
                        'image' => $getUser[0]->image,
                    ];
                }

                $response = [
                    'like' => '200',
                    'users' => $array_users
                ];

                return $response;
            } else {
                Like::where('id_user', '=', $id_user)->where('id_post',  '=', $id_post)->delete();

                $getUsers = Like::where('id_post', '=', $id_post)->latest()->get();

                $array_users = [];

                for ($i = 0; $i < count($getUsers); $i++) {
                    $id_user = $getUsers[$i]['id_user'];

                    $getUser = User::where('id', '=', $id_user)->latest()->get();

                    $array_users[] = [
                        'user' => $getUser[0]->user,
                        'image' => $getUser[0]->image,
                    ];
                }

                $response = [
                    'deslike' => '200',
                    'users' => $array_users
                ];

                return $response;
            }
        }
    }
    public function allLikes($id_post)
    {

        $post = Post::where('id', '=', $id_post)->latest()->get();

        if ($post->isEmpty()) {
            return null;
        } else {
            $getUsers = Like::where('id_post', '=', $id_post)->latest()->get();

            $array_users = [];

            for ($i = 0; $i < count($getUsers); $i++) {
                $id_user = $getUsers[$i]['id_user'];

                $getUser = User::where('id', '=', $id_user)->latest()->get();

                $array_users[] = [
                    'user' => $getUser[0]->user,
                    'image' => $getUser[0]->image,
                ];
            }

            return $array_users;
        }
    }
    public function verifyLike($id, $id_post)
    {
        $verifyLike = Like::where('id_user', '=', $id)->where('id_post',  '=', $id_post)->latest()->get();

        if ($verifyLike->isEmpty()) {
            return null;
        } else {
            return  ['like' => 'success'];
        }
        //$post = Post::where('post_text', 'like', "%$post_url%")->latest()->get();

    }
    public function countLikes($id_post)
    {
        $like = Like::where('id_post', '=', $id_post)->latest()->get();

        if ($like->isEmpty()) {
            return null;
        } else {
            return $like->count();
        }
    }
    public function countUsersLike($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $like = Like::where('id_post', '=', $data[$i]['id'])->count();
            $data[$i]['likes'][$i] = $like;
        }
        return $data;

        if ($like->isEmpty()) {
            return null;
        } else {
            return $like->count();
        }
    }
    public function setAllLikes($posts)
    {


        if ($posts != null) {

            $post_array = [];
            $array_likes = [];

            for ($f = 0; $f < count($posts); $f++) {
                $id_user = $posts[$f]['id_user'];
                $id_post = $posts[$f]['id'];
                // $user = Like::where('id_user', '=', $id_user)->where('id_post',  '=', $id_post)->latest()->get();

                // dump($user[0]['id_post']);

                $verifyLike = Like::where('id_post', $id_post)->latest()->get(); //->where('id_post',  '=', $id_post)->get();

                //$liked = (Auth::user()->id == $verifyLike[$l]['id_user'] ? true : false);

                if (!$verifyLike->isEmpty()) {
                    for ($l = 0; $l < count($verifyLike); $l++) {

                        $getUser = User::where('id', '=', $verifyLike[$l]['id_user'])->latest()->get();

                        //$liked = (Auth::user()->id == $verifyLike[$l]['id_user'] ? true : false);

                        $array_likes = [
                            'id_like' => $verifyLike[$l]['id'],
                            'id_user' => $verifyLike[$l]['id_user'],
                            'id_post' => $verifyLike[$l]['id_post'],
                            'user' => $getUser[0]['user'],
                            'image' => $getUser[0]['image'],
                        ];

                        // for ($e = 0; $e < count($posts); $e++) {
                        //     dump($e);
                        //     break;
                        //     //$liked = (Auth::user()->id == $array_likes['id_user'] ? true : false);
                        //     //$posts[$e]['liked'] = $liked;
                        // }

                        $posts[$f]['likes'][] = $array_likes;
                        //$posts[$f]['liked'] = false;
                    }
                }
            }

            for ($e = 0; $e < count($posts); $e++) {
                for ($s = 0; $s < count($posts[$e]['likes']); $s++) {
                    if ($posts[$e]['id_user'] == $posts[$e]['likes'][$s]['id_user']) {
                        $liked = ($posts[$e]['id_user'] == $posts[$e]['likes'][$s]['id_user'] ? true : false);
                        $posts[$e]['liked'] = $liked;
                    }
                }
            }

            return $posts;
        } else {

            return null;
        }
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    use Notifiable;
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $table = 'users_post';

    protected $casts = [
        'comment' => 'array',
    ];

    protected $fillable = [
        'id_user', 'post_image', 'post_text'
    ];


    public function getMyPosts($id_user, $user, $image)
    {

        $post = Post::where('id_user', '=', $id_user)->latest()->get();

        if ($post == null) {
            return null;
        } else {
            $post_array = [];
            $array_likes = [];

            for ($i = 0; $i < count($post); $i++) {
                $newString = substr($post[$i]['post_image'], 0, strpos($post[$i]['post_image'], ".jpeg"));

                $separeString = explode(' ', $post[$i]['post_text']);

                for ($init = 0; $init < count($separeString); $init++) {
                    if ($separeString[$init][0] == "#") {
                        $href = str_replace($separeString[$init], '<a href="/explore/tags/' . substr($separeString[$init], 1) . '">' . $separeString[$init] . '</a>', $separeString);
                        $separeString[$init] = $href[$init];
                    }
                }
                $hashtag = implode(' ', $separeString);

                $post_array[] = [
                    'id' => $post[$i]['id'],
                    'id_user' => $post[$i]['id_user'],
                    'image' => $post[$i]['post_image'],
                    'post' => $hashtag,
                    'name_user' => $user,
                    'image_perfil' => $image,
                    'link_post' => $newString,
                    'comment' => [],
                    'likes' => [],
                ];
            }


            for ($l = 0; $l < count($post_array); $l++) {
                $id_post = $post_array[$l]['id'];

                $verifyLike = Like::where('id_post', $id_post)->latest()->get(); //->where('id_post',  '=', $id_post)->get();

                // if (!$verifyLike->isEmpty()) {
                //     for ($q = 0; $q < count($post_array); $q++) {
                //         $getUser = User::where('id', '=', $verifyLike[$q]['id_user'])->latest()->get();

                //         $array_likes = [
                //             'id_like' => $verifyLike[$q]['id'],
                //             'id_user' => $verifyLike[$q]['id_user'],
                //             'id_post' => $verifyLike[$q]['id_post'],
                //             'user' => $getUser[0]['user'],
                //             'image' => $getUser[0]['image']
                //         ];


                //         $post_array[$q]['likes'] = $array_likes;
                //     }
                // }
            }

            return $post_array;
        }
    }

    public function postsFromFollowings($id_user)
    {
        //pega todos os meus posts
        $getPost = Following::where('id_user', '=', $id_user)->latest()->get();

        if ($getPost->isEmpty()) {
            return null;
        } else {

            $getPostsFromFollowing = Following::where('id_user', '=', $id_user)->latest()->get();

            $array_id_user_following = [];
            $array_likes = [];


            foreach ($getPostsFromFollowing as $post_id) {
                $user = User::where('id', '=', $post_id->id_user_following)->latest()->get();

                $array_id_user_following[] = [
                    'user' => $user[0]->user,
                    'image_perfil' => $user[0]->image,
                    'id_user_following' => $user[0]->id,
                ];
            }

            $array_post_following = [];

            for ($i = 0; $i < count($array_id_user_following); $i++) {
                $id_user = $array_id_user_following[$i]['id_user_following'];
                $postFollowing = Post::where('id_user', $id_user)->latest()->get();

                for ($l = 0; $l < count($postFollowing); $l++) {
                    $user = User::where('id', '=', $postFollowing[$l]['id_user'])->latest()->get();
                    for ($p = 0; $p < count($user); $p++) {
                        $newString = substr($postFollowing[$l]['post_image'], 0, strpos($postFollowing[$l]['post_image'], ".jpeg"));

                        $array_post_following[] = [
                            'id' => $postFollowing[$l]['id'],
                            'id_user' => $postFollowing[$l]['id_user'],
                            'image' => $postFollowing[$l]['post_image'],
                            'post' => $postFollowing[$l]['post_text'],
                            'name_user' => $user[$p]->user,
                            'image_perfil' => $user[$p]->image,
                            'link_post' => $newString,
                            'comment' => [],
                            'likes' => []

                        ];
                    }
                }
            }

            // for ($l = 0; $l < count($array_post_following); $l++) {
            //     $id_post = $array_post_following[$l]['id'];

            //     $verifyLike = Like::where('id_post', $id_post)->latest()->get(); //->where('id_post',  '=', $id_post)->get();

            //     if (!$verifyLike->isEmpty()) {
            //         for ($q = 0; $q < count($array_post_following); $q++) {

            //             $getUser = User::where('id', '=', $verifyLike[$q]['id_user'])->latest()->get();

            //             $array_likes = [
            //                 'id_like' => $verifyLike[$q]['id'],
            //                 'id_user' => $verifyLike[$q]['id_user'],
            //                 'id_post' => $verifyLike[$q]['id_post'],
            //                 'user' => $getUser[0]['user'],
            //                 'image' => $getUser[0]['image']
            //             ];

            //             $array_post_following[$q]['likes'] = $array_likes;
            //         }
            //     }
            // }

            return $array_post_following;
        }
    }

    public function getOnePost($url_image, $user, $image, $id_user)
    {
        $new = $url_image . '.jpeg';
        $post = Post::where('post_image', '=', $new)->latest()->get();

        if (!empty($post[0])) {

            if ($post[0]->id_user == $id_user) {
                $post_array = [];
                $array_likes = [];


                for ($i = 0; $i < count($post); $i++) {
                    $day_month_year = date("d/m/Y", strtotime($post[$i]->created_at));

                    $post_array[] = [
                        'id' => $post[$i]['id'],
                        'id_user' => $post[$i]['id_user'],
                        'image' => $post[$i]['post_image'],
                        'post' => $post[$i]['post_text'],
                        'name_user' => $user,
                        'image_perfil' => $image,
                        'link_post' => $url_image,
                        'data' => $day_month_year,
                        'comment' => [],
                        'likes' => []
                    ];
                }

                $separeString = explode(' ', $post_array[0]['post']);

                for ($init = 0; $init < count($separeString); $init++) {
                    if ($separeString[$init][0] == "#") {
                        $href = str_replace($separeString[$init], '<a href="/explore/tags/' . substr($separeString[$init], 1) . '">' . $separeString[$init] . '</a>', $separeString);
                        $separeString[$init] = $href[$init];
                    }
                }
                $hashtag = implode(' ', $separeString);
                $post_array[0]['post'] = $hashtag;


                for ($i = 0; $i < count($post); $i++) {
                    $newString = substr($post[$i]['post_image'], 0, strpos($post[$i]['post_image'], ".jpeg"));

                    $separeString = explode(' ', $post[$i]['post_text']);

                    for ($init = 0; $init < count($separeString); $init++) {
                        if ($separeString[$init][0] == "#") {
                            $href = str_replace($separeString[$init], '<a href="/explore/tags/' . substr($separeString[$init], 1) . '">' . $separeString[$init] . '</a>', $separeString);
                            $separeString[$init] = $href[$init];
                        }
                    }
                    $hashtag = implode(' ', $separeString);
                }

                $id_post = $post_array[0]['id'];

                $verifyLike = Like::where('id_post', $id_post)->latest()->get(); //->where('id_post',  '=', $id_post)->get();

                if (!$verifyLike->isEmpty()) {
                    for ($l = 0; $l < count($verifyLike); $l++) {
                        $getUser = User::where('id', '=', $verifyLike[$l]['id_user'])->latest()->get();

                        $array_likes = [
                            'id_like' => $verifyLike[$l]['id'],
                            'id_user' => $verifyLike[$l]['id_user'],
                            'id_post' => $verifyLike[$l]['id_post'],
                            'user' => $getUser[0]['user'],
                            'image' => $getUser[0]['image']
                        ];

                        $post_array[0]['likes'][] = $array_likes;
                    }
                }


                return $post_array;
            } else {
                return null;
            }
        }
    }
    public function search($wordSearch)
    {
        $word =  '#' . $wordSearch;
        $post = Post::where('post_text', 'like', "%$word%")->latest()->get();


        if (!empty($post[0])) {

            $post_array = [];

            for ($i = 0; $i < count($post); $i++) {
                $user = User::where('id', 'like', $post[$i]['id_user'])->latest()->get();

                $day_month_year = date("d/m/Y", strtotime($post[$i]->created_at));

                $cutName = $post[$i]['post_image'];
                $linkUrl = explode('.', $cutName, 2);

                $post_array[] = [
                    'id' => $post[$i]['id'],
                    'id_user' => $post[$i]['id_user'],
                    'image' => $post[$i]['post_image'],
                    'post' => $post[$i]['post_text'],
                    'name_user' => $user[0]['user'],
                    'link_post' => $linkUrl[0],
                    // 'data' => $day_month_year,
                    // 'comment' => [],
                ];
            }

            return $post_array;
        } else {
            return null;


            //dd($post);
        }
    }
    public function searchHashtags($word)
    {

        $post = Post::where('post_text', 'like', "%$word%")->latest()->get();

        if (!empty($post[0])) {

            $post_array = [
                'hashtag' => null,
                'len' => null
            ];

            //for ($z = 0; $z < count($post); $z++) {
            $separeString = explode(' ', $post[0]['post_text']);
            $separe = explode(" ", $word);

            for ($i = 0; $i < count($separeString); $i++) {
                for ($s = 0; $s < count($separe); $s++) {
                    if (strpos($separeString[$i], $word) !== false) {
                        $post_array['hashtag'] = $separeString[$i];
                    }
                }
            }
            //}
            $post_array['len'] = count($post);


            return $post_array;
        } else {
            return ['response' => 'hashtag_empty'];
            // if (!empty($post[0])) {

            //     $cut = $post[0]['post_text'];
            //     $linkUrl = explode('.', $cut, 3);

            //     dd($linkUrl);
            // }

            //dd($post);
        }
    }
}

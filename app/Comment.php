<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;

class Comment extends Model
{
    protected $table = 'post_comments';


    protected $fillable = [
        'id_user', 'comment', 'id_post', 'updated_a t'
    ];

    public function getMyComments($data)
    {
        if ($data == null) {
            return null;
        } else {
            $array_comments = [];

            for ($i = 0; $i < count($data); $i++) {
                $getIndividualComment = Comment::select('id', 'id_user', 'id_post', 'comment', 'created_at')->where('id_post', '=', $data[$i]['id'])->get();
                $data[$i]['liked'] = false;

                for ($l = 0; $l < count($getIndividualComment); $l++) {

                    for ($n = 0; $n < count($data); $n++) {

                        if ($data[$n]['id'] == $getIndividualComment[$l]['id_post']) {

                            $getUser = User::select('user', 'image')->where('id', '=', $getIndividualComment[$l]['id_user'])->get();
                            // 01-12-2016
                            $day_month_year = date("d/m/Y", strtotime($getIndividualComment[$l]->created_at));

                            $oneComment = [
                                'id' => $getIndividualComment[$l]['id'],
                                'id_user' => $getIndividualComment[$l]['id_user'],
                                'id_post' => $getIndividualComment[$l]['id_post'],
                                'comment' => $getIndividualComment[$l]['comment'],
                                'data' => $day_month_year,
                                'user' => $getUser[0]['user'],
                                'image' => $getUser[0]['image'],
                                'likes' => []
                            ];


                            $separeString = explode(' ', $oneComment['comment']);

                            for ($init = 0; $init < count($separeString); $init++) {
                                if ($separeString[$init][0] == "#") {
                                    $href = str_replace($separeString[$init], '<a href="/explore/tags/' . substr($separeString[$init], 1) . '">' . $separeString[$init] . '</a>', $separeString);
                                    $separeString[$init] = $href[$init];
                                }
                            }
                            $hashtag = implode(' ', $separeString);
                            $oneComment['comment'] = $hashtag;
                            $data[$n]['comment'][] = $oneComment;
                        }
                    }
                }
            }


            return $data;
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Like;
use App\Followers;
use App\Following;
use App\Comment;
use App\Post;
use Illuminate\Support\Facades\Auth;
use Hash;
use URL;
use Route;


class HomeController extends Controller
{



    public function home()
    {
        if (Auth::check()) {
            $my_id = Auth::user()->id;
            $user = Auth::user()->user;
            $image = Auth::user()->image;

            $posts = new Post;
            //get my posts
            $getMyPosts = $posts->getMyPosts($my_id, $user, $image);

            //get posts from my followings
            $getFollowersPost = $posts->postsFromFollowings($my_id);

            $data = [];

            if ($getMyPosts != null) {
                for ($i = 0; $i < count($getMyPosts); $i++) {
                    $data[] = $getMyPosts[$i];
                }
            }

            if ($getFollowersPost != null) {
                for ($l = 0; $l < count($getFollowersPost); $l++) {
                    $data[] = $getFollowersPost[$l];
                }
            }

            $sortUser = new User;
            $getSort = $sortUser->sortUsers($my_id);

            $comment = new Comment;
            $setPostsWithComements = $comment->getMyComments($data);

            $like = new Like;
            $finalComment = $like->setAllLikes($setPostsWithComements);

            return view('app.home', [
                'posts' => $finalComment,
                'sort' => $getSort,

            ]);
        } else {
            return view('index');
        }


        //return view('home');
    }
    public function like(Request $request)
    {
        if (!Auth::check()) {
            return ['status' => '401'];
        }

        if ($request->all() == null) {
            return redirect('');
        } else {
            $id_post = $request->all()['id_post'];

            $like = new Like;
            $getLike = $like->likes($id_post);

            return $getLike;
        }

        //return view('home');
    }
    public function getLikes(Request $request)
    {


        if ($request->all() == null) {
            return redirect('');
        } else {
            $id_post = $request->all()['id_post'];

            $like = new Like;
            $getLike = $like->allLikes($id_post);

            return $getLike;
        }

        //return view('home');
    }
    public function search(Request $request)
    {

        if ($request->all() == null) {
            return redirect('');
        } else {
            $word = $request->all(); // ou
            $hashtag = $word['word'];

            if (strlen($hashtag) >= 2) {
                if ($hashtag[0] == "#") {
                    $posts = new Post;
                    $getHash = $posts->searchHashtags($hashtag);
                    return response($getHash);
                }
            }

            if (strlen($hashtag) >= 2) {
                if ($hashtag[0] != "#") {
                    $user = new User;
                    return response()->json($user->searchUsers($hashtag));
                }
            }
        }


        // //return response()->json($word);

        //return response($getWordSearch);
        //return response(json_encode($getWordSearch));
    }
    public function ajaxGetFollowers(Request $request)
    {
        if ($request->all() == null) {
            return redirect('');
        } else {
            $id = $request->all()['id']; // ou

            $followers = new Following;
            $users = new User;

            $getFollowers = $followers->getFollowers($id);
            $FormatedFollowers = $users->ajaxGetFollowers($getFollowers);
            return response()->json($FormatedFollowers);
        }
    }
    public function ajaxGetFollowings(Request $request)
    {

        if ($request->all() == null) {
            return redirect('');
        } else {
            $id = $request->all()['id']; // ou

            $followers = new Following;
            $users = new User;

            $getFollowings = $followers->getFollowings($id);

            $FormatedFollowings = $users->ajaxGetFollowings($getFollowings);

            return response()->json($FormatedFollowings);
        }


        // //return response()->json($word);

        //return response($getWordSearch);
        //return response(json_encode($getWordSearch));
    }
    public function post(Request $request)
    {
        return view('app.post');
    }
    public function handleMessage(Request $request)
    {
        if ($request->_token == null) {
            return back();
        }
        if ($request->post_id == null) {
            return back();
        }
        if ($request->message == null) {
            return back();
        }



        if (!empty($request->message)) {
            $messagem = $request->message;
            $id_post = $request->post_id;

            //$getPost = Post::where('id', '=', $id_post)->first();

            $newComment = new Comment();

            $newComment->id_user = Auth::user()->id;
            $newComment->id_post = $id_post;
            $newComment->comment = $messagem;

            $newComment->save();

            return redirect()->back();
        }
    }

    public function handleSubmit(Request $request)
    {


        if ($request->_token == null) {
            return redirect('');
        }
        if ($request->hasFile('image') == null) {
            return redirect('');
        }
        if ($request->post == null) {
            return redirect('');
        }
        $user = Auth::user();

        if ($request->hasFile('image') && $request->file('image')[0]->isValid()) {
            if ($user->image) {
                $name = $user->image;
            } else {
                $name = $user->id . kebab_case($user->name);
            }

            // Define um aleatório para o arquivo baseado no timestamps atual
            $name = uniqid(date('HisYmd'));

            // Recupera a extensão do arquivo
            $extension = $request->image[0]->extension();

            // Define finalmente o nome
            $nameFile = "{$name}.{$extension}";
            // Faz o upload:
            $upload = $request->image[0]->storeAs('upload', $nameFile);

            // Verifica se NÃO deu certo o upload (Redireciona de volta)
            if (!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload')
                    ->withInput();
            }

            $post = new Post();

            $post->id_user = $user->id;
            $post->post_image = $nameFile;
            $post->post_text = $request->post;

            $post->save();


            //salva no banco de dados o nome da imagem

            return redirect()->back();
        }
    }

    public function user(Request $request)
    {

        //pega url que contem o nome, que é unico, do usuario
        $url = $request->path();
        //pega o nome no db com base na url
        $user = new User();

        $getUser = $user->getUser($url);

        if ($getUser == null) {
            return view('app.user', [
                'user_not_found' => true
            ]);
        }

        $data = [];
        $credential = [];

        if ($getUser[0] != null) {
            //$auth_id = Auth::user()->id;
            $id_user = $getUser[0]->id;
            $user = $getUser[0]->user;
            $image = $getUser[0]->image;

            $posts = new Post;
            //GET MY POSTS
            $getMyPosts = $posts->getMyPosts($id_user, $user, $image);

            //GET POSTS FROM MY FOLLOWINGS
            $getFollowersPost = $posts->postsFromFollowings($id_user);

            $following = new Following;
            //GET ALL MY FOLLOWING

            //$chekedFollow = $following->chekedFollow($id_user, $auth_id);
            $checked = $following->checkedFollow($id_user);
            $getFollowing = $following->getFollowings($id_user);
            $getFollowers = $following->getFollowers($id_user);

            $following = [];
            $followers = [];

            // if ($getFollowing != null) {
            //     for ($i = 0; $i < count($getFollowing); $i++) {
            //         $following[] = $getFollowing[$i];
            //     }
            // }

            if ($getFollowing == null) {
                $following = 0;
            } else {
                $following = count($getFollowing);
            }

            if ($getFollowers == null) {
                $followers = 0;
            } else {
                $followers = count($getFollowers);
            }

            $credential = [
                'id' => $id_user,
                'user' => $user,
                'image' => $image,
            ];

            if ($getMyPosts != null) {
                for ($i = 0; $i < count($getMyPosts); $i++) {
                    $data[] = $getMyPosts[$i];
                }
            }
        }


        $comment = new Comment;
        //GET COMMENTS IN MY POSTS
        $getMyComments = $comment->getMyComments($data);

        $like = new Like;
        $getLikes = $like->setAllLikes($getMyComments);

        if ($getLikes != null) {
            for ($i = 0; $i < count($getLikes); $i++) {
                $getMyComments[$i]['likes'] = $getLikes[$i]['likes'];
            }
        }

        return view('app.user', [
            'user' => $credential,
            'followings' => $following,
            'followers' => $followers,
            'posts' => $getMyComments,
            'count_posts' => count($getMyPosts),
            'checked' => $checked,
            'user_not_found' => false

        ]);
    }
    public function following(Request $request)
    {
        $id_user = Auth::user()->id;
        //pega o usuario
        $getUser = User::where('user', $request->name)->latest()->get();
        $id_user_following = $getUser[0]->id;

        $myFollow = Following::where('id_user', '=', $id_user)->where('id_user_following',  '=', $id_user_following)->get();

        if (count($myFollow) == 0) {
            echo 'nao tem';
            $user = new Following;

            $user->id_user = $id_user;
            $user->id_user_following = $id_user_following;
            $user->save();
            return back()->with('message_success', 'Thanks for register');
        } else {
            return back()->with('');
        }
    }
    public function unfollowing(Request $request)
    {
        $id_auth = Auth::user()->id;
        //pega o usuario
        $getUser = User::where('user', $request->name)->latest()->get();
        //recupera o id do usuario para dar unfollowing
        $id_user_unfollowing = $getUser[0]->id;

        $unfollowing = Following::where('id_user', '=', $id_auth)->where('id_user_following',  '=', $id_user_unfollowing)->delete(); //->delete();
        //$unfollowing->save();

        return back()->with('message_success', 'Thanks for register');
    }
    public function logout(Request $request)
    {
        //dd(Auth::check());

        Auth::logout();
        return view('/logout');
    }
    public function edit(Request $request)
    {
        if (Auth::check()) {
            return view('app.edit');
        }
        return redirect('/');
    }
}

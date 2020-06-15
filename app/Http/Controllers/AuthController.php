<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Like;
use Auth;
use Hash;
use App\Post;
use App\Comment;
use Illuminate\Support\Facades\Input;

class AuthController extends Controller
{

    private $user;
    private $email;
    private $password;

    public function index()
    {
        if (Auth::check()) {
            return view('app.home');
        }
        return view('index');
    }

    public function photo(Request $request)
    {
        $separte = explode('/', $request->path(), 3);

        $user = new User();
        $getUser = $user->getUser($separte[0]);

        if ($getUser == null) {
            return view('app.user', ['user_not_found' => true]);
        }

        $id_user = $getUser[0]->id;
        $user = $getUser[0]->user;
        $image = $getUser[0]->image;

        $url_image = $separte[2];

        $posts = new Post;
        $getPost = $posts->getOnePost($url_image, $user, $image, $id_user);

        if ($getPost == null) {
            return view('app.user', ['user_not_found' => true]);
        }

        $comment = new Comment;
        $getMyComments = $comment->getMyComments($getPost);

        $post_like = null;

        if (Auth::user()) {
            $id = Auth::user()->id;
            $userLike = new Like;

            $id_post = $getMyComments[0]['id'];
            $getLike = $userLike->verifyLike($id, $id_post);

            if ($getLike['like']) {
                $post_like = true;
            }
        }

        $like = new Like;
        $id_post = $getMyComments[0]['id'];

        return view('app.photo', [
            'post' => $getMyComments[0],
            'like' => $post_like,

        ]);
    }
    public function search(Request $request)
    {
        //pega url que contem o nome, que é unico, do usuario
        $url = $request->path();
        //pega o nome no db com base na url
        $separ = explode('/', $url, 3);
        $wordSearch =  $separ[2];
        $posts = new Post;
        //GET MY POSTS
        $getWordSearch = $posts->search($wordSearch);

        if ($getWordSearch == null) {
            return view('app.user', [
                'user_not_found' => true
            ]);
        }

        return view('app.search', [
            'post' => $getWordSearch,
            'word' => $wordSearch
        ]);
    }
    public function form()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $user = User::where('user', request('user'))->get();
        $email = User::where('email', request('email'))->get();

        if ($user->isEmpty()) {
            $user = new User();

            $user->email = request('email');
            $user->name_complete = request('nameComplete');
            $user->user = request('user');
            $user->password = Hash::make(request('password'));

            $user->save();

            return back()->with('message_success', 'Thanks for register');

            if ($email->isEmpty()) {
                $user = new User();

                $user->email = request('email');
                $user->name_complete = request('nameComplete');
                $user->user = request('user');
                $user->password = Hash::make(request('password'));

                $user->save();

                return redirect('/')->with('mssg', 'Thanks for register');
            } else {
                return back()->with('error_email', 'email ja foi cadastrado');
            }
        } else {
            return back()->with('error_user', 'usuario já existe');
        }
    }
    public function login(Request $request)
    {

        if (Auth::check() === true) {
            return view('app.home');
        }

        $verify = strpos($request->email, '@');

        if ($verify === false) {
            //USUARIO ACESSANDO COM USER
            $credentials = [
                'user' => $request->email,
                'password' => $request->password
            ];

            $user = User::where('user', '=', $credentials['user'])->first();
            //se user não existir retorna
            if ($user === null) {
                return redirect()->back()->withInput()->withErrors(['Esse usuario não foi registrado']);
            }

            //verifica o hash se for igual usuario é autenticado
            if (Hash::check($credentials['password'], $user->password)) {
                if (Auth::attempt($credentials)) {
                    return redirect()->intended('/');
                }
            } else {
                return redirect()->back()->withInput()->withErrors(['Sua senha está incorreta']);
            }
        } else {

            $credentials = [
                'email' => $request->email,
                'password' => $request->password
            ];

            $user = User::where('email', '=', $credentials['email'])->first();
            //se user não existir retorna
            if ($user === null) {
                return redirect()->back()->withInput()->withErrors(['Esse email não foi registrado']);
            }

            //verifica o hash se for igual usuario é autenticado
            if (Hash::check($credentials['password'], $user->password)) {
                if (Auth::attempt($credentials)) {
                    return redirect()->intended('/');
                }
            } else {
                return redirect()->back()->withInput()->withErrors(['Sua senha está incorreta']);
            }
        }
    }

    public function logout(Request $request)
    {
        if (Auth::check() === true) {
            Auth::logout();
            return redirect('/');
        } else {
            return back();
        }
    }
}

@extends('layouts.app')

@section('content')

<main class="main-home">
    <div class="main-home--my-container">
        <div class="main-home--left">
            <img src="/assets/bg-home.jpg" alt="carousel-images"/> 
            <div>
                <img src="/assets/carousel/first.jpg"/>
                <img src="/assets/carousel/two.jpg"/>
                <img src="/assets/carousel/three.jpg"/>
                <img src="/assets/carousel/four.jpg"/>
            </div>
        </div>
        <div class="main-home--right">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="title-instagram">
                    <img src="/assets/title-form.jpg" alt="title-instagram"/>
                </div>
                <div>
                    <label class="label-email">Telefone, nome de usuario ou email</label>
                    <input maxlength="75" placeholder="Telefone, nome de usuario ou email"
                    name="email" type="text" id="email" >
                </div>

                <div>
                    <label class="label-password">Senha</label>
                     
                    <input maxlength="75" placeholder="Senha"
                    name="password" type="password" id="password" >
                    @if ($errors->all())
                    @foreach($errors->all() as $error)
                        <span class="error">{{$error}}</span>
                    @endforeach
                 @endif
                </div>
            
            
                <div>
                    <button>Entrar</button>
                </div>
                <div class="main-home--gray-line">
                    <div></div>
                    <div>OU</div>
                    <div></div>
                </div>
                <div class="main-home--log-in-or-forget">
                    <span><i class="fab fa-facebook-square"></i> Entrar com facebook</span>
                    <span>Esqueceu sua senha</span>
                </div>
            </form>
            <div class="main-home--no-account">
                <span>Não tem conta? <a href="accounts/emailsignup">Cadastre-se</a></span>
            </div>
            <div class="main-home--app">
                <span>Obtenha o aplicativo.</span>
                <div class="bola">
                    <img src="/assets/icon-app-store.png" alt="icon-app-store"/>
                    <img src="/assets/icon-google-play.png" alt="icon-google-play"/>
                </div>
            </div>
        </div>
    </div>
</main>
 @endsection

<script type="text/javascript" src="{{ asset('js/main-index.js') }}"></script>

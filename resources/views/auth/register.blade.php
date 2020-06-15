@extends('layouts.app')

@section('content')
<main class="main-register">
<div class="register-body">

    @if (session()->get('message_success'))
    <div class="register-success">
        <h3>Sua conta foi registrada com sucesso <a href="/"><i class="fas fa-arrow-left"></i></a></h3>   
    </div>
    @else
   
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="title-instagram">
            <img src="/assets/title-form.jpg" alt="title-instagram"/>
            <h1>Cadastre-se para ver fotos e vídeos dos seus amigos</h1>
            <button>Entrar com facebook</button>
            <div class="main-home--gray-line">
                <div></div>
                <div>OU</div>
                <div></div>
            </div>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input required maxlength="75" placeholder="Telefone, nome de usuario ou email"
            name="email" type="text" id="email" >
            <label class="label-error">{!! session()->get('error_email') !!}</label>

        </div>

        <div class="form-group">
            <label for="lb">Nome completo</label>
            <input required  maxlength="75" placeholder="Nome completo"
            name="nameComplete" type="text" id="name-complete" >
        </div>

        <div class="form-group">
            <label for="user">Nome de usuario</label>
            <input required   maxlength="75" placeholder="Nome de usuario"
            name="user" type="text" id="user" >
            <label class="label-error">{!! session()->get('error_user') !!}</label>

        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input required minlength="8" maxlength="75" placeholder="Senha"
            name="password" type="password" id="password" >
        </div>
    
    
        <div>
            <button>Cadastre-se</button>
        </div>
     
        <span class="span">Ao se cadastrar, você concorda com nossos <a href="">Termos, Política de Dados e Política de Cookies.</a></span>
    </form>

    <div class="main-home--no-account">
        <span>Tem uma conta? <a href="/">Conecte-se</a></span>
    </div>

    <div class="main-home--app">
        <span>Obtenha o aplicativo.</span>
        <div class="bola">
            <img src="/assets/icon-app-store.png" alt="icon-app-store"/>
            <img src="/assets/icon-google-play.png" alt="icon-google-play"/>
        </div>
    </div>
    @endif
    
</div>
</main>
@endsection

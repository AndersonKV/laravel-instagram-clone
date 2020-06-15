@extends('layouts.app')

@include('layouts.template.header')

@section('content')

<main class="main__edit">

    <article class="main__edit--left">
        <aside>
            <div>Editar perfil</div>
            <div>Alterar senha</div>
            <div>Aplicativos e sites</div>
            <div>Email e SMS</div>
            <div>Notificações e push</div>
            <div>Gerenciar contatos</div>
            <div>Privacidade e segurança</div>
            <div>Atividade de login</div>
            <div>Emails do Instagram</div>
        </aside>
    </article>

    <article class="main__edit--right">
        <div class="main__edit--right__content">
            <aside>
                <button class="btn-form">
                    <img class="avatar" src="{{ url('storage/upload/'.Auth::user()->image) }}"/>
                </button>
            </aside>
            <div class="my-title">
                <h2>{{Auth::user()->user}}</h2>
                <div class="my-custom-input">
                    <form id="upload" action="{{ route('uploadUser') }}" method="post" enctype="multipart/form-data">
                        {!! csrf_field() !!}
                        <div class="input-file-container">  
                          <input class="input-file" id="my-file" type="file" name="image">
                          <label tabindex="0" for="my-file" class="input-file-trigger">Alterar foto do perfil</label>
                        </div>
                        <p class="file-return"></p>
                      </form>
                </div>
            </div>
        </div>
        <div class="main__edit--right__content">
            <aside>
                <span>Nome</span>
            </aside>
            <div>
                <input aria-required="false" type="text" value="">
            </div>
        </div>
        <div class="main__edit--right__content">
            <aside>
                <span>Nome de usuário</span>
            </aside>
            <div>
            <input aria-required="false" type="text" value="{{Auth::user()->user}}">
            </div>
        </div>
        <div class="main__edit--right__content">
            <aside>
                <span>Site</span>
            </aside>
            <div>
            <input aria-required="false" type="text" value="">
            </div>
        </div>
        <div class="main__edit--right__content">
            <aside>
                <span>Biografia</span>
            </aside>
            <div>
                <textarea class="form-control" rows="8" style="resize: none"></textarea>
            </div>
        </div>
        <div class="main__edit--right__content">
            <aside>
                <span></span>
            </aside>
            <div>
                <span class="dark-gray">Informações pessoais</span>
                <span class="gray">Forneça suas informações pessoais, mesmo se a conta for usada para uma empresa, um animal de estimação ou outra coisa. Elas não farão parte do seu perfil público.</span>
             </div>
        </div>
        <div class="main__edit--right__content">
            <aside>
                <span>Email</span>
            </aside>
            <div>
            <input aria-required="false" type="text" value="{{Auth::user()->email}}">
            </div>
        </div>
        <div class="main__edit--right__content">
            <aside>
                <span>Telefone</span>
            </aside>
            <div>
            <input aria-required="false" type="text" value="">
            </div>
        </div>
        <div class="main__edit--right__content">
            <aside>
                <span>Gênero</span>
            </aside>
            <div>
            <input aria-required="false" type="text" value="Gênero">
            </div>
        </div>
        <div  class="main__edit--right__content--button">
            <button>Enviar</button>
        </div>
    </article>
   
</main>
@endsection

<script src="{{url('js/main-edit.js')}}"></script>


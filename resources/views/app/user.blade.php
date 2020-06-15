@extends('layouts.app')

@include('layouts.template.header')

@section('content')
 

@if ($user_not_found == true)  

@include('layouts.template.user_not_found')

@else

<a href="/accounts/logout">sair</a>
<header class="header__user">
    <div class="header__user--left">
        <div>
            <img class="avatar" src="{{ url('storage/upload/'.$user['image']) }}"/>
        </div>
    </div>
    <section class="header__user--right">
        <div class="header__user--right__top">

            <div>
                <h2 class="title-user" id="{{$user['id']}}">{{ $user['user'] }}</h2>
            </div>
            
            @if (Auth::user())
                @if (Auth::user()->id == $user['id'])
                <div class="my-btn">
                <a href="/accounts/edit">
                    <button class="header__btn-white">Editar perfil</button>
                </a>
                <button class="header__btn-white"><i class="fas fa-cog"></i></button>   
                </div>
                @endif
            @endif
           
            @if (Auth::user())
                @if ($checked === true)
                <div class="my-btn">
                <form action="{{ route('unfollowing') }}" method="post" >
                    {!! csrf_field() !!}
                    <input name="name" value="{{$user['user']}}" type="hidden">
                    <button type="submit" class="btn-white">Seguindo</button>
                </form>
                 <button class="btn-following">
                    <i class="fas fa-user-check"></i>
                </button>
                </div>
                @endif  
            @endif

            @if (Auth::user())
                @if ($checked == false && Auth::user()->id != $user['id'])
                <div class="my-btn">
                <form action="{{ route('following') }}" method="post" >
                    {!! csrf_field() !!}
                    <input name="name" value="{{$user['user']}}" type="hidden">
                    <button type="submit">Seguir</button>
                </form>
                <button>
                    <i class="fas fa-caret-down"></i>
                </button>
                </div>
                @endif
            @endif

            @if (!Auth::user())
                <div>
                <a href="/accounts/emailsignup">
                    <button type="submit">Seguir</button>
                </a>
                <button>
                    <i class="fas fa-caret-down"></i>
                </button>
                </div>
            @endif
         
         </div>
         <div class="header__user--right__middle ajax-ul">
            <span><b>{{$count_posts}}</b> publicações</span>
            <span class="seguidores"><b>{{($followers)}}</b> seguidores</span>
            <span class="seguindo"><b>{{($followings)}}</b> seguindo</span>
         </div>
             
        <div class="ajax-follows z-index-1">
            <div class="boxing visibility">
                
            </div>
        </div>
        <div class="header__user--right__bottom">
            <span> </span>
        </div>
    </section>
</header>

<div class="mural__user--middle">
    <span>Publicações</span>
    <span>Marcações</span>
</div>  

<div class="mural__user">
    @if($posts) 
    <article class="mural__user--found">
        @foreach ($posts as $item)
        <div class="mural__user--photo">    
        <a href="/{{$item['name_user']}}/p/{{$item['link_post']}}">
            <img class="" src="{{ url('storage/upload/'.$item['image']) }}"/>
        </a>
                  <ul class="mural__user--photo__count">

                    @if (count($item['likes']) != null)
                        <li><i class="fa fa-heart"></i> {{count($item['likes'])}}</li>
                    @endif

                    @if (count($item['comment']) != null)
                        <li><i class="far fa-comment"></i> {{count($item['comment'])}}</li>
                    @endif

                  </ul>
         </div> 
        @endforeach      
    </article>
    @else
    <article class="mural__user--not-found">
        <div>
            <i class="fas fa-camera"></i>
        </div>
    </article>
    @endif
 </div>

 @include('layouts.template.footer')
 
@endif


@endsection
<script type="text/javascript" src="{{ asset('js/main-user.js') }}"></script>

 
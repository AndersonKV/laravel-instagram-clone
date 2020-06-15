<header class="header">
    <main>
        <div class="header__img">
            @if (Auth::check() === true)
                <a href="/" class="auth-icon"><img src="/assets/header-title.png"/></a>
                <div class="header__icon-post">
                    <a href="/post"><i class="iconbtn fas fa-camera"></i></a>
                </div>
            @else
                <a href="/" class="icon"><img src="/assets/header-title.png"/></a>
            @endif
       
        </div>
        <div class="header__input">    
            <form name="formlogin" role="search" id="search-form" onsubmit="return false"> 
                <input type="hidden" id="token" value="{{ csrf_token() }}">
               <div class="input-group">
                   <input type="text" disabled class="form-control" name="pesquisar" placeholder="Search users"> 
                </div>
                <button class="btn none" type="submit"></button>
             </form>      
        </div>

        @if (Auth::check() === true)
        <div class="header__group-icon">
            <span>
                <a href="/accounts/logout"><i class="fas fa-home"></i></a>
            </span>
            <span>
                <a href="/"><i class="far fa-paper-plane"></i></a>
            </span>
            <span><a href="/explore"><i class="fab fa-bandcamp"></i></a></span>
            <span><a href="/"><i class="far fa-heart"></i></a></span>
            <div class="header__group_img">
                <a href="/{{Auth::user()->user}}">
                    <img src="{{ url('storage/upload/'.Auth::user()->image) }}"/>
                </a>
            </div> 
        </div>
        @else 
        <div class="header__group-icon">
            <div class="header__group--btn">
                <button><a href="/">Entrar</a></button>
                <button><a href="/accounts/emailsignup">Cadastrar</a></button>
            </div>
        </div>
        @endif
       
    </main>
</header>

<div class="container-ajax z-index-1">
    <div class="boxing visibility">
       
    </div>
</div>
 
<script type="text/javascript"  src="{{url('js/main-header.js')}}"></script>
 
 
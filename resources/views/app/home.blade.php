@extends('layouts.app')

@include('layouts.template.header')

@section('content')

<section class="section__home">
    <div class="section__home--left">
 
        @if ($posts != null)  
        @foreach ($posts as $item)

    <div class="section__home--left__post" id="{{$item['id']}}">
            <div class="section__home--left__post--name">   
                <div>
                    <img class="avatar" src="{{ url('storage/upload/'.$item['image_perfil']) }}"/>
                </div>    
                <div>  
                    <a href="/{{$item['name_user']}}" class="title-user" id="{{$item['id']}}">{{$item['name_user']}}</a>
                </div>    
                <div>    
                    <span><i class="fas fa-ellipsis-h"></i></span>   
                </div>    
            </div>
            <div class="section__home--left__post--content like-img">
                <div class="container-img">
                    <img  src="{{ url('storage/upload/'.$item['image']) }}"/>
                </div>
                 
                <div class="section__home--left__post--content__icons">
                    <div class="list-icon">
                        <div class="first">
                        @if ($item['liked'] == true)
                            <span class="like"><i class="fa fa-heart  " aria-hidden="true"></i></span>
                        @else
                            <span class="not-like"><i class="far fa-heart  " aria-hidden="true"></i></span>
                        @endif
                     
                        <span><i class="far fa-comment"></i></span>
                        <span><i class="far fa-paper-plane"></i></span>
                        </div>
                     </div>
                     <div><span><i class="far fa-bookmark"></i></span></div>
                </div>
                <div class="count-likes">


                    
                @if ($item['likes'] != null)  
                    @foreach($item['likes'] as $userLike)
    
                        @if ($loop->first)
                        <span>Curtido por <b><a href="/{{$userLike['user']}}">{{$userLike['user']}}</a></b> e outras <b class="get-likes" id="{{$item['id']}}">{{count($item['likes'])}} pessoas</b></span>

                        <div class="container-ajax-{{$item['id']}} z-index-1 container-ajax-likes ">
                            <div class="boxing visibility">
                             </div>
                        </div>
                        @endif  
                    @endforeach
                @endif  

        
                 </div>

                <div class="section__home--left__post--content__details">
                    <div class="section__home--left__post--content__details--user">
                        <p><a href="" class="user">{{$item['name_user']}} </a><?php echo $item['post']?>  </p>
                    </div>
                 

                @if ($item['comment'] != null)  

                   @foreach ($item['comment'] as $commentarys)
                    <div class="section__home--left__post--content__details--other-user">
                        <p><a href="{{$commentarys['user']}}" class="user">{{$commentarys['user']}} </a>  <?php echo $commentarys['comment']?>
                            <small>{{$commentarys['data']}}</small>    
                        </p> 
                    </div>
                    @endforeach   

                @endif  
                    
                </div>
                <div class="section__home--left__post--content__add-comment">
                    <div>         
                        <form action="{{ route('handleMessage') }}" method="post"  name="addcategory_form">
                            {!! csrf_field() !!}
                           <textarea 
                                aria-label="Adicione um comentário..." 
                                placeholder="Adicione um comentário..." 
                                autocomplete="off" 
                                autocorrect="off"
                                style="resize: none"
                                name="message"
                               
                                 >
                            </textarea>  

                            <input name="post_id" value="{{$item['id']}}" type="hidden">

                            <button  type="submit">Publicar</button>
                        </form>
                        
                    </div>
                </div>
            </div>
    </div>
        @endforeach
        @else
        
        @endif
        

    </div>

    <div class="section__home--right">
        <div class="section__home--right__top">
            <div>
                <img class="avatar" src="{{ url('storage/upload/'.Auth::user()->image) }}"/>
            </div>
            <div>
                <a href="{{Auth::user()->user}}">{{Auth::user()->user}}</a>
            </div>
        </div>
         {{-- <div class="section__home--right__middle">
           
        </div> --}}
        <div class="section__home--right__bottom">
             <div class="span">
                <span>Sugestões para você</span>
                <span>Ver tudo</span>
            </div>
 

            @if ($sort != null)
                @foreach ($sort as $item)
                <div class="suggestion">
                    <img class="avatar" src="{{ url('storage/upload/'.$item['img']) }}"/>
                    <a href="/{{$item['user']}}">{{$item['user']}}</a>
                </div>
                @endforeach 
            @else
                <br>
                <span class="one-user">Apenas um usuario registrado</span>
            @endif
              
         </div>  
    </div>
</section>

 
@endsection

<script src="js/main-home.js"></script>




 
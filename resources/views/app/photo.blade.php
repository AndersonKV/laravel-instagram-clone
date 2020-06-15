@extends('layouts.app')
 
@include('layouts.template.header')

@section('content')

<section class="section__photo">
    <div class="section__photo--left like-img hasLiked">
        <img class="post-image img-id" id="{{$post['image']}}" src="{{ url('storage/upload/'.$post['image']) }}"/>
    </div>
    <div class="section__photo--right">
        <div class="details-user">
            <img class="avatar" src="{{ url('storage/upload/'.$post['image_perfil']) }}"/>
            <a href="/{{$post['name_user']}}" class="title-user" id="{{$post['id']}}">{{$post['name_user']}}</a>
        </div>
        <div class="section-comments">
              <div class="inline">
                 <div class="section__photo--users">
                    <div>
                        <img class="avatar" src="{{ url('storage/upload/'.$post['image_perfil']) }}"/>
                    </div>
                    <div>
                         <a class="user" href="/{{$post['name_user']}}">{{$post['name_user']}}</a>
                        <p class="links"><?php echo $post['post']?> </p>    
                    </div>
                </div>

                @if ($post['comment'] != null)  

                @foreach ($post['comment'] as $commentarys)

                <div class="section__photo--users">
                    <div>
                        <img class="avatar" src="{{ url('storage/upload/'.$commentarys['image']) }}"/>
                    </div>

                    <div>
                        <a class="user" href="/{{$commentarys['user']}}">{{$commentarys['user']}}</a>
                        <p class="bg-blue links">
                            <?php echo $commentarys['comment']?>   
                        </p>  
                                                        
                   
                    <small>{{$commentarys['data']}}</small>    
                    
                    </div>
                </div>
                @endforeach

            </div> 
            @endif  
         </div>

        <div class="details">
            <div class="list-icon">
                <div class="first">
                    
                    @if($like == true)
                        <span class="like"><i class="fa fa-heart  " aria-hidden="true"></i></span>
                    @else
                        <span class="not-like"><i class="far fa-heart  " aria-hidden="true"></i></span>
                    @endif

                    <span><i class="far fa-comment"></i></span>
                    <span><i class="far fa-paper-plane"></i></span>
                </div>
                <div>
                    <span><i class="far fa-bookmark"></i></span>
                </div>
            </div>
            <div class="count-likes">
 
                @if ($post['likes'] != null)  
                    @foreach($post['likes'] as $userLike)
    
                        @if ($loop->first)
                        <span>Curtido por <b><a href="/{{$userLike['user']}}">{{$userLike['user']}}</a></b> e outras <b class="get-likes">{{count($post['likes'])}} pessoas</b></span>

                        <div class="container-ajax-likes z-index-1">
                            <div class="boxing visibility">
                             </div>
                        </div>
                        @endif  
                    @endforeach
                @endif  

            </div>
        </div>  
        <div class="details-add-comments">  

            @if (Auth::user() != null)
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

                <input name="post_id" value="{{$post['id']}}" type="hidden">
                
                <button  type="submit">Publicar</button>

            </form>  
            @endif     
                  
        </div>
    </div>
</section>
 
@include('layouts.template.footer')

@endsection 

<script type="text/javascript" src="{{ asset('js/main-photo.js') }}"></script>


 
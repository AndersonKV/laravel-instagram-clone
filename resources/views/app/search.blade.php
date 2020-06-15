@extends('layouts.app')
@include('layouts.template.header')
@section('content')
 
<main class="main__search">
    @if($post)
    <div class="details">
        <h1>#{{$word}}</h1>
        <h5><b>{{count($post)}} publicações</b></h5>
    </div> 
    
    <article class="mural__search">
        @foreach ($post as $item)
        <div class="mural__search--photo">    
            <a href="/{{$item['name_user']}}/p/{{$item['link_post']}}">
                <img class="" src="{{ url('storage/upload/'.$item['image']) }}"/>
            </a>      
        </div> 
        @endforeach 
    </article> 
    @endif 
             
  
</main>

@endsection 

<script type="text/javascript" src="{{ asset('js/main-explore.js') }}"></script>

 

 
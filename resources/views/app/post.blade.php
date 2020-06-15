@extends('layouts.app')

@include('layouts.template.header')

@section('content')

<main class="main__post">
  <section class="main__post--form-section">
    <form action="{{ route('handleSubmit') }}" method="post" enctype="multipart/form-data">
      {!! csrf_field() !!}
      <textarea aria-label="Adicione um comentário..." name="post" required
        placeholder="Adicione um comentário..." autocomplete="off" autocorrect="off"
        style="resize: none">
      </textarea>
      <div class="input-file-container">
   
        <input class="input-file" id="my-file"   
            type="file" name="image[]"  />
            
        <label tabindex="0" for="my-file" class="input-file-trigger">
           <i class="iconbtn fas fa-camera"></i>
            Alterar foto do perfil
        </label>
      </div>
      <p class="file-return"></p>

      <button type="submit" class="btn-login">Login</button>

    </form>
  </section>   

 
 
  
</main>
 
@endsection
 

  <script type="text/javascript" src="{{ asset('js/main-post.js') }}"></script>


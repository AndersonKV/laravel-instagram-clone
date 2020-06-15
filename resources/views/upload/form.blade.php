<form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="arquivo">

    <button type="submit">Enviar arquivo</button>
</form>
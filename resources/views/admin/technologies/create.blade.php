@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary py-5">AGGIUNGI LA TUA TECNOLOGIA</h1>

    <form action="{{route('admin.technologies.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label text-primary">Nome della Tecnologia</label>
            <input type="text" class="form-control @error('type') is-invalid @enderror " id="type" name="type" value='{{old('type')}}'>
            @error('type')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary my-5">Salva</button>
            <a href="{{route('admin.technologies.index')}}" class="btn btn-primary my-5 mx-2">Torna alla Home</a>
        </div>

    </form>
</div>
@endsection
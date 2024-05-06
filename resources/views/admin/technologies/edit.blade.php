@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary py-5">MODIFICA IL TUO PROGETTO</h1>

    <form action="{{route('admin.technologies.update', $technology->id)}}" method="POST" enctype="multipart/form-data">
        @csrf

        @method('PUT')

        <div class="mb-3">
            <label for="type" class="form-label text-primary">Nome della tecnologia</label>
            <input type="text" class="form-control @error('type') is-invalid @enderror " id="type" name="type" value='{{old('type') ?? $technology->type}}'>
            @error('type')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary my-5">Salva</button>
            <a href="{{route('admin.technologies.show', $technology->id)}}" class="btn btn-primary my-5 mx-2">Torna indietro</a>
        </div>

    </form>
</div>
@endsection
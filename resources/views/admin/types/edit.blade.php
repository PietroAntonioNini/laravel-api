@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary py-5">MODIFICA LA TUA CATEGORIA </h1>

    <form action="{{route('admin.types.update', $type->id)}}" method="POST" enctype="multipart/form-data">
        @csrf

        @method('PUT')

        <div class="mb-3">
            <label for="type" class="form-label text-primary">Nome della Categoria</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name" value='{{old('name') ?? $type->name}}'>
            @error('name')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="type" class="form-label text-primary">Descrizione</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror " id="description" name="description" value='{{old('description') ?? $type->description}}'>
            @error('description')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary my-5">Salva</button>
            <a href="{{route('admin.types.show', $type->id)}}" class="btn btn-primary my-5 mx-2">Torna indietro</a>
        </div>

    </form>
</div>
@endsection
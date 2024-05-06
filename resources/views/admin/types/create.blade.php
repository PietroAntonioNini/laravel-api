@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary py-5">AGGIUNGI LA TUA TECNOLOGIA</h1>

    <form action="{{route('admin.types.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label text-primary">Nome della Categoria</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name" value='{{old('name')}}'>
            @error('name')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label text-primary">Descrizione</label>
            <input type="text" class="form-control @error('description') is-invalid @enderror " id="description" name="description" value='{{old('description')}}'>
            @error('description')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary my-5">Salva</button>
            <a href="{{route('admin.types.index')}}" class="btn btn-primary my-5 mx-2">Torna alla Home</a>
        </div>

    </form>
</div>
@endsection
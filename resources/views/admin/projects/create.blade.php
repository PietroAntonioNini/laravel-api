@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-primary py-5">AGGIUNGI IL TUO PROGETTO</h1>

    <form action="{{route('admin.projects.store')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label text-primary">Nome del progetto</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror " id="name" name="name" value='{{old('name')}}'>
            @error('name')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label text-primary">Descrizione</label>
            <textarea type="text" class="form-control  @error('description') is-invalid @enderror " id="description" name="description">{{old('description')}}</textarea>
            @error('description')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label text-primary">Immagine</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" value=''>
            @error('image')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror

        </div>


        <div class="mb-3">
            <label for="technologies" class="form-label text-primary">Tecnologie</label>
            <div class="d-flex gap-4">
                @foreach($technologies as $technology)
                    <div class="form-check ">
                        <input 
                            type="checkbox" 
                            name="technologies[]"
                            value="{{$technology->id}}" 
                            class="form-check-input" 
                            id="tag-{{$technology->id}}"
                            {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}

                        > 
                        
                        <label for="tag-{{$technology->id}}" class="form-check-label">{{$technology->type}}</label>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mb-3">
            <label for="type_id" class="form-label text-primary">Categoria</label>
            <select class="form-select" name="type_id" id="type_id">
                
                <option value=""></option>

                @foreach ($types as $type)
                <option value="{{$type->id}}" {{ $type->id == old('type_id') ? 'selected' : '' }}>{{ $type->name }}</option>
                @endforeach

            </select>
        </div>

        <div class="mb-3">
            <label for="link_GitHub" class="form-label text-primary">Link di GitHub</label>
            <input type="text" class="form-control  @error('link_GitHub') is-invalid @enderror " id="link_GitHub" name="link_GitHub" value='{{old('link_GitHub')}}'>
            @error('link_GitHub')
                <div class="invalid-feedback ">
                    {{$message}}
                </div>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary my-5">Salva</button>
            <a href="{{route('admin.projects.index')}}" class="btn btn-primary my-5 mx-2">Torna alla Home</a>
        </div>

    </form>
</div> 
@endsection
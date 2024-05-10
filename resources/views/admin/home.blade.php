@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h1>Bentornato {{$name}}</h1> 
        <p>cosa vuoi fare oggi?</p>

        <a href="{{route('admin.projects.index')}}" class="btn btn-primary my-5 mx-2">Vai ai progetti</a>

        <a href="{{route('admin.technologies.index')}}" class="btn btn-primary my-5 mx-2">Vai alle tecnologie</a>

        <a href="{{route('admin.types.index')}}" class="btn btn-primary my-5 mx-2">Vai alle Categorie</a>
    </div>
    

@endsection
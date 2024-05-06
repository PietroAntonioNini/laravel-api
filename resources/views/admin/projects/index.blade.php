@extends('layouts.app')

@section('content')

    <div class="container d-flex flex-column align-items-center ">
        <div class="w-100 py-5 d-flex justify-content-between ">
            <h1 class="py-5 text-primary">I MIEI PROGETTI</h1>
            <div class="col-2">
                <a href="{{url('admin')}}" class="btn btn-primary my-5 mx-2">Vai alla Home</a>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-4">
            @foreach ($projects as $project)
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('storage/' . $project->image)}}" class="card-img-top" alt="@">
                    <div class="card-body">
                        <h5 class="card-title">{{$project->name}}</h5>
                        <p class="card-text">{{$project->description}}</p>
                        <a href="{{route('admin.projects.show', $project)}}" class="btn btn-primary">INFO</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="w-100 py-5">
            <a href="{{route('admin.projects.create')}}" class="btn btn-primary">AGGIUNGI UN NUOVO PROGETTO</a>
        </div>
    </div>

    
@endsection
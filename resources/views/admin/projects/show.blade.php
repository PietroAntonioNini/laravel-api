@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row d-flex justify-content-between ">
        <div class="col-8">
            <h1 class="py-5 text-primary ">{{$project->name}}</h1>
        </div>
        <div class="col-4">
            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Elimina
            </button>

            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered ">
                  <div class="modal-content">
        
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Elimina il Comics</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
        
                    <div class="modal-body">
                      Sei sicuro che vuoi eliminare il comics "{{$project->name}}"
                    </div>
        
        
                    <div class="modal-footer">
        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <form action="{{route('admin.projects.destroy', $project->id)}}" method="POST">
                            @csrf
                            @method("DELETE")
                            
                            <button class="btn btn-danger">Elimina</button>
                        </form>
        
                    </div>
        
                  </div>
                </div>
            </div>

            <a href="{{route('admin.projects.edit', $project)}}" class="btn btn-warning mx-2">Modifica</a>

            <a href="{{route('admin.projects.index')}}" class="btn btn-primary my-5 text-center ">Torna alla Home</a>
        </div>
    </div>

    <div class="row w-100">
        <div class="col-5">
            <img src="{{ asset('storage/' . $project->image)}}" style="width: 450px; height: 500px;" alt="">
        </div>
        <div class="col-7">
            <p><strong class="text-primary">Descrizione :</strong><br> {{$project->description}}</p>
            @if ($project->type?->name)
            <p><strong class="text-primary">Categoria :</strong><br> {{ $project->type?->name }}</p>
            @endif
            <p class="my-2"><strong class="text-primary">Tecnologie :</strong></p>
            <div class="d-flex gap-2 mb-5">
                @foreach ($project?->technologies as $technology)
                <span class="badge rounded-pill bg-primary ">{{$technology->type}}</span>
                @endforeach
            </div>
            <a href="{{$project->link_GitHub}}" class="btn btn-primary my-5 text-center ">link di GitHub</a>
            
        </div>
    </div>
    
</div>

@endsection
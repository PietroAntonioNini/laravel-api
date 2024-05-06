@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-flex justify-content-between ">
        <div class="col-8">
            <h1 class="py-5 text-primary ">TECNOLOGIA</h1>
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
                      Sei sicuro che vuoi eliminare questa Categoria? "{{$type->name}}"
                    </div>
        
        
                    <div class="modal-footer">
        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                        <form action="{{route('admin.types.destroy', $type->id)}}" method="POST">
                            @csrf
                            @method("DELETE")
                            
                            <button class="btn btn-danger">Elimina</button>
                        </form>
        
                    </div>
        
                  </div>
                </div>
            </div>

            <a href="{{route('admin.types.edit', $type->id)}}" class="btn btn-warning mx-2">Modifica</a>

            <a href="{{route('admin.types.index')}}" class="btn btn-primary my-5 text-center ">Torna alla Home</a>
        </div>
    </div>

    <div class="row w-100">
        <div class="col-5 border border-secondary rounded-3 p-4">
            <h1 style='font-size: 50px;'>{{$type->name}}</h1>
        </div>
        <div class="col-7">
            @if ($type?->description )
            <p><strong class="text-primary">Descrizione :</strong><br> {{ $type?->description }}</p>
            @endif            
        </div>
    </div>
    
</div>
@endsection
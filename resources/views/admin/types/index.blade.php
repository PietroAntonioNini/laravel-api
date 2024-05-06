@extends('layouts.app')

@section('content')

    <div class="container d-flex flex-column align-items-center ">
        <div class="w-100 py-5 d-flex justify-content-between ">
            <h1 class="py-5 text-primary">LE MIE CATEGORIE</h1>
            <div class="col-2">
                <a href="{{url('admin')}}" class="btn btn-primary my-5 mx-2">Vai alla Home</a>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-4">
            @foreach ($types as $type)
                <div class="card" style="width: 18rem; height: 8rem;">
                    <div class="card-body position-relative ">
                        <h4 class="card-title">{{$type->name}}</h5>
                        <p class="card-text">{{$type->description}}</p>
                        
                        <a href="{{route('admin.types.show', $type->id)}}" class=" btn btn-primary position-absolute" style='bottom: 5px; right: 5px;'>INFO</a>
                    
                    </div>
                </div>
            @endforeach
        </div>

        <div class="w-100 py-5">
            <a href="{{route('admin.types.create')}}" class="btn btn-primary">AGGIUNGI UNA NUOVA CATEGORIA</a>
        </div>
    </div>

@endsection
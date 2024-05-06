@extends('layouts.app')

@section('content')

    <div class="container d-flex flex-column align-items-center ">
        <div class="w-100 py-5 d-flex justify-content-between ">
            <h1 class="py-5 text-primary">LE MIE TECNOLOGIE</h1>
            <div class="col-2">
                <a href="{{url('admin')}}" class="btn btn-primary my-5 mx-2">Vai alla Home</a>
            </div>
        </div>

        <div class="d-flex flex-wrap gap-4">
            @foreach ($technologies as $technology)
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h1 class="card-title">{{$technology->type}}</h5>

                        <div class="col text-end ">
                            <a href="{{route('admin.technologies.show', $technology->id)}}" class=" btn btn-primary">INFO</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="w-100 py-5">
            <a href="{{route('admin.technologies.create')}}" class="btn btn-primary">AGGIUNGI UNA NUOVA TECNOLOGIA</a>
        </div>
    </div>

@endsection
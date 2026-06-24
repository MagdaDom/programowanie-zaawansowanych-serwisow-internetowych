@extends('main')

@php
    $title = 'Internal Events';
@endphp

@section('menu')
    <a href="/internal-events/create" class="btn btn-success">
        Add
    </a>
@endsection

@section('content')
<div class="container">
    <div class="row g-3">
        @foreach($models as $event)
            <div class="col-sm-12 col-md-6 col-lg-4" id="model-card-{{$event->Id}}">
                <div class="card h-100">
                    <div class="card-body">
                        <p class="card-title h5"> {{$event->Title}}</p>
                        <p><strong>{{$event->ShortDescription}}</strong></p>
                        {!! $event->ContentHTML !!}
                    </div>
                    <div class="card-footer">
                        <a href="/internal-events/edit/{{$event->Id}}" class="btn btn-primary">Edit</a>
                        <a href="/internal-events/delete/{{ $event->Id }}" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

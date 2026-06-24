@extends('main')

@section('content')
<div class="container">
    <div class="row g-3">
        @foreach($models as $event)
            <div class="col-sm-12 col-md-6 col-lg-4" id="model-card-{{$event->Id}}">
                <div class="card h-100">
                    <div class="card-body">
                        <p class="card-title h5"> {{$event->Title}}</p>
                        <p><strong>{{$event->ShortDescription}}</strong></p>
                        {{$event->ContentHTML}}
                    </div>
                    <div class="card-footer">
                        <a href="/internal-events/edit/{{$event->Id}}" class="btn btn-primary">Edit</a>
                        <a class="btn btn-danger delete-button" data-id="{{$event->Id}}" onclick="del(this)">Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

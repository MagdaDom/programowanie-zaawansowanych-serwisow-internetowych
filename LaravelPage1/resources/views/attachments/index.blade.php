@extends('main')

@section('menu')
    <a href="/attachments/create" class="btn btn-primary">Create new</a>
    <a href="/attachments" class="btn btn-primary">All</a>
@endsection

@section('content')
<div class="container">
    <div class="row g-3">
        @foreach($models as $attachment)
            <div class="col-sm-12 col-md-6 col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <p class="card-title h5">{{ $attachment->Title }}</p>
                        <p>{{ $attachment->Link }}</p>
                        {!! $attachment->ContentHTML !!}
                        <p>{{ $attachment->Notes }}</p>
                    </div>
                    <div class="card-footer">
                        <a href="/attachments/edit/{{ $attachment->Id }}" class="btn btn-primary">Edit</a>
                        <a href="/attachments/delete/{{ $attachment->Id }}" class="btn btn-danger">Delete</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
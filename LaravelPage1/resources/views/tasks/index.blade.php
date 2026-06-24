@extends('main')

@section('menu')
    <a href="/tasks/create" class="btn btn-primary">Create new</a>
    <a href="/tasks" class="btn btn-primary">All</a>
@endsection

@section('content')
<div class="container">
    <div class="row g-3">

        @foreach($models as $task)
            <div class="col-md-6">

                <div class="card">
                    <div class="card-body">

                        <h5>{{ $task->Title }}</h5>

                        <p>
                            <strong>Internal Event:</strong>
                            {{ $task->InternalEvent->Title }}
                        </p>

                        <p>
                            <strong>Start:</strong>
                            {{ $task->StartDateTime }}
                        </p>

                        <p>
                            <strong>Deadline:</strong>
                            {{ $task->Deadline }}
                        </p>

                        <p>
                            <strong>Status:</strong>
                            {{ $task->IsDone ? 'Done' : 'Not done' }}
                        </p>

                        <p>{{ $task->Description }}</p>

                    </div>

                    <div class="card-footer">
                        <a href="/tasks/edit/{{ $task->Id }}" class="btn btn-primary">
                            Edit
                        </a>

                        <a href="/tasks/delete/{{ $task->Id }}" class="btn btn-danger">
                            Delete
                        </a>
                    </div>

                </div>

            </div>
        @endforeach

    </div>
</div>
@endsection
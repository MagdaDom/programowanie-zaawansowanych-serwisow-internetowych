@extends('main')

@section('menu')
    <a href="/tasks/create" class="btn btn-primary">Create new</a>
    <a href="/tasks" class="btn btn-primary">All</a>
@endsection

@section('content')
<div class="container">

    <form method="POST" action="/tasks/update/{{ $model->Id }}">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input
                name="Title"
                class="form-control"
                value="{{ $model->Title }}"
            >
        </div>

        <div class="mb-3">
            <label>Internal Event</label>

            <select
                name="InternalEventId"
                class="form-control"
            >
                @foreach($internalEvents as $event)
                    <option
                        value="{{ $event->Id }}"
                        {{ $model->InternalEventId == $event->Id ? 'selected' : '' }}
                    >
                        {{ $event->Title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Start</label>
            <input
                type="datetime-local"
                name="StartDateTime"
                value="{{ $model->StartDateTime }}"
                class="form-control"
            >
        </div>

        <div class="mb-3">
            <label>Deadline</label>
            <input
                type="datetime-local"
                name="Deadline"
                value="{{ $model->Deadline }}"
                class="form-control"
            >
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea
                name="Description"
                class="form-control"
            >{{ $model->Description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea
                name="Notes"
                class="form-control"
            >{{ $model->Notes }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input
                type="checkbox"
                name="IsDone"
                value="1"
                class="form-check-input"
                {{ $model->IsDone ? 'checked' : '' }}
            >

            <label class="form-check-label">
                Done
            </label>
        </div>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Edit
        </button>

    </form>

</div>
@endsection
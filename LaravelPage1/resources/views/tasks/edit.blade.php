@extends('main')

@section('menu')
    <a href="/tasks/create" class="btn btn-primary">Create new</a>
    <a href="/tasks" class="btn btn-primary">All</a>
@endsection

@section('content')
<div class="container">

    <form method="POST" action="/tasks/update/{{ $model->Id }}">
        @csrf

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Title</label>

            <input
                name="Title"
                class="form-control"
                value="{{ old('Title', $model->Title) }}"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Internal Event</label>

            <select name="InternalEventId" class="form-control">
                @foreach($internalEvents as $event)
                    <option
                        value="{{ $event->Id }}"
                        {{ old('InternalEventId', $model->InternalEventId) == $event->Id ? 'selected' : '' }}
                    >
                        {{ $event->Title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Start Date</label>

            <input
                type="datetime-local"
                name="StartDateTime"
                value="{{ old('StartDateTime', date('Y-m-d\TH:i', strtotime($model->StartDateTime))) }}"
                class="form-control"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Deadline</label>

            <input
                type="datetime-local"
                name="Deadline"
                value="{{ old('Deadline', date('Y-m-d\TH:i', strtotime($model->Deadline))) }}"
                class="form-control"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>

            <textarea
                name="Description"
                class="form-control"
                rows="4"
            >{{ old('Description', $model->Description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>

            <textarea
                name="Notes"
                class="form-control"
                rows="3"
            >{{ old('Notes', $model->Notes) }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input
                type="checkbox"
                name="IsDone"
                value="1"
                class="form-check-input"
                {{ old('IsDone', $model->IsDone) ? 'checked' : '' }}
            >

            <label class="form-check-label">
                Done
            </label>
        </div>

        <button type="submit" class="btn btn-primary">
            Edit
        </button>

    </form>

</div>
@endsection
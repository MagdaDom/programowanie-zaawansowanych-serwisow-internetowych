@extends('main')

@section('menu')
    <a href="/tasks/create" class="btn btn-primary">Create new</a>
    <a href="/tasks" class="btn btn-primary">All</a>
@endsection

@section('content')
<div class="container">

    <form method="POST" action="/tasks/add-to-db">
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
                value="{{ old('Title') }}"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Internal Event</label>

            <select name="InternalEventId" class="form-control">
                @foreach($internalEvents as $event)
                    <option
                        value="{{ $event->Id }}"
                        {{ old('InternalEventId') == $event->Id ? 'selected' : '' }}
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
                value="{{ old('StartDateTime') }}"
                class="form-control"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Deadline</label>

            <input
                type="datetime-local"
                name="Deadline"
                value="{{ old('Deadline') }}"
                class="form-control"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>

            <textarea
                name="Description"
                class="form-control"
                rows="4"
            >{{ old('Description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>

            <textarea
                name="Notes"
                class="form-control"
                rows="3"
            >{{ old('Notes') }}</textarea>
        </div>

        <div class="form-check mb-3">
            <input
                type="checkbox"
                name="IsDone"
                value="1"
                class="form-check-input"
                {{ old('IsDone') ? 'checked' : '' }}
            >

            <label class="form-check-label">
                Done
            </label>
        </div>

        <button type="submit" class="btn btn-primary">
            Create
        </button>

    </form>

</div>
@endsection
@extends('main')

@section('menu')
    <a href="/attachments/create" class="btn btn-primary">Create new</a>
    <a href="/attachments" class="btn btn-primary">All</a>
@endsection

@section('content')
<div class="container">
    <form method="POST" action="/attachments/update/{{ $model->Id }}">
        @csrf

        <input name="Title" class="form-control mb-2" value="{{ old('Title', $model->Title) }}">
        <input name="Link" class="form-control mb-2" value="{{ old('Link', $model->Link) }}">
        <textarea name="ContentHTML" class="form-control mb-2">{{ old('ContentHTML', $model->ContentHTML) }}</textarea>
        <textarea name="Notes" class="form-control mb-2">{{ old('Notes', $model->Notes) }}</textarea>

        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
</div>
@endsection
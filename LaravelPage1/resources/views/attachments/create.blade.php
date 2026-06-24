@extends('main')

@section('menu')
    <a href="/attachments/create" class="btn btn-primary">Create new</a>
    <a href="/attachments" class="btn btn-primary">All</a>
@endsection

@section('content')
<div class="container">
    <form method="POST" action="/attachments/add-to-db">
        @csrf

        <input name="Title" class="form-control mb-2" placeholder="Title" value="{{ old('Title') }}">
        <input name="Link" class="form-control mb-2" placeholder="Link" value="{{ old('Link') }}">
        <textarea name="ContentHTML" class="form-control mb-2" placeholder="ContentHTML">{{ old('ContentHTML') }}</textarea>
        <textarea name="Notes" class="form-control mb-2" placeholder="Notes">{{ old('Notes') }}</textarea>

        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
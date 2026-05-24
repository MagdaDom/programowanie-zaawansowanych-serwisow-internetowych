<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Events - Edit</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Internal Events - Edit</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('home.index') }}" class="btn btn-outline-dark">Strona główna</a>
            <a href="{{ route('internalevents.index') }}" class="btn btn-outline-secondary">All</a>
        </div>
    </div>

    <form method="POST" action="{{ route('internalevents.update', $internalEvent->Id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="Title" class="form-control" value="{{ old('Title', $internalEvent->Title) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Link</label>
            <input type="text" name="Link" class="form-control" value="{{ old('Link', $internalEvent->Link) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Is Public</label>
            <select name="IsPublic" class="form-select">
                <option value="1" {{ old('IsPublic', $internalEvent->IsPublic) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('IsPublic', $internalEvent->IsPublic) ? '' : 'selected' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Is Cancelled</label>
            <select name="IsCancelled" class="form-select">
                <option value="1" {{ old('IsCancelled', $internalEvent->IsCancelled) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('IsCancelled', $internalEvent->IsCancelled) ? '' : 'selected' }}>No</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Event Date Time</label>
            <input type="datetime-local" name="EventDateTime" class="form-control" value="{{ old('EventDateTime', optional($internalEvent->EventDateTime)->format('Y-m-d\\TH:i')) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Publish Date Time</label>
            <input type="datetime-local" name="PublishDateTime" class="form-control" value="{{ old('PublishDateTime', optional($internalEvent->PublishDateTime)->format('Y-m-d\\TH:i')) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Short Description</label>
            <input type="text" name="ShortDescription" class="form-control" value="{{ old('ShortDescription', $internalEvent->ShortDescription) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Content HTML</label>
            <textarea name="ContentHTML" class="form-control" rows="4">{{ old('ContentHTML', $internalEvent->ContentHTML) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Meta Description</label>
            <textarea name="MetaDescription" class="form-control" rows="2">{{ old('MetaDescription', $internalEvent->MetaDescription) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Meta Tags</label>
            <textarea name="MetaTags" class="form-control" rows="2">{{ old('MetaTags', $internalEvent->MetaTags) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="Notes" class="form-control" rows="3">{{ old('Notes', $internalEvent->Notes) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Is Active</label>
            <select name="IsActive" class="form-select">
                <option value="1" {{ old('IsActive', $internalEvent->IsActive) ? 'selected' : '' }}>Yes</option>
                <option value="0" {{ old('IsActive', $internalEvent->IsActive) ? '' : 'selected' }}>No</option>
            </select>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <a href="{{ route('internalevents.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </form>
</div>
</body>
</html>

@extends('main')

@section('header')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Edycja wydarzenia</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <a href="/internal-events" class="btn btn-primary">All</a>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="container">
        <form method="POST" action="{{ url()->current() }}">
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

            <div class="row gy-3">
                <div class="col-md-12 col-lg-6 col-xxl-4">
                    <label for="Title" class="form-label">
                        <i class="material-icons-round align-middle">label</i>
                        Title
                    </label>
                    <input
                        id="Title"
                        name="Title"
                        type="text"
                        value="{{ old('Title', $model->Title) }}"
                        class="form-control @error('Title') is-invalid @enderror"
                    >
                    @error('Title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 col-lg-6 col-xxl-4">
                    <label for="Link" class="form-label">
                        <i class="material-icons-round align-middle">link</i>
                        Link
                    </label>
                    <input
                        id="Link"
                        name="Link"
                        type="text"
                        value="{{ old('Link', $model->Link) }}"
                        class="form-control @error('Link') is-invalid @enderror"
                    >
                    @error('Link')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 col-lg-6 col-xxl-4">
                    <div class="form-check form-switch mt-4">
                        <input
                            id="IsPublic"
                            name="IsPublic"
                            type="checkbox"
                            value="1"
                            class="form-check-input @error('IsPublic') is-invalid @enderror"
                            {{ old('IsPublic', $model->IsPublic) ? 'checked' : '' }}
                        >
                        <label for="IsPublic" class="form-check-label">
                            Public
                        </label>
                    </div>
                    @error('IsPublic')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 col-lg-6 col-xxl-4">
                    <div class="form-check form-switch mt-4">
                        <input
                            id="IsCancelled"
                            name="IsCancelled"
                            type="checkbox"
                            value="1"
                            class="form-check-input @error('IsCancelled') is-invalid @enderror"
                            {{ old('IsCancelled', $model->IsCancelled) ? 'checked' : '' }}
                        >
                        <label for="IsCancelled" class="form-check-label">
                            Cancelled
                        </label>
                    </div>
                    @error('IsCancelled')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 col-lg-6 col-xxl-4">
                    <label for="EventDateTime" class="form-label">
                        <i class="material-icons-round align-middle">event</i>
                        Event date
                    </label>
                    <input
                        id="EventDateTime"
                        name="EventDateTime"
                        type="datetime-local"
                        value="{{ old('EventDateTime', $model->EventDateTime) }}"
                        class="form-control @error('EventDateTime') is-invalid @enderror"
                    >
                    @error('EventDateTime')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 col-lg-6 col-xxl-4">
                    <label for="PublishDateTime" class="form-label">
                        <i class="material-icons-round align-middle">today</i>
                        Publish date
                    </label>
                    <input
                        id="PublishDateTime"
                        name="PublishDateTime"
                        type="datetime-local"
                        value="{{ old('PublishDateTime', $model->PublishDateTime) }}"
                        class="form-control @error('PublishDateTime') is-invalid @enderror"
                    >
                    @error('PublishDateTime')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-12">
                    <label for="ShortDescription" class="form-label">
                        <i class="material-icons-round align-middle">description</i>
                        Short description
                    </label>
                    <textarea
                        id="ShortDescription"
                        name="ShortDescription"
                        class="form-control @error('ShortDescription') is-invalid @enderror"
                        rows="3"
                    >{{ old('ShortDescription', $model->ShortDescription) }}</textarea>
                    @error('ShortDescription')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-12">
                    <label for="ContentHTML" class="form-label">
                        <i class="material-icons-round align-middle">newspaper</i>
                        Content
                    </label>
                    <textarea
                        id="ContentHTML"
                        name="ContentHTML"
                        class="form-control @error('ContentHTML') is-invalid @enderror"
                        rows="6"
                    >{{ old('ContentHTML', $model->ContentHTML) }}</textarea>
                    @error('ContentHTML')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-12">
                    <label for="MetaDescription" class="form-label">
                        <i class="material-icons-round align-middle">feed</i>
                        Meta description
                    </label>
                    <textarea
                        id="MetaDescription"
                        name="MetaDescription"
                        class="form-control @error('MetaDescription') is-invalid @enderror"
                        rows="3"
                    >{{ old('MetaDescription', $model->MetaDescription) }}</textarea>
                    @error('MetaDescription')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-12">
                    <label for="MetaTags" class="form-label">
                        <i class="material-icons-round align-middle">subtitles</i>
                        Meta tags
                    </label>
                    <textarea
                        id="MetaTags"
                        name="MetaTags"
                        class="form-control @error('MetaTags') is-invalid @enderror"
                        rows="3"
                    >{{ old('MetaTags', $model->MetaTags) }}</textarea>
                    @error('MetaTags')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-12">
                    <label for="Notes" class="form-label">
                        <i class="material-icons-round align-middle">notes</i>
                        Notes
                    </label>
                    <textarea
                        id="Notes"
                        name="Notes"
                        class="form-control @error('Notes') is-invalid @enderror"
                        rows="3"
                    >{{ old('Notes', $model->Notes) }}</textarea>
                    @error('Notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">Edit</button>

                    <a href="/internal-events/add-attachment/{{ $model->Id }}" class="btn btn-secondary">
                        Add attachment
                    </a>
                </div>
            </div>
        </form>

        <hr>

        <h3>Attachments</h3>

        @foreach($model->InternalEventsAttachments as $item)
            <p>
                {{ $item->Attachment->Title }}
            </p>
        @endforeach
    </div>
@endsection

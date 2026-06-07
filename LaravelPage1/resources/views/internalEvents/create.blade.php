@extends ("main")
@section ("header")
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Naglowek</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a href="/internal-events/create" class="btn btn-primary"> Create new </a>
                <a href="/all" class="btn btn-primary">All</a>
            </div>
        </div>
    </div>
@endsection

@section("content")
    <div class="container">
        <div class="row gy-3">
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <form method="POST">
                    <div class="input-group">
                        <label class="input-group-text">
                            <i class="material-icons-round align-middle">label</i>
                            Title
                        </label>
                        <input name="Title" class="form-control validate">
                    </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round align-middle">link</i>
                        Link
                    </label>
                    <input name="Link" class="form-control validate">
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="row">
                    <div class="col-auto">
                        <label class="form-check-label">
                            Public
                            <i class="material-icons-round align-middle">public</i>
                        </label>
                    </div>
                    <div class="form-switch form-check col-auto">
                        <input name="IsPublic" class="form-check-input validate" type="checkbox">
                        <label class="form-check-label">
                            <i class="material-icons-round align-middle">block</i>
                            Private
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="row">
                    <div class="col-auto">
                        <label class="form-check-label">
                            Cancelled
                            <i class="material-icons-round align-middle">cancel</i>
                        </label>
                    </div>
                    <div class="form-switch form-check col-auto">
                        <input name="IsCancelled" class="form-check-input validate" type="checkbox">
                        <label class="form-check-label">
                            <i class="material-icons-round align-middle">public</i>
                            Active
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round palette-accent-text-color align-middle">event</i>
                        Event date
                    </label>
                    <input name="EventDateTime" class="form-control validate" type="date">
                </div>
            </div>
            <div class="col-md-12 col-lg-6 col-xxl-4">
                <div class="input-group">
                    <label class="input-group-text">
                        <i class="material-icons-round palette-accent-text-color align-middle">today</i>
                        Publish date
                    </label>
                    <input name="PublishDateTime" class="form-control validate" type="date">
                </div>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">description</i>
                    Short description
                </label>
                <textarea name="ShortDescription" class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">newspaper</i>
                    Content
                </label>
                <textarea name="ContentHTML" class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">feed</i>
                    Meta description
                </label>
                <textarea name="MetaDescription" class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">subtitles</i>
                    Meta tags
                </label>
                <textarea name="MetaTags"class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <label class="form-label">
                    <i class="material-icons-round palette-accent-text-color align-middle">notes</i>
                    Notes
                </label>
                <textarea name="Notes" class="form-control validate"></textarea>
            </div>
            <div class="col-sm-12">
                <button type="submit" class="btn btn-primary">Create </button>
                </form>
            </div>
        </div>
    </div>
@endsection



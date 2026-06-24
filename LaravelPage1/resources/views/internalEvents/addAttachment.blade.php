@extends('main')

@section('content')
<div class="container">

    <form method="POST">
        @csrf

        <label>Attachment</label>

        <select
            name="AttachmentId"
            class="form-control"
        >
            @foreach($attachments as $attachment)
                <option value="{{ $attachment->Id }}">
                    {{ $attachment->Title }}
                </option>
            @endforeach
        </select>

        <br>

        <button
            type="submit"
            class="btn btn-primary"
        >
            Add attachment
        </button>

    </form>

</div>
@endsection
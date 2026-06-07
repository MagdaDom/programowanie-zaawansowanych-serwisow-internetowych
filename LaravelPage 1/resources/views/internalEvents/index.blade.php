@extends('main')

@section('content')

@foreach($models as $model)
<div>{{ $model->Title }}</div>
@endforeach

@endsection
@extends('layouts.app')

@section('content')
    <div class="container">
        <create :data="{{ $items }}" name="{{ $name }}" id="{{ $id }}" auth="{{ $auth }}"></create>
    </div>
@endsection

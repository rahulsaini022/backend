@extends('layouts.app')

@section('content')
@if(session()->has('error'))
    <p class="alert alert-info">
        {{ session()->get('error') }}
    </p>
@endif




@endsection
@extends('adminPanel.layouts.app')
@section('content')
    <div class="app" id="app">
        <show-tender :id="{{$id}}"></show-tender>
        <div>
@endsection

@extends('adminPanel.layouts.app')

@section('content')
    <div class="app" id="app">
        <add-news-component :item="{{$item}}"></add-news-component>
        <div>
@endsection

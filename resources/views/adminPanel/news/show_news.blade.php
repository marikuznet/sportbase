@extends('adminPanel.layouts.app')

@section('content')
    <div class="app" id="app">
        <show-news-component :item="{{$item}}"></show-news-component>
        <div>
@endsection

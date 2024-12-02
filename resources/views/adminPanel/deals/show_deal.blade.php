@extends('adminPanel.layouts.app')
@section('content')
    <div class="app" id="app">
        <v-admin-show-deal :id="{{$id}}"></v-admin-show-deal>
        <div>
@endsection

@extends('adminPanel.layouts.app')

@section('content')
    <div class="app" id="app">
        <admin-object-show :sport-object="{{$object_data}}"></admin-object-show>
        <div>
@endsection

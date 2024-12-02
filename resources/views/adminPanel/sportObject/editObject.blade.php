@extends('adminPanel.layouts.app')

@section('content')
    <div class="app" id="app">
        <admin-object-edit object-data="{{$object_data}}"></admin-object-edit>
        <div>
@endsection

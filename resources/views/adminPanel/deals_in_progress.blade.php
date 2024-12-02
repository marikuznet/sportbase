@extends('adminPanel.layouts.app')

@section('content')
<div class="app" id="app">
    <deals-component :is-processing="false"></deals-component>
<div>
@endsection

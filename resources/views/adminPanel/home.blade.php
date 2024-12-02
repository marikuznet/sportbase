@extends('adminPanel.layouts.app')
@section('content')
    <div class="app" id="app">
        <users-component :is-customer="false"></users-component>
    </div>
@endsection

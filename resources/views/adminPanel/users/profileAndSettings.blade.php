@extends('adminPanel.layouts.app')
@section('content')
    <admin-stepper-profile :user-data="{{$user_data}}"></admin-stepper-profile>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <p>Нажмите на кнопку ниже, чтобы подтвердить почту.</p>
                        @component('mail::button', ['token' => $token]))
                            Подтвердить почту
                        @endcomponent
                        <p>Если кнопка не работает, перейдите по ссылке ... </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

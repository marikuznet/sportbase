@component('mail::message')
# Подтвердите Вашу Email почту

Нажмите на кнопку ниже, чтобы подтвердить почту.

@component('mail::button', ['id' => $userEmail['id'], 'url' => route('verify-email', ['id' => $userEmail['id'], 'token' => $userEmail['verify_token']])])
Подтвердить почту
@endcomponent
<p>Если кнопка не работает, перейдите по ссылке {{ route('verify-email', ['id' => $userEmail['id'], 'token' => $userEmail['verify_token']]) }} </p>

С уважением, <br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# {{ __('auth.reset-password') }}

{{ __('auth.hello-username',['username' => $user->user_username]) }}<br>
{{ __('auth.text1-reset-password-mail',['app_name' => config('app.name')]) }}

@component('mail::button', ['url' => route('reset.password', ['locale'=> config('app.locale'),'username' => $user->user_username,'token' => $token->token])])
{{ __('auth.reset-password') }}
@endcomponent

{{ __('auth.text2-reset-password-mail',['expired_at' => date_format($token->expired_at,'H:i - F j, Y')]) }}<br><br>
{{ __('auth.thanks') }},<br>
{{ config('app.name') }}
@endcomponent

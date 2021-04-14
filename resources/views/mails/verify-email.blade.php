@component('mail::message')
# {{ __('auth.verify-email') }}

{{ __('auth.hello-username',['username' => $user->user_username]) }}<br>
{{ __('auth.text1-verify-email-mail',['app_name' => config('app.name')]) }}

@component('mail::button', ['url' => route('verify.email.process', ['locale'=> config('app.locale'), 'username'=>$user->user_username, 'token'=>$token->token] )])
{{ __('auth.verify-email') }}
@endcomponent

{{ __('auth.text2-verify-email-mail',['expired_at' => date_format($token->expired_at,'H:i - F j, Y')]) }}<br><br>
{{ __('auth.thanks') }},<br>
{{ config('app.name') }}
@endcomponent

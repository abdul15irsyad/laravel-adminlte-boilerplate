@component('mail::message')
# {{ __('auth.reset-password-success') }}

{{ __('auth.hello-username',['username' => $user->user_username]) }}<br>
{{ __('auth.reset-password-success-alert') }}.

{{ __(('auth.thanks')) }},<br>
{{ config('app.name') }}
@endcomponent

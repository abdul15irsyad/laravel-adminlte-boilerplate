@component('mail::message')
# {{ __('auth.email-verification-success') }}

{{ __('auth.hello-username',['username' => $user->user_username]) }}<br>
{{ __('auth.your-email-has-been-verified') }}.

{{ __('auth.thanks') }}
{{ config('app.name') }}
@endcomponent

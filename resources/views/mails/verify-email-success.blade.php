@component('mail::message')
# Email Verification Success

Hello, {{ $user->user_username }}<br>
Your email has been verified.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

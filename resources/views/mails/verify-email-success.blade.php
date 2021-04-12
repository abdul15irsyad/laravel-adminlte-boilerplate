@component('mail::message')
# Email Verification Success

Hello, {{ $user->user_username }}<br>
Your email has been verified, please use your new email on next login

Thanks,<br>
{{ config('app.name') }}
@endcomponent

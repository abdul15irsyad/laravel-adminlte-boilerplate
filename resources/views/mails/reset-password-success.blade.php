@component('mail::message')
# Reset Password Success

Hello, {{ $user->user_username }}<br>
Your password has been successfully changed.

Thanks,<br>
{{ config('app.name') }}
@endcomponent

@component('mail::message')
# Reset Password Success

Hello, {{ $user->user_username }}<br>
Your password is successfully changed, please login using your new password

Thanks,<br>
{{ config('app.name') }}
@endcomponent

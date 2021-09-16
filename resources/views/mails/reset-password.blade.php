@component('mail::message')
# Reset Password

Hello, {{ $user->user_username }}<br>
You recently asked to reset your password, click the button below to reset.

@component('mail::button', ['url' => route('reset-password', ['username' => $user->user_username,'token' => $token->token])])
Reset Password
@endcomponent

This link only valid until {{ date_format($token->expired_at,'H:i - F j, Y') }}, if you do not request a password reset, please ignore this email.<br><br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent

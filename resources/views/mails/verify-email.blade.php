@component('mail::message')
# Email Verification

Hello, {{ $user->user_username }}<br>
Please click button below to verify your email.

@component('mail::button', ['url' => route('verify-email-process', ['username'=>$user->user_username, 'token'=>$token->token] )])
Verify Email
@endcomponent

This link only valid until {{ date_format($token->expired_at,'H:i - F j, Y') }}.<br><br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent

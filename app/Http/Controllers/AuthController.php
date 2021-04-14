<?php

namespace App\Http\Controllers;

use App\Mail\UserMail;
use App\Notifications\UserNotification;
use App\Models\Token;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use TokenHelper;

class AuthController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct();
    }

    public function login()
    {
        $data = [
            'title' => __('auth.login')
        ];
        return view('contents.login', $data);
    }

    public function login_process(Request $request)
    {
        $field = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $data = [
            'user_' . $field => $request->input('username'),
            'password'  => $request->input('password'),
        ];

        if (!auth('web')->attempt($data)) {
            return redirect()
                ->route('login',['locale' => config('app.locale')])
                ->withInput()
                ->with('type', 'warning')
                ->with('message', __('auth.wrong-credential'));
        }
        return redirect()->route('dashboard',['locale' => config('app.locale')]);
    }

    public function verify_email_process(Request $request)
    {
        $username = $request->input('username');
        $token = $request->input('token');

        $user = User::where('user_username',$username)->first();
        // if user not found
        if(!$user){
            return redirect()
                ->route('forgot.password',['locale' => config('app.locale')])
                ->with('type', 'warning')
                ->with('message', __('auth.invalid-link'));
        }

        $token = Token::where('token', $token)
            ->where('token_status', 'Y')
            ->where('used_at',null)
            ->where('token_type', 'email_verification')
            ->first();
        
        // if token invalid
        if(!$token){
            return redirect()
                ->route('forgot.password',['locale' => config('app.locale')])
                ->with('type', 'warning')
                ->with('message', __('auth.invalid-link'));
        }

        // if token expired
        if(Carbon::now()->gt($token->expired_at)){
            $token->token_status = 'N';
            $token->save();
            return redirect()
                ->route('forgot.password',['locale' => config('app.locale')])
                ->with('type', 'warning')
                ->with('message', __('auth.link-expired'));
        }

        // update token
        $token->token_status = 'N';
        $token->used_at = Carbon::now();
        $token->save();

        // update user password
        $user->email_verified_at = Carbon::now();
        $user->save();

        // notify user
        $data = [
            'database' => [
                'title' => __('auth.email-verification-success'),
                'desc' => __('auth.your-email-has-been-verified')
            ],
            'mail' => [
                'subject' => __('auth.email-verification-success'),
                'markdown' => 'mails.verify-email-success',
                'user' => $user,
            ]
        ];
        $user->notify(new UserNotification($data));

        return redirect()
            ->route('login',['locale' => config('app.locale')])
            ->with('type', 'success')
            ->with('message', __('auth.your-email-has-been-verified'));
    }

    public function forgot_password()
    {
        $data = [
            'title' => __('auth.forgot-password')
        ];
        return view('contents.forgot-password', $data);
    }

    public function forgot_password_process(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $email = $request->input('email');

        $user = User::where('user_email', $email)->first();
        
        // if no user with email
        if(!$user){
            return redirect()
                ->route('forgot.password',['locale' => config('app.locale')])
                ->withInput()
                ->with('type', 'warning')
                ->with('message', __('auth.email-not-found'));
        }

        if(!$user->email_verified_at){
            return redirect()
                ->route('forgot.password',['locale' => config('app.locale')])
                ->withInput()
                ->with('type', 'warning')
                ->with('message', __('auth.verify-first'));
        }
        
        // generate token
        $new_token = TokenHelper::generate_token('forgot_password');
        
        // if user have previous token
        $previous_token = Token::where('token_type', 'forgot_password')->where('token_status', 'Y')->where('used_at',null)->where('user_id', $user['id'])->first();
        if ($previous_token) {
            $previous_token->token_status = 'N';
            $previous_token->save();
        }
        
        // add token to database
        $expired_at = Carbon::now()->addMinutes(60);
        $token = new Token;
        $token->token = $new_token;
        $token->token_type = 'forgot_password';
        $token->user_id = $user->id;
        $token->expired_at = $expired_at;
        $token->save();
        
        // send token to user email
        $data = [
            'subject' => __('auth.reset-password'),
            'user' => $user,
            'token' => $token,
            'markdown' => 'mails.reset-password',
        ];
        Mail::to($user->user_email)->send(new UserMail($data));
        
        return redirect()
            ->route('forgot.password',['locale' => config('app.locale')])
            ->withInput()
            ->with('type', 'success')
            ->with('message', __('auth.forgot-password-success'));
    }

    public function reset_password(Request $request)
    {
        $token = $request->input('token');
        $username = $request->input('username');
        
        $user = User::where('user_username',$username)->first();
        // if user not found
        if(!$user){
            return redirect()
                ->route('forgot.password',['locale' => config('app.locale')])
                ->with('type', 'warning')
                ->with('message', __('auth.invalid-link'));
        }

        $token = Token::where('token', $token)
            ->where('token_status', 'Y')
            ->where('used_at',null)
            ->where('token_type', 'forgot_password')
            ->first();
        
        // if token invalid
        if(!$token){
            return redirect()
                ->route('forgot.password',['locale' => config('app.locale')])
                ->with('type', 'warning')
                ->with('message', __('auth.invalid-link'));
        }

        // if token expired
        if(Carbon::now()->gt($token->expired_at)){
            $token->token_status = 'N';
            $token->save();
            return redirect()
                ->route('forgot.password',['locale' => config('app.locale')])
                ->with('type', 'warning')
                ->with('message', __('auth.link-expired'));
        }

        // token valid
        $data = [
            'token' => $token,
            'title' => _('auth.reset-password')
        ];
        return view('contents.reset-password', $data);
    }

    public function reset_password_process(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])./',
            'confirm_password' => 'same:new_password'
        ]);

        $token = $request->input('token');
        $password = $request->input('new_password');
        
        $token = Token::where('token', $token)
            ->where('token_status', 'Y')
            ->where('used_at',null)
            ->where('token_type', 'forgot_password')
            ->first();
        // if token invalid
        if(!$token){
            return redirect()
                ->route('forgot.password')
                ->with('type', 'warning')
                ->with('message', __('auth.invalid-link'));
        }

        // if token expired
        if(Carbon::now()->gt($token->expired_at)){
            $token->token_status = 'N';
            $token->save();
            return redirect()
                ->route('forgot.password')
                ->with('type', 'warning')
                ->with('message', __('auth.link-expired'));
        }

        // update token
        $token->token_status = 'N';
        $token->used_at = Carbon::now();
        $token->save();

        // update user password
        $user->user_password = Hash::make($password);
        $user->save();
        
        // notify user
        $data = [
            'database' => [
                'title' => __('auth.reset-password-success'),
                'desc' => __('auth.your-password-has-been-successfully-changed')
            ],
            'mail' => [
                'subject' => __('auth.reset-password-success'),
                'markdown' => 'mails.reset-password-success',
                'user' => $user,
            ]
        ];
        $user->notify(new UserNotification($data));

        return redirect()
            ->route('login', ['locale' => config('app.locale')])
            ->with('type', 'success')
            ->with('message', __('auth.reset-password-success-alert'));
    }

    public function logout()
    {
        auth('web')->logout();
        return redirect()->route('login', ['locale' => config('app.locale')]);
    }
}

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
    public function login()
    {
        $data = [
            'title' => 'Login'
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
                ->route('login')
                ->withInput()
                ->with('type', 'warning')
                ->with('message', 'Username or Password is incorrect');
        }
        return redirect()->route('dashboard');
    }

    public function verify_email_process(Request $request)
    {
        $username = $request->input('username');
        $token = $request->input('token');

        $user = User::where('user_username',$username)->first();
        // if user not found
        if(!$user){
            return redirect()
                ->route('forgot.password')
                ->with('type', 'warning')
                ->with('message', 'Invalid link');
        }

        $token = Token::where('token', $token)
            ->where('token_status', 'Y')
            ->where('used_at',null)
            ->where('token_type', 'email_verification')
            ->first();
        
        // if token invalid
        if(!$token){
            return redirect()
                ->route('forgot.password')
                ->with('type', 'warning')
                ->with('message', 'Invalid link');
        }

        // if token expired
        if(Carbon::now()->gt($token->expired_at)){
            $token->token_status = 'N';
            $token->save();
            return redirect()
                ->route('forgot.password')
                ->with('type', 'warning')
                ->with('message', 'Link expired, please make a new forgot password request');
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
                'title' => 'Email Verification Success',
                'desc' => 'Your email has been activated'
            ],
            'mail' => [
                'subject' => 'Email Verification Success',
                'markdown' => 'mails.verify-email-success',
                'user' => $user,
            ]
        ];
        $user->notify(new UserNotification($data));

        return redirect()
            ->route('login')
            ->with('type', 'success')
            ->with('message', 'Your email has been activated');
    }

    public function forgot_password()
    {
        $data = [
            'title' => 'Forgot Password'
        ];
        return view('contents.forgot-password', $data);
    }

    public function forgot_password_process(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ], [
            'email.required' => 'email is required',
            'email.email' => 'use email format, eg: example@email.com',
        ]);

        $email = $request->input('email');

        $user = User::where('user_email', $email)->first();
        
        // if no user with email
        if(!$user){
            return redirect()
                ->route('forgot.password')
                ->withInput()
                ->with('type', 'warning')
                ->with('message', 'Email not linked with any user');
        }

        if(!$user->email_verified_at){
            return redirect()
                ->route('forgot.password')
                ->withInput()
                ->with('type', 'warning')
                ->with('message', 'Verify your email first in your email');
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
            'subject' => 'Reset Password',
            'user' => $user,
            'token' => $token,
            'markdown' => 'mails.reset-password',
        ];
        Mail::to($user->user_email)->send(new UserMail($data));
        
        return redirect()
            ->route('forgot.password')
            ->withInput()
            ->with('type', 'success')
            ->with('message', 'Email sent, please check your email');
    }

    public function reset_password(Request $request)
    {
        $token = $request->input('token');
        $username = $request->input('username');
        
        $user = User::where('user_username',$username)->first();
        // if user not found
        if(!$user){
            return redirect()
                ->route('forgot.password')
                ->with('type', 'warning')
                ->with('message', 'Invalid link');
        }

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
                ->with('message', 'Invalid link');
        }

        // if token expired
        if(Carbon::now()->gt($token->expired_at)){
            $token->token_status = 'N';
            $token->save();
            return redirect()
                ->route('forgot.password')
                ->with('type', 'warning')
                ->with('message', 'Link expired, please make a new forgot password request');
        }

        // token valid
        $data = [
            'token' => $token,
            'title' => 'Reset Password'
        ];
        return view('contents.reset-password', $data);
    }

    public function reset_password_process(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])./',
            'confirm_password' => 'same:new_password'
        ], [
            'new_password.required' => 'Password is required',
            'new_password.min' => 'Minimum password 8 characters',
            'new_password.regex' => 'Passwords must contain lowercase letters (A-Z), uppercase (A-Z), and numbers (0-9)',
            'confirm_password.same' => 'Confirm Password didn\'t match',
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
                ->with('message', 'Invalid link');
        }

        // if token expired
        if(Carbon::now()->gt($token->expired_at)){
            $token->token_status = 'N';
            $token->save();
            return redirect()
                ->route('forgot.password')
                ->with('type', 'warning')
                ->with('message', 'Link expired, please make a new forgot password request');
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
                'title' => 'Reset Password Success',
                'desc' => 'Your password has been successfully changed'
            ],
            'mail' => [
                'subject' => 'Reset Password Success',
                'markdown' => 'mails.reset-password-success',
                'user' => $user,
            ]
        ];
        $user->notify(new UserNotification($data));

        return redirect()
            ->route('login')
            ->with('type', 'success')
            ->with('message', 'Password successfully changed, please login with a new password');
    }

    public function logout()
    {
        auth('web')->logout();
        return redirect()->route('login');
    }
}

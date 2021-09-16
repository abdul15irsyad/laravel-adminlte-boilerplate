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
use TokenHelper, MailHelper;

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
        $username = $request->input('username');
        $password = $request->input('password');
        $field = filter_var($username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $data = [
            'user_' . $field => $username,
            'password'  => $password,
        ];

        // if username or password incorrect
        $user = User::where('user_'.$field,$username)->first();
        if($user){
            $auth = Hash::check($password, $user->user_password);
            if($auth){
                // if($user->email_verified_at==null){
                //     return redirect()
                //         ->route('login')
                //         ->withInput()
                //         ->with('type', 'warning')
                //         ->with('message', 'Verify your email first');
                // }
                
                // if account wasn't active
                if($user->user_status!='Active'){
                    return redirect()
                        ->back()
                        ->withInput()
                        ->with('type', 'warning')
                        ->with('message', 'Your account is inactive, please contact Administrator');
                }

                auth('web')->attempt($data);
                $user = User::findOrFail(auth('web')->user()->id);
                activity()->log($user->user_username.' has logged in');

                return redirect()->route('dashboard');
            }
        }
        
        return redirect()
            ->back()
            ->withInput()
            ->with('type', 'warning')
            ->with('message', 'Username or password is incorrect');
    }

    public function verify_email_process(Request $request)
    {
        $username = $request->input('username');
        $token = $request->input('token');

        $user = User::where('user_username', $username)->first();
        // if user not found
        if (!$user) {
            return redirect()
                ->route('forgot-password')
                ->with('type', 'warning')
                ->with('message', 'Invalid link');
        }

        $token = Token::where('token', $token)
            ->where('token_status', 'Y')
            ->where('used_at', null)
            ->where('token_type', 'email_verification')
            ->first();

        // if token invalid
        if (!$token) {
            return redirect()
                ->route('forgot-password')
                ->with('type', 'warning')
                ->with('message', 'Invalid link');
        }

        // if token expired
        if (Carbon::now()->gt($token->expired_at)) {
            $token->token_status = 'N';
            $token->save();
            return redirect()
                ->route('forgot-password')
                ->with('type', 'warning')
                ->with('message', 'Link expired, please make a new request');
        }

        // update token
        $token->token_status = 'N';
        $token->used_at = Carbon::now();
        $token->save();

        // assign email verified date
        $user->email_verified_at = Carbon::now();
        $user->save();

        // // notify user
        // $data = [
        //     'database' => [
        //         'title' => 'Email Verification Success',
        //         'desc' => 'Your email has been verified'
        //     ],
        //     'mail' => [
        //         'subject' => 'Email Verification Success',
        //         'markdown' => 'mails.verify-email-success',
        //         'user' => $user,
        //     ]
        // ];
        // $user->notify(new UserNotification($data));

        return redirect()
            ->route('login')
            ->with('type', 'success')
            ->with('message', 'Your email has been verified');
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
        ]);

        $email = $request->input('email');

        $user = User::where('user_email', $email)->first();

        // if no user with email
        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('type', 'warning')
                ->with('message', 'Email not found');
        }

        // if user's email not verified
        if (!$user->email_verified_at) {
            return redirect()
                ->back()
                ->withInput()
                ->with('type', 'warning')
                ->with('message', 'Verify your email first');
        }

        // create new token and then send to email
        $data = [
            'subject' => 'Reset Password',
            'markdown' => 'mails.reset-password',
        ];
        MailHelper::send_token_to_user($user,'forgot_password',$data);

        return redirect()
            ->back()
            ->withInput()
            ->with('type', 'success')
            ->with('message', 'Email sent, please check your email');
    }

    public function reset_password(Request $request)
    {
        $token = $request->input('token');
        $username = $request->input('username');

        $user = User::where('user_username', $username)->first();
        // if user not found
        if (!$user) {
            return redirect()
                ->route('forgot-password')
                ->with('type', 'warning')
                ->with('message', 'Invalid link');
        }

        $token = Token::where('token', $token)
            ->where('token_status', 'Y')
            ->where('used_at', null)
            ->where('token_type', 'forgot_password')
            ->first();

        // if token invalid
        if (!$token) {
            return redirect()
                ->route('forgot-password')
                ->with('type', 'warning')
                ->with('message', 'Invalid link');
        }

        // if token expired
        if (Carbon::now()->gt($token->expired_at)) {
            $token->token_status = 'N';
            $token->save();
            return redirect()
                ->route('forgot-password')
                ->with('type', 'warning')
                ->with('message', 'Link expired, please make a new request');
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
        ]);

        $token = $request->input('token');
        $password = $request->input('new_password');

        $token = Token::where('token', $token)
            ->where('token_status', 'Y')
            ->where('used_at', null)
            ->where('token_type', 'forgot_password')
            ->first();
        // if token invalid
        if (!$token) {
            return redirect()
                ->route('forgot-password')
                ->with('type', 'warning')
                ->with('message', 'Invalid link');
        }

        // if token expired
        if (Carbon::now()->gt($token->expired_at)) {
            $token->token_status = 'N';
            $token->save();
            return redirect()
                ->route('forgot-password')
                ->with('type', 'warning')
                ->with('message', 'Link expired, please make a new request');
        }

        // update token
        $token->token_status = 'N';
        $token->used_at = Carbon::now();
        $token->save();

        // update user password
        $user = User::where('user_username', $token->user->user_username)->first();
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

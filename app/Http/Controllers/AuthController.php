<?php

namespace App\Http\Controllers;

use App\Mail\UserMail;
use App\Notifications\UserNotification;
use App\Token;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function index()
    {
        $data = [
            'title' => 'Masuk'
        ];
        return view('content.login', $data);
    }

    public function login(Request $request)
    {
        $field = filter_var($request->input('username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $data = [
            'user_' . $field => $request->input('username'),
            'password'  => $request->input('password'),
        ];

        if (auth('web')->attempt($data)) {
            return redirect()->to(route('dashboard'));
        } else {
            return redirect()
                ->route('login')
                ->withInput()
                ->with('alert_type', 'warning')
                ->with('message', 'username atau password salah');
        }
    }

    public function forgot_password()
    {
        $data = [
            'title' => 'Lupa Kata Sandi'
        ];
        return view('content.forgot-password', $data);
    }

    public function forgot_password_process(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
        ], [
            'email.required' => 'email harus diisi',
            'email.email' => 'gunakan format email (example@email.com)',
        ]);

        $email = $request->input('email');

        $user = User::where('user_email', $email)->first();
        if ($user) {
            do {
                $new_token = Str::random(64);
                // $expired_at = date("Y-m-d H:i:s", strtotime('+1 hours'));
                $token_exist = Token::where('token', $new_token)->where('token_type', 'forgot_password')->where('token_status', 'Y')->first();
            } while ($token_exist !== null);
            // if user have previous token
            $previous_token = Token::where('token_type', 'forgot_password')->where('token_status', 'Y')->where('token_id_user', $user['id_user'])->first();
            if ($previous_token) {
                $previous_token->token_status = 'N';
                $previous_token->save();
            }
            // send token to user email
            $data = [
                'subject' => 'Atur Ulang Kata Sandi',
                'view' => 'forgot-password',
                'username' => $user->user_username,
                'link' => route('reset.password') . '/' . $new_token
            ];
            Mail::to($user->user_email)->send(new UserMail($data));
            // add token to database
            $token = new Token;
            $token->token = $new_token;
            $token->token_type = 'forgot_password';
            $token->token_id_user = $user['id_user'];
            $token->save();

            return redirect()
                ->route('forgot.password')
                ->withInput()
                ->with('alert_type', 'success')
                ->with("message", "email terkirim, silakan cek email anda");
        } else {
            return redirect()
                ->route('forgot.password')
                ->withInput()
                ->with('alert_type', 'warning')
                ->with("message", "email tidak ditemukan");
        }
    }

    public function reset_password($token = null)
    {
        $token = Token::where('token', $token)->where('token_status', 'Y')->where('token_type', 'forgot_password')->first();
        if ($token) {
            $now = Carbon::now();
            $diff = $token->created_at->diffInMinutes($now);
            if ($diff <= 60 && $token->token_status == 'Y') {
                // token valid
                $data = [
                    'token' => $token->token,
                    'title' => 'Ubah Kata Sandi'
                ];
                return view('content.reset-password', $data);
            } else {
                // token expired
                $token->token_status = 'N';
                $token->save();
            }
        }
        // token invalid
        return redirect()
            ->route('forgot.password')
            ->with('alert_type', 'warning')
            ->with("message", "link tidak valid, harap buat permintaan lupa kata sandi baru");
    }

    public function reset_password_process(Request $request)
    {
        $this->validate($request, [
            'new_password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])./',
            'confirm_password' => 'same:new_password'
        ], [
            'new_password.required' => 'kata sandi harus diisi',
            'new_password.min' => 'kata sandi minimal 8 karakter',
            'new_password.regex' => 'kata sandi harus mengandung huruf kecil (a-z), huruf besar (A-Z), dan angka (0-9)',
            'confirm_password.same' => 'konfirmasi kata sandi berbeda',
        ]);

        $token = $request->input('token');
        $password = $request->input('new_password');

        $token = Token::where('token', $token)->where('token_status', 'Y')->where('token_type', 'forgot_password')->first();
        if ($token) {
            // update token
            $token->token_status = 'N';
            $token->save();
            $now = Carbon::now();
            $diff = $token->created_at->diffInMinutes($now);
            if ($diff <= 60) {
                // update user password
                $user = User::find($token->token_id_user)->first();
                $user->user_password = Hash::make($password);
                $user->save();
                // notify user
                $data = [
                    'database' => [
                        'title' => 'Berhasil Mengubah Kata Sandi',
                        'desc' => 'Kata sandi anda telah berhasil diubah'
                    ],
                    'mail' => [
                        'subject' => 'Berhasil Mengubah Kata Sandi',
                        'view' => 'reset-password',
                        'username' => $user->user_username,
                    ]
                ];
                $user->notify(new UserNotification($data));

                return redirect()
                    ->route('login')
                    ->with('alert_type', 'success')
                    ->with("message", "kata sandi berhasil diubah, silakan masuk dengan kata sandi baru");
            }
        }
        // token invalid
        return redirect()
            ->route('forgot.password')
            ->with('alert_type', 'warning')
            ->with("message", "link tidak valid, harap buat permintaan lupa kata sandi baru");
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

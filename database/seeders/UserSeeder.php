<?php

namespace Database\Seeders;

use DB, Hash, TokenHelper;
use Carbon\Carbon;
use App\Mail\UserMail;
use App\Models\User;
use App\Models\Token;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Mail;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rows = [
            [
                "user_name" => "Irsyad Abdul",
                "user_username" => "irsyadabdul",
                "user_email" => "abdulirsyad15@gmail.com",
                "user_password" => "Qwerty123",
                "role_id" => 1,
            ],
            [
                "user_name" => "Dota Lubda",
                "user_username" => "dotalubda",
                "user_email" => "dotalubda225@gmail.com",
                "user_password" => "Qwerty123",
                "role_id" => 2,
            ],
        ];

        foreach($rows as $row){
            $row['user_password'] = Hash::make($row['user_password']);
			DB::table("users")->insert($row);
            // send activation token to user
            $user = User::where('user_username',$row['user_username'])->first();
            // generate token
            $token = TokenHelper::generate_token('email_verification');
            $this->send_email_verification_link($user,$token);
		}
    }

    public function send_email_verification_link($user,$new_token)
    {
        // add token to database
        $expired_at = Carbon::now()->addMinutes(60);
        $token = new Token;
        $token->token = $new_token;
        $token->token_type = 'email_verification';
        $token->user_id = $user->id;
        $token->expired_at = $expired_at;
        $token->save();
        $data = [
            'subject' => 'Email Verification',
            'user' => $user,
            'token' => $token,
            'markdown' => 'mails.verify-email',
        ];
        Mail::to($user->user_email)->send(new UserMail($data));
    }
}

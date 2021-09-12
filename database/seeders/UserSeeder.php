<?php

namespace Database\Seeders;

use DB, Hash, TokenHelper, MailHelper;
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
        $verify_email = false;
        $rows = [
            [
                "user_name" => "Irsyad Abdul",
                "user_username" => "irsyadabdul",
                "user_email" => "abdulirsyad15@gmail.com",
                "email_verified_at" => $verify_email ? null : Carbon::now(),
                "user_password" => "Qwerty123",
                "role_id" => 1,
            ],
            [
                "user_name" => "Dota Lubda",
                "user_username" => "dotalubda",
                "user_email" => "dotalubda225@gmail.com",
                "email_verified_at" => $verify_email ? null : Carbon::now(),
                "user_password" => "Qwerty123",
                "role_id" => 2,
            ],
        ];

        foreach($rows as $row){
            $row['user_password'] = Hash::make($row['user_password']);
			DB::table("users")->insert($row);
            if($verify_email){
                // send activation token to user email
                $user = User::where('user_username',$row['user_username'])->first();

                // create new token and then send to email
                $data = [
                    'subject' => 'Email Verification',
                    'markdown' => 'mails.verify-email',
                ];
                MailHelper::send_token_to_user($user,'email_verification',$data);
            }
		}
    }
}
